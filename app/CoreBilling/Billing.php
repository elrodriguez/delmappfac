<?php

namespace App\CoreBilling;

use App\CoreBilling\Helpers\QrCode\QrCodeGenerate;
use App\CoreBilling\Helpers\Xml\XmlFormat;
use App\CoreBilling\Helpers\Xml\XmlHash;
use App\CoreBilling\Helpers\Storage\StorageDocument;
use App\CoreBilling\WS\Client\WsClient;
use App\CoreBilling\WS\Services\BillSender;
use App\CoreBilling\WS\Services\ConsultCdrService;
use App\CoreBilling\WS\Services\ExtService;
use App\CoreBilling\WS\Services\SummarySender;
use App\CoreBilling\WS\Services\SunatEndpoints;
use App\CoreBilling\WS\Signed\XmlSigned;
use App\CoreBilling\WS\Validator\XmlErrorCodeProvider;
use App\Models\Catalogue\BankAccount;
use App\Models\Master\Cash;
use App\Models\Master\CashDocument;
use App\Models\Master\Company;
use App\Models\Master\Document;
use App\Models\Master\DocumentItem;
use App\Models\Master\DocumentPayment;
use App\Models\Master\Invoices;
use App\Models\Master\Parameter;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Item;
use App\Models\Warehouse\ItemWarehouse;
use App\Models\Warehouse\Warehouse;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;


class Billing
{
    use StorageDocument;

    const SENT = '03';
    const ACCEPTED = '05';
    const OBSERVED = '07';
    const REJECTED = '09';
    const CANCELING = '13';
    const VOIDED = '11';

    protected $configuration;
    protected $company;
    protected $isDemo;
    protected $isOse;
    protected $signer;
    protected $wsClient;
    protected $document;
    protected $type;
    protected $actions;
    protected $xmlUnsigned;
    protected $xmlSigned;
    protected $pathCertificate;
    protected $soapUsername;
    protected $soapPassword;
    protected $endpoint;
    protected $response;
    protected $apply_change;
    protected $sunat_alternate_server;
    protected $base_pdf_template;
    protected $format_pdf = 'a4';
    protected $route;
    protected $warehouse_id;

    public function __construct()
    {
        $this->sunat_alternate_server = Parameter::where('id_parameter','PRT004SRS')->first()->value_default;
        $this->base_pdf_template = Parameter::where('id_parameter','PRT003THM')->first()->value_default;
        $this->company = Company::first();
        $this->isDemo = ($this->company->soap_type_id === '01')?true:false;
        $this->isOse = ($this->company->soap_send_id === '02')?true:false;
        $this->signer = new XmlSigned();
        $this->wsClient = new WsClient();
        $this->warehouse_id = Warehouse::where('establishment_id',Auth::user()->establishment_id)->first()->id;
        $this->setDataSoapType();
    }

