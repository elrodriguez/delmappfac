<?php

namespace App\Http\Livewire\Market\Sales;

use App\Models\Catalogue\DocumentType;
use App\Models\Master\Serie;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Catalogue\CatPaymentMethodTypes;
use Illuminate\Support\Facades\Lang;
use App\CoreBilling\Billing;
use App\CoreBilling\Helpers\Number\NumberLetter as NumberNumberLetter;
use App\Models\Catalogue\AffectationIgvType;
use App\Models\Catalogue\NoteCreditType;
use App\Models\Catalogue\NoteDebitType;
use App\Models\Master\Company;
use App\Models\Master\Document;
use App\Models\Master\Establishment;
use App\Models\Master\Parameter;
use App\Models\Warehouse\Warehouse;
use Exception;
use Elrod\UserActivity\Activity;
use Livewire\Component;

class Note extends Component
{
    public $document_type_id = '07';
    public $document;
    public $document_types = [];
    public $cdt;
    public $series;
    public $f_issuance;
    public $f_expiration;
    public $serie_id;
    public $correlative;
    public $customer_id;
    public $establishment_id;
    public $customer;
    public $box_items = [];
    public $total;
    public $payment_method_types = [];
    public $cat_payment_method_types;
    public $cat_expense_method_types;
    public $external_id;
    public $igv;
    public $note_type_id;
    public $note_types;
    public $note_description;
    public $total_exportation;
    public $total_taxed;
    public $total_exonerated;
    public $total_unaffected;
    public $total_free;
    public $total_igv;
    public $total_value;
    public $total_taxes;
    public $total_plastic_bag_taxes;
    public $total_prepayment = 0;
    public $currencyTypeIdActive = 'PEN';
    public $exchangeRateSale = 0;
    public $total_discount = 0;
    public $total_isc = 0;
    public $warehouse_id;

    public function mount($external_id){
        $this->external_id = $external_id;
        $this->changeSeries();
        $this->igv = (int) Parameter::where('id_parameter','PRT002IGV')->value('value_default');
        $this->warehouse_id = Warehouse::where('establishment_id',Auth::user()->establishment_id)->first()->id;

        $activity = new Activity;
        $activity->causedBy(Auth::user());
        $activity->routeOn(route('market_sales_document_create'));
        $activity->componentOn('market.sales.document-create-form');
        $activity->log('ingresó a la vista nuevo comprobante');
        $activity->save();

        $this->document = Document::where('external_id',$this->external_id)->with('items')->first();
        $this->currencyTypeIdActive = $this->document->currency_type_id;
        $this->exchangeRateSale = $this->document->exchange_rate_sale;
        $this->cdt = $this->document->document_type_id;
        $this->customer_id = $this->document->customer_id;
        $this->customer = $this->document->customer;
        $this->f_expiration = Carbon::now()->format('Y-m-d');
        $this->addItems();
    }

    public function render()
    {
        $this->cat_payment_method_types = CatPaymentMethodTypes::all();
        $billing = new Billing();
        $this->cat_expense_method_types = $billing->getPaymentDestinations();
        $this->document_types = DocumentType::whereIn('id',['07','08'])->get();

        $this->recalculateAll();
        return view('livewire.market.sales.note');
    }

    public function changeSeries(){
        $std =  ($this->cdt == '01'?'F':'B');
        $this->series = Serie::where('document_type_id',$this->document_type_id)
            ->where('establishment_id',Auth::user()->establishment_id)
            ->whereRaw('LEFT(id,1)=?',[$std])
            ->get();

        $this->serie_id = $this->series->max('id');

        if($this->document_type_id == '07'){
            $this->note_types = NoteCreditType::where('active',true)->get();
        }else{
            $this->note_types = NoteDebitType::where('active',true)->get();
        }

        $this->selectCorrelative();
    }

    public function selectCorrelative(){
        $serie = Serie::where('id',$this->serie_id)->first();
        if($serie){
            $this->correlative = str_pad($serie->correlative, 8, "0", STR_PAD_LEFT);
        }else{
            $this->correlative = str_pad(0, 8, "0", STR_PAD_LEFT);
        }
    }

