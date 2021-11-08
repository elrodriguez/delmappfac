<?php

namespace App\Http\Livewire\Market\Sales;

use App\Models\Catalogue\IdentityDocumentType;
use App\Models\Catalogue\DocumentType;
use App\Models\Master\Serie;
use App\Models\Warehouse\Item;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Catalogue\CatPaymentMethodTypes;
use Illuminate\Support\Facades\Lang;
use App\CoreBilling\Billing;
use App\CoreBilling\Helpers\Number\NumberLetter as NumberNumberLetter;
use App\Models\Catalogue\AffectationIgvType;
use App\Models\Master\Company;
use App\Models\Master\Document;
use App\Models\Master\Establishment;
use App\Models\Master\Parameter;
use App\Models\Master\Person;
use App\Models\Warehouse\InventoryKardex;
use App\Models\Warehouse\Warehouse;
use Exception;
use Elrod\UserActivity\Activity;
use App\Models\Master\Customer;
use App\Models\Master\PersonTypeDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DocumentCreateForm extends Component
{
    public $document_type_id = '03';
    public $document_types;
    public $identity_document_types = [];
    public $series;
    public $f_issuance;
    public $f_expiration;
    public $serie_id;
    public $correlative;
    public $customer_id;
    public $item_id;
    public $box_items = [];
    public $total;
    public $payment_method_types = [];
    public $cat_payment_method_types;
    public $cat_expense_method_types;
    public $external_id;
    public $value_icbper;
    public $additional_information;
    public $igv;

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


    public $identity_document_type_id = 1;
    public $sex;
    public $number_id;
    public $name;
    public $last_paternal;
    public $last_maternal;
    public $trade_name;
    public $xgenerico;

    public function mount(){
        $this->changeSeries();
        $this->value_icbper = Parameter::where('id_parameter','PRT006ICP')->value('value_default');
        $this->igv = (int) Parameter::where('id_parameter','PRT002IGV')->value('value_default');
        $this->warehouse_id = Warehouse::where('establishment_id',Auth::user()->establishment_id)->first()->id;

        $activity = new Activity;
        $activity->causedBy(Auth::user());
        $activity->routeOn(route('market_sales_document_create'));
        $activity->componentOn('market.sales.document-create-form');
        $activity->log('ingresó a la vista nuevo comprobante');
        $activity->save();

    }

    public function render()
    {
        $this->recalculateAll();
        $this->cat_payment_method_types = CatPaymentMethodTypes::all();
        $billing = new Billing();
        $this->cat_expense_method_types = $billing->getPaymentDestinations();
        $this->document_types = DocumentType::whereIn('id',['01','03'])->get();
        $this->identity_document_types = IdentityDocumentType::where('active',1)->get();

        $this->xgenerico = Person::where('trade_name','like','%Generico%')
            ->where('identity_document_type_id',0)
            ->select('people.id AS value',DB::raw('CONCAT(people.number," - ",people.trade_name) AS text'))
            ->first();
        if($this->xgenerico){
            if(!$this->customer_id){
                $this->customer_id = $this->xgenerico->value;
            }
        }

        return view('livewire.market.sales.document-create-form');
    }

    public function changeSeries(){
        $this->series = Serie::where('document_type_id',$this->document_type_id)
            ->where('establishment_id',Auth::user()->establishment_id)
            ->get();

        $this->serie_id = $this->series->max('id');
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

    public function removeItem($key){
        unset($this->box_items[$key]);
        $this->calculateTotal();
        $this->payment_method_types[0]['amount'] = $this->total;
    }

    public function recalculateAll(){
        if(count($this->box_items)>0){

            foreach($this->box_items as $key => $item){
                //if(is_numeric($item['quantity'])){
                    $data[$key] = $this->calculateRowItem($item);
                //}
            }

            $this->box_items = $data;
            $this->calculateTotal();
            $this->payment_method_types[0]['amount'] = $this->total;
        }
    }

    public function newPaymentMethodTypes(){
        $data = [
            'method' => '01',
            'destination' => 'cash',
            'date_of_payment' => Carbon::now()->format('d/m/Y'),
            'reference' => null,
            'amount' => null
        ];
        array_push($this->payment_method_types,$data);
    }

    public function removePaymentMethodTypes($key){
        unset($this->payment_method_types[$key]);
    }

    public function validateForm(){
        //dd($this->customer_id);
        $this->external_id = null;

        $this->validate([
            'document_type_id' => 'required',
            'serie_id' => 'required',
            'f_issuance' => 'required',
            'f_expiration' => 'required',
            'customer_id' => 'required'
        ]);

        $tdi = $this->document_type_id;
        $ps = true;
        if($tdi ==  '03'){
            $ps = true;
        }else{

            $ruc_exists = Person::where('id',$this->customer_id)
                ->where('identity_document_type_id',6)
                ->exists();
            //dd($this->customer_id);
            if($ruc_exists){
                $ps = true;
            }else{
                $ps = false;
            }
        }

        if($ps){
            if ($this->box_items > 0) {
                foreach($this->box_items as $key => $val)
                {
                    $this->validate([
                        'box_items.'.$key.'.quantity' => 'numeric|required'
                    ]);
                }
            }

            $total_amount = 0;

            if ($this->payment_method_types > 0) {
                foreach($this->payment_method_types as $key => $val){
                    $total_amount = $total_amount + $val['amount'];
                }
            }

            if($this->total == $total_amount){
                $this->store();
            }else{
                $this->dispatchBrowserEvent('response_payment_total_different', ['message' => Lang::get('messages.msg_totaldtc')]);
            }
        }else{
            $this->dispatchBrowserEvent('response_customer_not_ruc_exists', ['message' => Lang::get('messages.msg_client_does_not_registered_ruc')]);
        }

    }

    public function store(){
        $this->selectCorrelative($this->serie_id);

        $establishment_json = Establishment::where('id',Auth::user()->establishment_id)->first();
        $customer_json = Person::where('id',$this->customer_id)->first();
        $company = Company::first();
        list($di,$mi,$yi) = explode('/',$this->f_issuance);
        list($de,$me,$ye) = explode('/',$this->f_expiration);
        $date_of_issue = $yi.'-'.$mi.'-'.$di;
        $date_of_due = $ye.'-'.$me.'-'.$de;

        $numberletters = new NumberNumberLetter();

        $legends = json_encode(["code" => 1000, "value" => $numberletters->convertToLetter($this->total)]);
        $this->external_id = uuids();

        $payments = [];

        foreach($this->payment_method_types as $key => $value){
            list($d,$m,$y) = explode('/',$value['date_of_payment']);
            $date_of_payment = $y.'-'.$m.'-'.$d;
            $payments[$key ] = [
                'id' => null,
                'document_id' => null,
                'sale_note_id' => null,
                'date_of_payment' => $date_of_payment,
                'payment_method_type_id' => $value['method'],
                'payment_destination_id' => $value['destination'],
                'reference'=>$value['reference'],
                'payment'=> $value['amount']
            ];
        }

        $invoice = [
            'operation_type_id' => '0101',
            'date_of_due' => $date_of_due
        ];
        $this->total_taxes = $this->total_igv;
        $inputDocument = [
            'user_id' => Auth::id(),
            'external_id' => $this->external_id,
            'establishment_id'=>Auth::user()->establishment_id,
            'establishment' => $establishment_json,
            'soap_type_id' => '02',
            'state_type_id' => '01',
            'ubl_version' => '2.1',
            'group_id' => ($this->document_type_id == '03'?'02':$this->document_type_id),
            'document_type_id' => $this->document_type_id,
            'series' => $this->serie_id,
            'number' => $this->correlative,
            'date_of_issue' => $date_of_issue,
            'time_of_issue' => Carbon::now()->toDateTimeString(),
            'customer_id' => $this->customer_id,
            'customer' => $customer_json,
            'currency_type_id' => $this->currencyTypeIdActive,
            'exchange_rate_sale' => $this->exchangeRateSale,
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
            'send_server' => 0,
            'legends' => $legends,
            'filename' => ($company->number.'-'.$this->document_type_id.'-'.$this->serie_id.'-'.((int) $this->correlative)),
            'additional_information' => $this->additional_information,
            'module' => 'MAR',
            'items' => $this->box_items,
            'payments' => $payments,
            'invoice' => $invoice,
            'type'=>'invoice',
            'route'=> 'market/saledocument'
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
            $result_invoice = $billing->getResponse();
        } catch (Exception $e) {
            dd($e->getMessage());
        }


        Serie::where('id',$this->serie_id)->increment('correlative');
        $this->selectCorrelative($this->serie_id);
        $document_old_id = Document::max('id');
        if($result_invoice['sent']){
            Document::where('id', $document_old_id)->update([
                'has_xml' => '1',
                'has_pdf' => '1',
                'has_cdr' => '1'
            ]);
        }
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

    }

    public function clearForm(){
        $this->f_issuance = Carbon::now()->format('d/m/Y');
        $this->f_expiration = Carbon::now()->format('d/m/Y');
        $this->box_items = [];
        $this->payment_method_types = [];
        $this->total = 0;
        $this->payments = [];
        $this->additional_information = null;
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
                //$total_taxes = $value['total_value'] - $total_value_partial;
                $total_taxes = $total_igv;
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

    public function clickAddItem() {

        $key = array_search($this->item_id, array_column($this->box_items, 'item_id'));
        $exists_stock = InventoryKardex::where('item_id',$this->item_id)
            ->where('warehouse_id',$this->warehouse_id)
            ->sum('quantity');

        $success = true;
        $showmsg = false;
        $msg = '';

        if($key === false){
            if($this->item_id){

                $item = Item::where('id',$this->item_id)->first()->toArray();
                if($exists_stock <= $item['stock_min']){

                    $showmsg = true;
                    $success = true;
                    $msg = Lang::get('messages.msg_product_about_out');
                }

                if($exists_stock <= 0 ){
                    $success = false;
                    $showmsg = true;
                    $msg = Lang::get('messages.msg_product_no_units');
                }

                if($success){

                    $unit_price = $item['sale_unit_price'];
                    $currencyTypeIdActive = 'PEN';
                    $exchangeRateSale = 0.01;
                    $currency_type_id_old = $item['currency_type_id'];

                    if ($currency_type_id_old === 'PEN' && $currency_type_id_old !== $currencyTypeIdActive){
                        $unit_price = $unit_price / $exchangeRateSale;
                    }

                    if ($currencyTypeIdActive === 'PEN' && $currency_type_id_old !== $currencyTypeIdActive){
                        $unit_price = $unit_price * $exchangeRateSale;
                    }

                    $affectation_igv_type = AffectationIgvType::where('id',$item['sale_affectation_igv_type_id'])->first()->toArray();

                    $data = [
                        'item_id'=> $item['id'],
                        'item' => json_encode($item),
                        'currency_type_id' => $item['currency_type_id'],
                        'quantity' => 1,
                        'unit_value' => 0,
                        'affectation_igv_type_id' => $item['sale_affectation_igv_type_id'],
                        'affectation_igv_type'=> json_encode($affectation_igv_type),
                        'total_base_igv'=> 0,
                        'percentage_igv' => $this->igv,
                        'total_igv' => 0,
                        'system_isc_type_id' => null,
                        'total_base_isc'=> 0,
                        'percentage_isc'=> 0,
                        'total_isc'=> 0,
                        'total_base_other_taxes'=> 0,
                        'percentage_other_taxes'=> 0,
                        'total_other_taxes'=> 0,
                        'total_plastic_bag_taxes'=> 0,
                        'total_taxes'=> 0,
                        'price_type_id'=> '01',
                        'unit_price'=> $unit_price,
                        'input_unit_price_value' => $item['sale_unit_price'],
                        'total_value' => 0,
                        'total_discount' => 0,
                        'total_charge' => 0,
                        'total' => 0
                    ];

                    $data = $this->calculateRowItem($data,$currencyTypeIdActive, $exchangeRateSale);

                    array_push($this->box_items,$data);

                    $this->payment_method_types[0] =[
                        'method' => '01',
                        'destination' => 'cash',
                        'date_of_payment' => Carbon::now()->format('d/m/Y'),
                        'reference' => null,
                        'amount' => $this->total
                    ];

                }
            }
        }


        $this->dispatchBrowserEvent('response_clear_select_products_alert',['showmsg' => $showmsg,'message'=>$msg]);
    }

    function calculateRowItem($data) {

        $percentage_igv = $this->igv;
        $unit_value = $data['unit_price'];

        if ($data['affectation_igv_type_id'] === '10') {
            $unit_value = $data['unit_price'] / (1 + $percentage_igv / 100);
        }


        $data['unit_value'] = $unit_value;

        $quantity = 0;

        if($data['quantity']){
            $quantity = $data['quantity'];
        }else{
            $quantity = 0;
        }
        $total_value_partial = $unit_value * $quantity;

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
            $data['total_plastic_bag_taxes'] = number_format($quantity * $this->value_icbper, 2, '.', '');
        }

        return $data;
    }

    public function storeClient(){
        $this->validate([
            'identity_document_type_id' => 'required',
            'number_id' => 'required|numeric',
            'name' => 'required',
            'last_paternal' => 'required',
            'last_maternal' => 'required',
            'sex' => 'required'
        ]);

        $customer = Person::create([
            'type' => 'customers',
            'identity_document_type_id' => $this->identity_document_type_id,
            'number' => $this->number_id,
            'name' => $this->name,
            'country_id' => 'PE',
            'trade_name' => ($this->trade_name == null?$this->name.' '.$this->last_paternal.' '.$this->last_maternal:$this->trade_name),
            'last_paternal' => $this->last_paternal,
            'last_maternal' => $this->last_maternal,
            'sex' => $this->sex
        ]);

        PersonTypeDetail::create([
            'person_id' => $customer->id,
            'person_type_id' => 1
        ]);

        Customer::create(['person_id'=>$customer->id]);

        $this->clearFormCustomer();
        $this->dispatchBrowserEvent('response_success_customer_store', ['idperson'=>$customer->id,'nameperson'=>($customer->number.' - '.$customer->trade_name),'message' => Lang::get('messages.successfully_registered')]);
    }

    public function clearFormCustomer(){
        $this->identity_document_type_id = 1;
        $this->number_id = null;
        $this->name = null;
        $this->trade_name = null;
        $this->last_paternal = null;
        $this->last_maternal = null;
        $this->sex = null;
    }
}