    public function setDocument($document)
    {
        $this->document = $document;
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function save($inputs)
    {
        $this->actions = array_key_exists('actions', $inputs)?$inputs['actions']:[];
        //dd($this->actions);
        $this->type = $inputs['type'];
        $this->route = $inputs['route'];

        switch ($this->type) {
            case 'debit':
            case 'credit':
                $document = Document::create($inputs);
                foreach ($inputs['items'] as $row) {
                    $document->items()->create($row);
                }
                $document->note()->create($inputs['note']);
                $this->document = Document::find($document->id);
                break;
            case 'invoice':
                $document = Document::create($inputs);
                $this->savePayments($document, $inputs['payments']);
                //$this->saveFee($document, $inputs['fee']);
                foreach ($inputs['items'] as $row) {
                    $document->items()->create($row);
                    ItemWarehouse::where('item_id',$row['item_id'])
                        ->where('warehouse_id',$this->warehouse_id)
                        ->decrement('stock',$row['quantity']);
                    Item::where('id',$row['item_id'])->increment('stock', $row['quantity']);
                    InventoryKardex::create([
                        'date_of_issue' => Carbon::now()->format('Y-m-d'),
                        'item_id' => $row['item_id'],
                        'inventory_kardexable_id' => $document->id,
                        'inventory_kardexable_type' => Document::class,
                        'warehouse_id' => $this->warehouse_id,
                        'quantity'=> (-$row['quantity'])
                    ]);
                }
                $this->updatePrepaymentDocuments($inputs);
                //if($inputs['hotel']) $document->hotel()->create($inputs['hotel']);
                //if($inputs['transport']) $document->transport()->create($inputs['transport']);
                $document->invoice()->create($inputs['invoice']);
                $this->saveCashDocument($document->id,'invoice');
                $this->document = Document::find($document->id);
                break;
            case 'summary':
                // $document = Summary::create($inputs);
                // foreach ($inputs['documents'] as $row) {
                //     $document->documents()->create($row);
                // }
                // $this->document = Summary::find($document->id);
                break;
            case 'voided':
                // $document = Voided::create($inputs);
                // foreach ($inputs['documents'] as $row) {
                //     $document->documents()->create($row);
                // }
                // $this->document = Voided::find($document->id);
                break;
            case 'retention':
                // $document = Retention::create($inputs);
                // foreach ($inputs['documents'] as $row) {
                //     $document->documents()->create($row);
                // }
                // $this->document = Retention::find($document->id);
                break;
            case 'perception':
                // $document = Perception::create($inputs);
                // foreach ($inputs['documents'] as $row) {
                //     $document->documents()->create($row);
                // }
                // $this->document = Perception::find($document->id);
                break;
            default:
                // $document = Dispatch::create($inputs);
                // foreach ($inputs['items'] as $row) {
                //     $document->items()->create($row);
                // }
                // $this->document = Dispatch::find($document->id);
                break;
        }
    }

    public function sendEmail()
    {
        $send_email = ($this->actions['send_email'] === true) ? true : false;

        if($send_email){

            $company = $this->company;
            $document = $this->document;
            $email = ($this->document->customer) ? $this->document->customer->email : $this->document->supplier->email;

            //Mail::to($email)->send(new DocumentEmail($company, $document));

        }
    }

    public function createXmlUnsigned()
    {
        $template = new Template();
        $this->xmlUnsigned = XmlFormat::format($template->xml($this->type, $this->company, $this->document));
        $this->uploadFile($this->xmlUnsigned, 'unsigned');
    }

    public function signXmlUnsigned()
    {
        $this->setPathCertificate();
        $this->signer->setCertificateFromFile($this->pathCertificate);
        $this->xmlSigned = $this->signer->signXml($this->xmlUnsigned);
        $this->uploadFile($this->xmlSigned, 'signed');
    }

    public function updateHash()
    {
        $this->document->update([
            'hash' => $this->getHash(),
        ]);
    }

    public function updateQr()
    {
        $this->document->update([
            'qr' => $this->getQr(),
        ]);
    }

    public function updateState($state_type_id)
    {
        $this->document->update([
            'state_type_id' => $state_type_id,
            'soap_shipping_response' => isset($this->response['sent']) ? $this->response:null
        ]);

    }

    public function updateSoap($soap_type_id, $type)
    {
        $this->document->update([
            'soap_type_id' => $soap_type_id
        ]);
        if($type === 'invoice') {
            $invoice = Invoices::where('document_id', $this->document->id)->first();
            $invoice->date_of_due = $this->document->date_of_issue;
            $invoice->save();
        }
    }

    public function updateStateDocuments($state_type_id)
    {
        foreach ($this->document->documents as $doc)
        {
            $doc->document->update([
                'state_type_id' => $state_type_id
            ]);
        }
    }

    private function getHash()
    {
        $helper = new XmlHash();
        return $helper->getHashSign($this->xmlSigned);
    }

    private function getQr()
    {
        $customer = json_decode($this->document->customer);
        $text = join('|', [
            $this->company->number,
            $this->document->document_type_id,
            $this->document->series,
            $this->document->number,
            $this->document->total_igv,
            $this->document->total,
            $this->document->date_of_issue,
            $customer->identity_document_type_id,
            $customer->number,
            $this->document->hash
        ]);

        $qrCode = new QrCodeGenerate();
        $qr = $qrCode->displayPNGBase64($text);
        return $qr;
    }

    public function createPdf($document = null, $type = null, $format = null, $route = null) {

        ini_set("pcre.backtrack_limit", "5000000");
        $template = new Template();
        $pdf = new Mpdf();

        $this->document = ($document != null) ? $document : $this->document;
        $format_pdf = ($format != null) ? $format : $this->format_pdf;
        $this->type = ($type != null) ? $type : $this->type;

        $base_pdf_template = $this->base_pdf_template;

        $html = $template->pdf($base_pdf_template, $this->type, $this->company, $this->document, $format_pdf);

        if (($format_pdf === 'ticket') OR
            ($format_pdf === 'ticket_58') OR
            ($format_pdf === 'ticket_50'))
        {

            $width = ($format_pdf === 'ticket_58') ? 56 : 78 ;
            if(env('ENABLED_TEMPLATE_TICKET_80')) $width = 76;
            if(env('ENABLED_TEMPLATE_TICKET_70')) $width = 70;
            if($format_pdf === 'ticket_50') $width = 45;

            $establishment = json_decode($this->document->establishment);
            $customer = json_decode($this->document->customer);

            $company_name      = (strlen($this->company->name) / 20) * 10;
            $company_address   = (strlen($establishment->address) / 30) * 10;
            $company_number    = $establishment->phone != '' ? '10' : '0';
            $customer_name     = strlen($customer->name) > '25' ? '10' : '0';
            $customer_address  = (strlen($customer->address) / 200) * 10;
            $customer_department_id  = ($customer->department_id == 16) ? 20:0;
            $p_order           = $this->document->purchase_order != '' ? '10' : '0';

            $total_prepayment = $this->document->total_prepayment != '' ? '10' : '0';
            $total_discount = $this->document->total_discount != '' ? '10' : '0';
            $was_deducted_prepayment = $this->document->was_deducted_prepayment ? '10' : '0';

            $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            $total_free        = $this->document->total_free != '' ? '10' : '0';
            $total_unaffected  = $this->document->total_unaffected != '' ? '10' : '0';
            $total_exonerated  = $this->document->total_exonerated != '' ? '10' : '0';
            $total_taxed       = $this->document->total_taxed != '' ? '10' : '0';
            $perception       = $this->document->perception != '' ? '10' : '0';
            $detraction       = $this->document->detraction != '' ? '50' : '0';

            $total_plastic_bag_taxes       = $this->document->total_plastic_bag_taxes != '' ? '10' : '0';

            $document_items = DocumentItem::where('document_id',$this->document->id)->get();
            $payments = DocumentPayment::where('document_id',$this->document->id)->get();

            $quantity_rows     = count($document_items) + $was_deducted_prepayment;
            $document_payments     = count($payments);

            $extra_by_item_additional_information = 0;
            $extra_by_item_description = 0;
            $discount_global = 0;
            foreach ($document_items as $it) {
                if(strlen($it->description)>100){
                    $extra_by_item_description +=24;
                }
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
                if($it->additional_information){
                    $extra_by_item_additional_information += count($it->additional_information) * 5;
                }
            }
            $legends = $this->document->legends != '' ? '10' : '0';

            $quotation_id = ($this->document->quotation_id) ? 15:0;

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [
                    $width,
                    130 +
                    (($quantity_rows * 8) + $extra_by_item_description) +
                    ($document_payments * 8) +
                    ($discount_global * 8) +
                    $company_name +
                    $company_address +
                    $company_number +
                    $customer_name +
                    $customer_address +
                    $p_order +
                    $legends +
                    $total_exportation +
                    $total_free +
                    $total_unaffected +
                    $total_exonerated +
                    $perception +
                    $total_taxed+
                    $total_prepayment +
                    $total_discount +
                    $was_deducted_prepayment +
                    $customer_department_id+
                    $detraction+
                    $total_plastic_bag_taxes+
                    $quotation_id+
                    $extra_by_item_additional_information
                ],
                'margin_top' => 0,
                'margin_right' => 1,
                'margin_bottom' => 0,
                'margin_left' => 1
            ]);
        }else if($format_pdf === 'a5'){

            $company_name      = (strlen($this->company->name) / 20) * 10;
            $company_address   = (strlen($this->document->establishment->address) / 30) * 10;
            $company_number    = $this->document->establishment->telephone != '' ? '10' : '0';
            $customer_name     = strlen($this->document->customer->name) > '25' ? '10' : '0';
            $customer_address  = (strlen($this->document->customer->address) / 200) * 10;
            $p_order           = $this->document->purchase_order != '' ? '10' : '0';

            $total_exportation = $this->document->total_exportation != '' ? '10' : '0';
            $total_free        = $this->document->total_free != '' ? '10' : '0';
            $total_unaffected  = $this->document->total_unaffected != '' ? '10' : '0';
            $total_exonerated  = $this->document->total_exonerated != '' ? '10' : '0';
            $total_taxed       = $this->document->total_taxed != '' ? '10' : '0';
            $total_plastic_bag_taxes       = $this->document->total_plastic_bag_taxes != '' ? '10' : '0';
            $quantity_rows     = count($this->document->items);

            $extra_by_item_description = 0;
            $discount_global = 0;
            foreach ($this->document->items as $it) {
                if(strlen($it->item->description)>100){
                    $extra_by_item_description +=24;
                }
                if ($it->discounts) {
                    $discount_global = $discount_global + 1;
                }
            }
            $legends = $this->document->legends != '' ? '10' : '0';


            $height = ($quantity_rows * 8) +
                    ($discount_global * 3) +
                    $company_name +
                    $company_address +
                    $company_number +
                    $customer_name +
                    $customer_address +
                    $p_order +
                    $legends +
                    $total_exportation +
                    $total_free +
                    $total_unaffected +
                    $total_exonerated +
                    $total_taxed;
            $diferencia = 148 - (float)$height;

            $pdf = new Mpdf([
                'mode' => 'utf-8',
                'format' => [210,$diferencia + $height],
                'margin_top' => 2,
                'margin_right' => 5,
                'margin_bottom' => 0,
                'margin_left' => 5
            ]);


       } else {

            $pdf_font_regular = env('PDF_NAME_REGULAR');
            $pdf_font_bold = env('PDF_NAME_BOLD');

            if ($pdf_font_regular != false) {
                $defaultConfig = (new ConfigVariables())->getDefaults();
                $fontDirs = $defaultConfig['fontDir'];

                $defaultFontConfig = (new FontVariables())->getDefaults();
                $fontData = $defaultFontConfig['fontdata'];

                $pdf = new Mpdf([
                    'fontDir' => array_merge($fontDirs, [
                        app_path('CoreBilling'.DIRECTORY_SEPARATOR.'Templates'.
                                                 DIRECTORY_SEPARATOR.'pdf'.
                                                 DIRECTORY_SEPARATOR.$base_pdf_template.
                                                 DIRECTORY_SEPARATOR.'font')
                    ]),
                    'fontdata' => $fontData + [
                        'custom_bold' => [
                            'R' => $pdf_font_bold.'.ttf',
                        ],
                        'custom_regular' => [
                            'R' => $pdf_font_regular.'.ttf',
                        ],
                    ]
                ]);
            }
        }