    public function setItems($item){
        $affectation_igv_type = AffectationIgvType::where('id',$item['affectation_igv_type_id'])->first();
        return [
            'item_id'=> $item['item_id'],
            'item' => $item['item'],
            'currency_type_id' => $this->document->currency_type_id,
            'quantity' => $item['quantity'],
            'unit_value' => $item['unit_value'],
            'affectation_igv_type_id' => $item['affectation_igv_type_id'],
            'affectation_igv_type'=> json_encode($affectation_igv_type),
            'total_base_igv'=> $item['total_base_igv'],
            'percentage_igv' => $item['percentage_igv'],
            'total_igv' => $item['total_igv'],
            'system_isc_type_id' => $item['system_isc_type_id'],
            'total_base_isc'=> $item['total_base_isc'],
            'percentage_isc'=> $item['percentage_isc'],
            'total_isc'=> $item['total_isc'],
            'total_base_other_taxes'=> $item['total_base_other_taxes'],
            'percentage_other_taxes'=> $item['percentage_other_taxes'],
            'total_other_taxes'=> $item['total_other_taxes'],
            'total_plastic_bag_taxes'=> $item['total_plastic_bag_taxes'],
            'total_taxes'=> $item['total_taxes'],
            'price_type_id'=> $item['price_type_id'],
            'unit_price'=> $item['unit_price'],
            'input_unit_price_value' => $item['unit_price'],
            'total_value' => $item['total_value'],
            'total_discount' => $item['total_discount'],
            'total_charge' => $item['total_charge'],
            'total' => $item['total']
        ];
    }

    public function addItems(){

        $items = $this->document->items->toArray();
        foreach ($items as $key => $item){
            $this->box_items[$key] = $this->setItems($item);
        }

        $this->calculateTotal();

    }

    public function calculateRowItem($data) {

        $percentage_igv = $data['percentage_igv'];
        $unit_value = $data['unit_price'];

        if ($data['affectation_igv_type_id'] === '10') {
            $unit_value = $data['unit_price'] / (1 + $percentage_igv / 100);
        }


        $data['unit_value'] = $unit_value;

        $total_value_partial = $unit_value * $data['quantity'];

        $total_isc = 0;
        $total_other_taxes = 0;
        $discount_base = 0;
        $total_discount = 0;
        $total_charge = 0;
        $total_value = $total_value_partial - $total_discount + $total_charge;
        $total_base_igv = $total_value_partial - $discount_base + $total_isc;

        $total_igv = 0;

        if ($data['affectation_igv_type_id'] === '10') {
            $total_igv = $total_base_igv * $percentage_igv / 100;
        }
        if ($data['affectation_igv_type_id'] === '20') { //Exonerated
            $total_igv = 0;
        }
        if ($data['affectation_igv_type_id'] === '30') { //Unaffected
            $total_igv = 0;
        }

        $total_taxes = $total_igv + $total_isc + $total_other_taxes;
        $total = $total_value + $total_taxes;

        $data['total_charge'] = number_format($total_charge, 2, '.', '');
        $data['total_discount'] = number_format($total_discount, 2, '.', '');
        $data['total_value'] = number_format($total_value, 2, '.', '');
        $data['total_base_igv'] = number_format($total_base_igv, 2, '.', '');
        $data['total_igv'] =  number_format($total_igv, 2, '.', '');
        $data['total_taxes'] = number_format($total_taxes, 2, '.', '');
        $data['total'] = number_format($total, 2, '.', '');
        
        if (json_decode($data['affectation_igv_type'])->free) {
            $data['price_type_id'] = '02';
            $data['unit_value'] = 0;
            $data['total'] = 0;
        }

        //impuesto bolsa
        if(json_decode($data['item'])->has_plastic_bag_taxes){
            $data['total_plastic_bag_taxes'] = number_format($data['quantity'] * $this->value_icbper, 2, '.', '');
        }

        return $data;
    }

    public function calculateTotal() {
        $total_discount = 0;
        $total_charge = 0;
        $total_exportation = 0;
        $total_taxed = 0;
        $total_taxes = 0;
        $total_exonerated = 0;
        $total_unaffected = 0;
        $total_free = 0;
        $total_igv = 0;
        $total_value = 0;
        $total = 0;
        $total_plastic_bag_taxes = 0;
        $onerosas = array('10','20','30','40');

        foreach ($this->box_items as $key => $value) {
            $total_discount = $total_discount + 0;
            $total_charge = $total_charge + 0;
            $affectation_igv = (string) $value['affectation_igv_type_id'];

            if ($affectation_igv === '10') {
                $total_taxed = $total_taxed + $value['total_value'];
            }
            if ($affectation_igv === '20') {
                $total_exonerated = $total_exonerated + $value['total_value'];
            }
            if ($affectation_igv === '30') {
                $total_unaffected = $total_unaffected + $value['total_value'];
            }
            if ($affectation_igv === '40') {
                $total_exportation = $total_exportation + $value['total_value'];
            }
            if (array_search($affectation_igv, $onerosas) < 0) {
                $total_free = $total_free + $value['total_value'];
            }
            if (array_search($affectation_igv, $onerosas) > -1) {
                $total_igv = $total_igv + $value['total_igv'];
                $total = $total + $value['total'];
            }

            $total_value = $total_value + $value['total_value'];
            $total_plastic_bag_taxes = $total_plastic_bag_taxes + $value['total_plastic_bag_taxes'];

            if (in_array($affectation_igv, array('13', '14', '15'))) {

                $unit_value = ($value['total_value']/$value['quantity']) / (1 + $value['percentage_igv'] / 100);
                $total_value_partial = $unit_value * $value['quantity'];
                $total_taxes = $value['total_value'] - $total_value_partial;
                $this->box_items[$key]['total_igv'] = $value['total_value'] - $total_value_partial;
                $this->box_items[$key]['total_base_igv'] = $total_value_partial;
                $total_value = $total_value - $value['total_value'];

            }

        }

        $this->total_exportation = number_format($total_exportation, 2, '.', '');
        $this->total_taxed = number_format($total_taxed, 2, '.', '');
        $this->total_exonerated = number_format($total_exonerated, 2, '.', '');
        $this->total_unaffected = number_format($total_unaffected, 2, '.', '');
        $this->total_free =number_format($total_free, 2, '.', '');
        $this->total_igv = number_format($total_igv, 2, '.', '');
        $this->total_value = number_format($total_value, 2, '.', '');
        $this->total_taxes = number_format($total_taxes, 2, '.', '');
        $this->total_plastic_bag_taxes = number_format($total_plastic_bag_taxes, 2, '.', '');

        $this->total = number_format($total+$total_plastic_bag_taxes, 2, '.', '');

        // if(this.enabled_discount_global)
        //     this.discountGlobal()

        // if(this.prepayment_deduction)
        //     this.discountGlobalPrepayment()

        // if(['1001', '1004'].includes(this.form.operation_type_id))
        //     this.changeDetractionType()

        // this.setTotalDefaultPayment()
        // this.setPendingAmount()

        // this.calculateFee();
    }

    public function recalculateAll(){
        if(count($this->box_items)>0){

            foreach($this->box_items as $key => $item){
                if(is_numeric($item['quantity'])){
                    $data[$key] = $this->calculateRowItem($item);
                }
            }
            $this->box_items = $data;
            $this->calculateTotal();

        }
    }

    public function removeItem($key){
        unset($this->box_items[$key]);
        $this->calculateTotal();
        $this->payment_method_types[0]['amount'] = $this->total;
    }

    public function validateForm(){

        $this->validate([
            'document_type_id' => 'required',
            'serie_id' => 'required',
            'f_issuance' => 'required',
            'customer_id' => 'required',
            'note_description' => 'required|max:255'
        ]);



        if ($this->box_items > 0) {
            foreach($this->box_items as $key => $val)
            {
                $this->validate([
                    'box_items.'.$key.'.quantity' => 'numeric|required'
                ]);
            }
        }

        $this->store();

    }