        $path_css = app_path('CoreBilling'.DIRECTORY_SEPARATOR.'Templates'.
                                             DIRECTORY_SEPARATOR.'pdf'.
                                             DIRECTORY_SEPARATOR.$base_pdf_template.
                                             DIRECTORY_SEPARATOR.'style.css');

        $stylesheet = file_get_contents($path_css);

        $pdf->WriteHTML($stylesheet, HTMLParserMode::HEADER_CSS);
        $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

        if (($format_pdf != 'ticket') AND ($format_pdf != 'ticket_58')) {
            if(env('PDF_TEMPLATE_FOOTER')) {
                $html_footer = $template->pdfFooter($base_pdf_template);
                $pdf->SetHTMLFooter($html_footer);
            }
            $html_footer = $template->pdfFooter($base_pdf_template);
            $pdf->SetHTMLFooter($html_footer);
        }

        $this->uploadFile($pdf->output('', 'S'), 'pdf',$route);
    }

    public function uploadFile($file_content, $file_type, $route = null)
    {
        $route = ($route == null ? $this->route : $route);
        $this->uploadStorage($this->document->filename, $file_content, $file_type, $route);
    }

    public function loadXmlSigned()
    {
        $this->xmlSigned = $this->getStorage($this->document->filename, 'signed');
//        dd($this->xmlSigned);
    }

    private function senderXmlSigned()
    {
        $this->setDataSoapType();
        $sender = in_array($this->type, ['summary', 'voided'])?new SummarySender():new BillSender();
        $sender->setClient($this->wsClient);
        $sender->setCodeProvider(new XmlErrorCodeProvider());

        return $sender->send($this->document->filename, $this->xmlSigned);
    }

    public function senderXmlSignedBill()
    {
        // if(!$this->actions['send_xml_signed']) {
        //     $this->response = [
        //         'sent' => false,
        //     ];
        //     return;
        // }
        $this->onlySenderXmlSignedBill();

    }

    public function onlySenderXmlSignedBill()
    {
        $res = $this->senderXmlSigned();

        if($res->isSuccess()) {
            $cdrResponse = $res->getCdrResponse();
            $this->uploadFile($res->getCdrZip(), 'cdr');

            $code = $cdrResponse->getCode();
            $description = $cdrResponse->getDescription();

            $this->response = [
                'sent' => true,
                'code' => $cdrResponse->getCode(),
                'description' => $cdrResponse->getDescription(),
                'notes' => $cdrResponse->getNotes()
            ];

            $this->validationCodeResponse($code, $description);

        } else {
            $code = $res->getError()->getCode();
            $message = $res->getError()->getMessage();
            $this->response = [
                'sent' => true,
                'code' => $code,
                'description' => $message
            ];

            $this->validationCodeResponse($code, $message);

        }
    }

    public function validationCodeResponse($code, $message)
    {
        //Errors
        if($code === 'ERROR_CDR') {
            return;
        }
        if($code === 'HTTP') {
//            $message = 'La SUNAT no responde a su solicitud, vuelva a intentarlo.';
            throw new Exception("Code: {$code}; Description: {$message}");
        }
        if((int)$code === 0) {
            $this->updateState(self::ACCEPTED);
            return;
        }
        if((int)$code < 2000) {
            //Excepciones
            throw new Exception("Code: {$code}; Description: {$message}");
        } elseif ((int)$code < 4000) {
            //Rechazo
            $this->updateState(self::REJECTED);
        } else {
            $this->updateState(self::OBSERVED);
            //Observaciones
        }
        return;
    }

    public function senderXmlSignedSummary()
    {
        $res = $this->senderXmlSigned();
        if($res->isSuccess()) {
            $ticket = $res->getTicket();
            $this->updateTicket($ticket);
            $this->updateState(self::SENT);
            if($this->type === 'summary') {
                if($this->document->summary_status_type_id === '1') {
                    $this->updateStateDocuments(self::SENT);
                } else {
                    $this->updateStateDocuments(self::CANCELING);
                }
            } else {
                $this->updateStateDocuments(self::CANCELING);
            }
            $this->response = [
                'sent' => true
            ];
        } else {
            throw new Exception("Code: {$res->getError()->getCode()}; Description: {$res->getError()->getMessage()}");
        }
    }

    private function updateTicket($ticket)
    {
        $this->document->update([
            'ticket' => $ticket
        ]);
    }

    public function statusSummary($ticket)
    {
        $extService = new ExtService();
        $extService->setClient($this->wsClient);
        $extService->setCodeProvider(new XmlErrorCodeProvider());
        $res = $extService->getStatus($ticket);
        if(!$res->isSuccess()) {
            throw new Exception("Code: {$res->getError()->getCode()}; Description: {$res->getError()->getMessage()}");
        } else {
            $cdrResponse = $res->getCdrResponse();
            $this->uploadFile($res->getCdrZip(), 'cdr');
            $this->updateState(self::ACCEPTED);
            if($this->type === 'summary') {
                if($this->document->summary_status_type_id === '1') {
                    $this->updateStateDocuments(self::ACCEPTED);
                } else {
                    $this->updateStateDocuments(self::VOIDED);
                }
            } else {
                $this->updateStateDocuments(self::VOIDED);
            }
            $this->response = [
                'code' => $cdrResponse->getCode(),
                'description' => $cdrResponse->getDescription(),
                'notes' => $cdrResponse->getNotes()
            ];
        }
    }

    public function consultCdr()
    {
        $consultCdrService = new ConsultCdrService();
        $consultCdrService->setClient($this->wsClient);
        $consultCdrService->setCodeProvider(new XmlErrorCodeProvider());
        $res = $consultCdrService->getStatusCdr($this->company->number, $this->document->document_type_id,
                                                $this->document->series, $this->document->number);

        if(!$res->isSuccess()) {
            throw new Exception("Code: {$res->getError()->getCode()}; Description: {$res->getError()->getMessage()}");
        } else {
            $cdrResponse = $res->getCdrResponse();
            $this->uploadFile($res->getCdrZip(), 'cdr');
            $this->updateState(self::ACCEPTED);
            $this->response = [
                'sent' => true,
                'code' => $cdrResponse->getCode(),
                'description' => $cdrResponse->getDescription(),
                'notes' => $cdrResponse->getNotes()
            ];
        }
    }



    private function setDataSoapType()
    {
        $this->setSoapCredentials();
        $this->wsClient->setCredentials($this->soapUsername, $this->soapPassword);
        $this->wsClient->setService($this->endpoint);
    }

    private function setPathCertificate()
    {
        if($this->isOse) {
            $this->pathCertificate = storage_path('app'.DIRECTORY_SEPARATOR.
                'certificates'.DIRECTORY_SEPARATOR.$this->company->certificate);
        } else {
            if($this->isDemo) {
                $this->pathCertificate = app_path('CoreBilling'.DIRECTORY_SEPARATOR.
                    'WS'.DIRECTORY_SEPARATOR.
                    'Signed'.DIRECTORY_SEPARATOR.
                    'Resources'.DIRECTORY_SEPARATOR.
                    'certificate.pem');
            } else {
                $this->pathCertificate = storage_path('app'.DIRECTORY_SEPARATOR.
                    'certificates'.DIRECTORY_SEPARATOR.$this->company->certificate);
            }
        }

//        if($this->isDemo) {
//            $this->pathCertificate = app_path('CoreBilling'.DIRECTORY_SEPARATOR.
//                'WS'.DIRECTORY_SEPARATOR.
//                'Signed'.DIRECTORY_SEPARATOR.
//                'Resources'.DIRECTORY_SEPARATOR.
//                'certificate.pem');
//        } else {
//            $this->pathCertificate = storage_path('app'.DIRECTORY_SEPARATOR.
//                'certificates'.DIRECTORY_SEPARATOR.$this->company->certificate);
//        }
    }

    private function setSoapCredentials()
    {
        if($this->isDemo) {
            $this->soapUsername = $this->company->number.'MODDATOS';
            $this->soapPassword = 'moddatos';
        } else {
            $this->soapUsername = $this->company->soap_username;
            $this->soapPassword = $this->company->soap_password;
        }

//        $this->soapUsername = ($this->isDemo)?$this->company->number.'MODDATOS':$this->company->soap_username;
//        $this->soapPassword = ($this->isDemo)?'moddatos':$this->company->soap_password;

        if($this->isOse) {
            $this->endpoint = $this->company->soap_url;
//            dd($this->soapPassword);
        } else {
            switch ($this->type) {
                case 'perception':
                case 'retention':
                    $this->endpoint = ($this->isDemo)?SunatEndpoints::RETENCION_BETA:SunatEndpoints::RETENCION_PRODUCCION;
                    break;
                case 'dispatch':
                    $this->endpoint = ($this->isDemo)?SunatEndpoints::GUIA_BETA:SunatEndpoints::GUIA_PRODUCCION;
                    break;
                default:
                    // $this->endpoint = ($this->isDemo)?SunatEndpoints::FE_BETA:SunatEndpoints::FE_PRODUCCION;
                    $this->endpoint = ($this->isDemo)?SunatEndpoints::FE_BETA : ($this->sunat_alternate_server ? SunatEndpoints::FE_PRODUCCION_ALTERNATE : SunatEndpoints::FE_PRODUCCION);
                    break;
            }
        }

    }

    private function updatePrepaymentDocuments($inputs){
        // dd($inputs);

        if(isset($inputs['prepayments'])) {

            foreach ($inputs['prepayments'] as $row) {

                $fullnumber = explode('-', $row['number']);
                $series = $fullnumber[0];
                $number = $fullnumber[1];

                $doc = Document::where([['series',$series],['number',$number]])->first();
                if($doc){
                    $doc->was_deducted_prepayment = true;
                    $doc->save();
                }
            }
        }
    }

    public function updateResponse(){

        // if($this->response['sent']) {
        //     return

        //     $this->document->update([
        //         'soap_shipping_response' => $this->response
        //     ]);

        // }

    }

    private function savePayments($document, $payments){

        $total = $document->total;
        $balance = $total - collect($payments)->sum('payment');

        $search_cash = ($balance < 0) ? collect($payments)->firstWhere('payment_method_type_id', '01') : null;

        $this->apply_change = false;

        if($balance < 0 && $search_cash){

            $payments = collect($payments)->map(function($row) use($balance){

                $change = null;
                $payment = $row['payment'];

                if($row['payment_method_type_id'] == '01' && !$this->apply_change){

                    $change = abs($balance);
                    $payment = $row['payment'] - abs($balance);
                    $this->apply_change = true;

                }

                return [
                    "id" => null,
                    "document_id" => null,
                    "sale_note_id" => null,
                    "date_of_payment" => $row['date_of_payment'],
                    "payment_method_type_id" => $row['payment_method_type_id'],
                    "reference" => $row['reference'],
                    "payment_destination_id" => isset($row['payment_destination_id']) ? $row['payment_destination_id'] : null,
                    "change" => $change,
                    "payment" => $payment
                ];

            });
        }

        foreach ($payments as $row) {

            if($balance < 0 && !$this->apply_change){
                $row['change'] = abs($balance);
                $row['payment'] = $row['payment'] - abs($balance);
                $this->apply_change = true;
            }

            $record = $document->payments()->create($row);

            //considerar la creacion de una caja chica cuando recien se crea el cliente
            if(isset($row['payment_destination_id'])){
                $this->createGlobalPayment($record, $row);
            }

        }
    }

    private function saveCashDocument($id,$type){
        $cash =  Cash::where([['user_id',Auth::id()],['state',true]])->first();
        CashDocument::create([
            'cash_id' => $cash->id,
            'document_id' => ($type=='invoice'?$id:null),
            'sale_note_id',
            'expense_payment_id'
        ]);
    }

    private function saveFee($document, $fee)
    {
        foreach ($fee as $row) {
            $document->fee()->create($row);
        }
    }

    public function createGlobalPayment($model, $row){

        $destination = $this->getDestinationRecord($row);
        $company = Company::first();

        $model->global_payment()->create([
            'user_id' => auth()->id(),
            'soap_type_id' => $company->soap_type_id,
            'destination_id' => $destination['destination_id'],
            'destination_type' => $destination['destination_type'],
        ]);

    }

    public function getDestinationRecord($row){

        if($row['payment_destination_id'] === 'cash'){

            $destination_id = $this->getCash()['cash_id'];
            $destination_type = Cash::class;

        }else{

            $destination_id = $row['payment_destination_id'];
            $destination_type = BankAccount::class;

        }

        return [
            'destination_id' => $destination_id,
            'destination_type' => $destination_type,
        ];
    }

    public function getPaymentDestinations(){

        $bank_accounts = self::getBankAccounts();
        $cash = $this->getCash();

        if($cash){
            return collect($bank_accounts)->push($cash);
        }

        return $bank_accounts;

    }

    private static function getBankAccounts(){

        return BankAccount::get()->transform(function($row) {
            return [
                'id' => $row->id,
                'cash_id' => null,
                'description' => "{$row->bank->description} - {$row->currency_type_id} - {$row->description}",
            ];
        });

    }

    public function getCash(){

        $cash =  Cash::where([['user_id',Auth::id()],['state',true]])->first();

        if($cash){

            return [
                'id' => 'cash',
                'cash_id' => $cash->id,
                'description' => ($cash->reference_number) ? "CAJA GENERAL - {$cash->reference_number}" : "CAJA GENERAL",
            ];

        }

        return null;

    }

}