    public function store(){

        //dd('aca llego');

        $this->selectCorrelative($this->serie_id);

        list($di,$mi,$yi) = explode('/',$this->f_issuance);
        $date_of_issue = $yi.'-'.$mi.'-'.$di;

        $company = Company::first();

        $numberletters = new NumberNumberLetter();

        $legends = json_encode(["code" => 1000, "value" => $numberletters->convertToLetter($this->total)]);

        $this->external_id = uuids();
        $establishment_json = Establishment::where('id',Auth::user()->establishment_id)->first();
        $inputDocument = [
            'establishment_id' => Auth::user()->establishment_id,
            'establishment' => $establishment_json,
            'customer' => $this->document->customer,
            'user_id' => Auth::id(),
            'document_type_id' => $this->document_type_id,
            'series' => $this->serie_id,
            'external_id' => $this->external_id,
            'number' => $this->correlative,
            'date_of_issue' => $date_of_issue,
            'time_of_issue' => Carbon::now()->format('H:i:s') ,
            'customer_id' => $this->document->customer_id,
            'currency_type_id' => $this->document->currency_type_id,
            'purchase_order' => null,
            'exchange_rate_sale' => 0,
            'total_prepayment' => 0,
            'total_charge' => 0,
            'total_discount' => $this->total_discount,
            'total_exportation' => $this->total_exportation,
            'total_free' => $this->total_free,
            'total_taxed' => $this->total_taxed,
            'total_unaffected' => $this->total_unaffected,
            'total_exonerated' => $this->total_exonerated,
            'total_igv' => $this->total_igv,
            'total_base_isc' => 0,
            'total_isc' => $this->total_isc,
            'total_base_other_taxes' => 0,
            'total_other_taxes' => 0,
            'total_plastic_bag_taxes' => $this->total_plastic_bag_taxes,
            'total_taxes' => $this->total_taxes,
            'total_value' => $this->total_taxed,
            'total' => $this->total,
            'items' => $this->box_items,
            'affected_document_id' => $this->document->id,
            'note_credit_or_debit_type_id' => $this->note_type_id,
            'note_description' => $this->note_description,
            'actions' => ['format_pdf' => 'a4'],
            'operation_type_id' => null,
            'type'=> ($this->document_type_id=='07'?'credit':'debit'),
            'send_server' => 0,
            'legends' => $legends,
            'filename' => ($company->number.'-'.$this->document_type_id.'-'.$this->serie_id.'-'.((int) $this->correlative)),
            'module' => 'MAR',
            'soap_type_id' => '02',
            'state_type_id' => '01',
            'ubl_version' => '2.1',
            'group_id' => ($this->cdt == '03'?'02':'01'),
            'route'=> 'market/saledocument',
            'note' => [
                'note_type' => ($this->document_type_id=='07' ? 'credit' : 'debit'),
                'note_credit_type_id' => ($this->document_type_id=='07' ? $this->note_type_id : null),
                'note_debit_type_id' => ($this->document_type_id=='08' ? $this->note_type_id : null),
                'note_description' => $this->note_description,
                'affected_document_id' => $this->document->id,
                'data_affected_document' => $this->document
            ]
        ];

        try {
            $billing = new Billing();
            $billing->save($inputDocument);
            $billing->createXmlUnsigned();
            $billing->signXmlUnsigned();
            $billing->updateHash();
            $billing->updateQr();
            $billing->createPdf();
            $billing->senderXmlSignedBill();
        } catch (Exception $e) {
            dd($e->getMessage());
        }

        Serie::where('id',$this->serie_id)->increment('correlative');

        $this->selectCorrelative($this->serie_id);
        $document_old_id = Document::max('id');
        $user = Auth::user();
        $activity = new Activity;
        $activity->modelOn(Document::class,$document_old_id);
        $activity->causedBy($user);
        $activity->routeOn(route('charges_new_document'));
        $activity->componentOn('academic.charges.new-document-form');
        $activity->dataOld($inputDocument);
        $activity->logType('create');
        $activity->log('Registro el documento de venta');
        $activity->save();

        $this->clearForm();
        $this->dispatchBrowserEvent('response_success_document_charges_store', ['message' => Lang::get('messages.successfully_registered')]);

        return redirect()->route('market_sales_document_list');
    }

    public function clearForm(){
        $this->f_issuance = Carbon::now()->format('d/m/Y');
        $this->customer_id = null;
        $this->box_items = [];
        $this->total = 0;
        $this->note_description = null;
        $this->note_type_id = null;
        $this->total_exportation = null;
        $this->total_taxed = null;
        $this->total_exonerated = null;
        $this->total_unaffected = null;
        $this->total_free = null;
        $this->total_igv = null;
        $this->total_value = null;
        $this->total_taxes = null;
        $this->total_plastic_bag_taxes = null;
        $this->total_prepayment = null;
    }
}
