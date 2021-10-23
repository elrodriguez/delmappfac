@php
    $establishment = \App\Models\Master\Establishment::find($document->establishment_id);
    $accounts = \App\Models\Catalogue\BankAccount::all();
    $documentType = \App\Models\Catalogue\DocumentType::find($document->document_type_id);
    $district = \Illuminate\Support\Facades\DB::table('districts')->where('id',$establishment->district_id)->first();
    $province = \Illuminate\Support\Facades\DB::table('provinces')->where('id',$establishment->province_id)->first();
    $department = \Illuminate\Support\Facades\DB::table('departments')->where('id',$establishment->department_id)->first();
    //dd($district);
    $customer = json_decode($document->customer);
    $identity_document_type = \App\Models\Catalogue\IdentityDocumentType::find($customer->identity_document_type_id);
    $customer_district = \Illuminate\Support\Facades\DB::table('districts')->where('id',$customer->district_id)->first();
    $customer_province = \Illuminate\Support\Facades\DB::table('provinces')->where('id',$customer->province_id)->first();
    $customer_department = \Illuminate\Support\Facades\DB::table('departments')->where('id',$customer->department_id)->first();

    $currency_type = \App\Models\Catalogue\CurrencyType::find($document->currency_type_id);
    $user = \App\Models\User::find($document->user_id);

    $invoice = $document->invoice;

    $document_number = $document->series.'-'.str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $accounts = \App\Models\Catalogue\BankAccount::all();
    $document_base = ($document->note) ? $document->note : null;
    $payments = $document->payments;
    $document_items = \App\Models\Master\DocumentItem::where('document_id',$document->id)->get();

    if($document_base) {
        $affected_document_number = ($document_base->affected_document) ? $document_base->affected_document->series.'-'.str_pad($document_base->affected_document->number, 8, '0', STR_PAD_LEFT) : $document_base->data_affected_document->series.'-'.str_pad($document_base->data_affected_document->number, 8, '0', STR_PAD_LEFT);

    } else {
        $affected_document_number = null;
    }
    //$document->load('reference_guides');
    $payments = \App\Models\Master\DocumentPayment::join('cat_payment_method_types','document_payments.payment_method_type_id','cat_payment_method_types.id')
                ->select('document_payments.*','cat_payment_method_types.description')
                ->where('document_id',$document->id)->get();
    $total_payment = $payments->sum('payment');
    $balance = ($document->total - $total_payment) - $payments->sum('change');

@endphp
<html>
<head>
    {{--<title>{{ $document_number }}</title>--}}
    {{--<link href="{{ $path_style }}" rel="stylesheet" />--}}
</head>
<body>

@if($company->logo)
    <div class="text-center company_logo_box pt-5">
        <img src="data:{{mime_content_type(public_path("storage/{$company->logo}"))}};base64, {{base64_encode(file_get_contents(public_path("storage/{$company->logo}")))}}" alt="{{$company->name}}" class="company_logo_ticket contain">
    </div>
{{--@else--}}
    {{--<div class="text-center company_logo_box pt-5">--}}
        {{--<img src="{{ asset('logo/logo.jpg') }}" class="company_logo_ticket contain">--}}
    {{--</div>--}}
@endif

@if($document->state_type_id == '11')
    <div class="company_logo_box" style="position: absolute; text-align: center; top:500px">
        <img src="data:{{mime_content_type(public_path("status_images".DIRECTORY_SEPARATOR."anulado.png"))}};base64, {{base64_encode(file_get_contents(public_path("status_images".DIRECTORY_SEPARATOR."anulado.png")))}}" alt="anulado" class="" style="opacity: 0.6;">
    </div>
@endif
<table class="full-width">
    <tr>
        <td class="text-center"><h4>{{ $company->name }}</h4></td>
    </tr>
    <tr>
        <td class="text-center"><h5>{{ $company->trade_name }}</h5></td>
    </tr>
    <tr>
        <td class="text-center"><h5>{{ 'RUC '.$company->number }}</h5></td>
    </tr>
    <tr>
        <td class="text-center">
            {{ $establishment->address }}
            {{ ', '.$district->description }}
            {{ ', '.$province->description }}
            {{ '- '.$department->description }}
        </td>
    </tr>

    @isset($establishment->trade_address)
    <tr>
        <td class="text-center ">{{  ($establishment->trade_address !== '-')? 'D. Comercial: '.$establishment->trade_address : ''  }}</td>
    </tr>
    @endisset
    <tr>
        <td class="text-center ">{{ ($establishment->telephone !== '-')? 'Central telefónica: '.$establishment->telephone : '' }}</td>
    </tr>
    <tr>
        <td class="text-center">{{ ($establishment->email !== '-')? 'Email: '.$establishment->email : '' }}</td>
    </tr>
    @isset($establishment->web_address)
        <tr>
            <td class="text-center">{{ ($establishment->web_address !== '-')? 'Web: '.$establishment->web_address : '' }}</td>
        </tr>
    @endisset

    @isset($establishment->aditional_information)
        <tr>
            <td class="text-center pb-3">{{ ($establishment->aditional_information !== '-')? $establishment->aditional_information : '' }}</td>
        </tr>
    @endisset

    <tr>
        <td class="text-center pt-3 border-top"><h4>{{ $documentType->description }}</h4></td>
    </tr>
    <tr>
        <td class="text-center pb-3 border-bottom"><h3>{{ $document_number }}</h3></td>
    </tr>
</table>
<table class="full-width">
    <tr >
        <td width="" class="pt-3"><p class="desc">F. Emisión:</p></td>
        <td width="" class="pt-3"><p class="desc">{{ $document->date_of_issue }}</p></td>
    </tr>
    <tr>
        <td width="" ><p class="desc">H. Emisión:</p></td>
        <td width="" ><p class="desc">{{ $document->time_of_issue }}</p></td>
    </tr>
    @isset($invoice)
        @foreach ($invoice as $item)
        @if($item->date_of_due != $document->date_of_issue)
        <tr>
            <td><p class="desc">F. Vencimiento:</p></td>
            <td><p class="desc">{{ $item->date_of_due }}</p></td>
        </tr>
        @endif
        @endforeach
    @endisset
    <tr>
        <td class="align-top"><p class="desc">Cliente:</p></td>
        <td><p class="desc">{{ $customer->name }}</p></td>
    </tr>
    <tr>
        <td><p class="desc">{{ $identity_document_type->description }}:</p></td>
        <td><p class="desc">{{ $customer->number }}</p></td>
    </tr>
    @if ($customer->address !== '')
        <tr>
            <td class="align-top"><p class="desc">Dirección:</p></td>
            <td>
                <p class="desc">
                    {{ $customer->address }}
                    @if($customer_district && $customer_province && $customer_department)
                        {{ ', '.$customer_district->description }}
                        {{ ', '.$customer_province->description }}
                        {{ '- '.$customer_department->description }}
                    @endif
                </p>
            </td>
        </tr>
    @endif

    @if ($document->detraction)
    {{--<strong>Operación sujeta a detracción</strong>--}}
        <tr>
            <td  class="align-top"><p class="desc">N. Cta Detracciones:</p></td>
            <td><p class="desc">{{ $document->detraction->bank_account}}</p></td>
        </tr>
        <tr>
            <td  class="align-top"><p class="desc">B/S Sujeto a detracción:</p></td>
            @inject('detractionType', 'App\Services\DetractionTypeService')
            <td><p class="desc">{{$document->detraction->detraction_type_id}} - {{ $detractionType->getDetractionTypeDescription($document->detraction->detraction_type_id ) }}</p></td>
        </tr>
        <tr>
            <td  class="align-top"><p class="desc">Método de pago:</p></td>
            <td><p class="desc">{{ $detractionType->getPaymentMethodTypeDescription($document->detraction->payment_method_id ) }}</p></td>
        </tr>
        <tr>
            <td  class="align-top"><p class="desc">Porcentaje detracción:</p></td>
            <td><p class="desc">{{ $document->detraction->percentage}}%</p></td>
        </tr>
        <tr>
            <td  class="align-top"><p class="desc">Monto detracción:</p></td>
            <td><p class="desc">{{ $currency_type->symbol }} {{ $document->detraction->amount}}</p></td>
        </tr>
        @if($document->detraction->pay_constancy)
        <tr>
            <td  class="align-top"><p class="desc">Constancia de pago:</p></td>
            <td><p class="desc">{{ $document->detraction->pay_constancy}}</p></td>
        </tr>
        @endif
    @endif

    @if ($document->prepayments)
        @foreach($document->prepayments as $p)
        <tr>
            <td><p class="desc">Anticipo :</p></td>
            <td><p class="desc">{{$p->number}}</p></td>
        </tr>
        @endforeach
    @endif
    @if ($document->purchase_order)
        <tr>
            <td><p class="desc">Orden de Compra:</p></td>
            <td><p class="desc">{{ $document->purchase_order }}</p></td>
        </tr>
    @endif
    @if ($document->quotation_id)
        <tr>
            <td><p class="desc">Cotización:</p></td>
            <td><p class="desc">{{ $document->quotation->identifier }}</p></td>
        </tr>
    @endif
    @isset($document->quotation->delivery_date)
        <tr>
            <td><p class="desc">F. Entrega</p></td>
            <td><p class="desc">{{ $document->quotation->delivery_date->format('Y-m-d')}}</p></td>
        </tr>
    @endisset
    @isset($document->quotation->sale_opportunity)
        <tr>
            <td><p class="desc">O. Venta</p></td>
            <td><p class="desc">{{ $document->quotation->sale_opportunity->number_full}}</p></td>
        </tr>
    @endisset
</table>

@if ($document->guides)
{{--<strong>Guías:</strong>--}}
<table>
    @foreach($document->guides as $guide)
        <tr>
            @if(isset($guide->document_type_description))
                <td class="desc">{{ $guide->document_type_description }}</td>
            @else
                <td class="desc">{{ $guide->document_type_id }}</td>
            @endif
            <td class="desc">:</td>
            <td class="desc">{{ $guide->number }}</td>
        </tr>
    @endforeach
</table>
@endif

{{--  @if (count($document->reference_guides) > 0)
<!--br/>
<strong>Guias de remisión</strong>
<table>
    @foreach($document->reference_guides as $guide)
        <tr>
            <td>{{ $guide->series }}</td>
            <td>-</td>
            <td>{{ $guide->number }}</td>
        </tr>
    @endforeach
</table-->
@endif--}}

@if(!is_null($document_base))
<table>
    <tr>
        <td class="desc">Documento Afectado:</td>
        <td class="desc">{{ $affected_document_number }}</td>
    </tr>
    <tr>
        <td class="desc">Tipo de nota:</td>
        <td class="desc">{{ ($document_base->note_type === 'credit')?$document_base->note_credit_type->description:$document_base->note_debit_type->description}}</td>
    </tr>
    <tr>
        <td class="align-top desc">Descripción:</td>
        <td class="text-left desc">{{ $document_base->note_description }}</td>
    </tr>
</table>
@endif

<table class="full-width mt-10 mb-10">
    <thead class="">
    <tr>
        <th class="border-top-bottom desc-9 text-left">CANT.</th>
        <th class="border-top-bottom desc-9 text-left">UNIDAD</th>
        <th class="border-top-bottom desc-9 text-left">DESCRIPCIÓN</th>
        <th class="border-top-bottom desc-9 text-left">P.UNIT</th>
        <th class="border-top-bottom desc-9 text-left">TOTAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($document_items as $row)
        <tr>
            <td class="text-center desc-9 align-top">
                @if(((int)$row->quantity != $row->quantity))
                    {{ $row->quantity }}
                @else
                    {{ number_format($row->quantity, 0) }}
                @endif
            </td>
            <td class="text-center desc-9 align-top">{{ json_decode($row->item)->unit_type_id }}</td>
            <td class="text-left desc-9 align-top">
                @if($row->name_product_pdf)
                    {!!$row->name_product_pdf!!}
                @else
                    {{ json_decode($row->item)->description }}
                @endif

                @if (!empty($row->item->presentation)) {!!$row->item->presentation->description!!} @endif

                {{--
                @foreach($row->additional_information as $information)
                    @if ($information)
                        <br/>{{ $information }}
                    @endif
                @endforeach
                --}}
                @if($row->attributes)
                    @foreach($row->attributes as $attr)
                        <br/>{!! $attr->description !!} : {{ $attr->value }}
                    @endforeach
                @endif
                @if($row->discounts)
                    @foreach($row->discounts as $dtos)
                        <br/><small>{{ $dtos->factor * 100 }}% {{$dtos->description }}</small>
                    @endforeach
                @endif

                @if($row->is_set == 1)

                 <br>
                 @inject('itemSet', 'App\Services\ItemSetService')

                    {{join( "-", $itemSet->getItemsSet($row->item_id) )}}

                @endif

            </td>
            <td class="text-right desc-9 align-top">{{ number_format($row->unit_price, 2) }}</td>
            <td class="text-right desc-9 align-top">{{ number_format($row->total, 2) }}</td>
        </tr>
        <tr>
            <td colspan="5" class="border-bottom"></td>
        </tr>
    @endforeach

    @if ($document->prepayments)
        @foreach($document->prepayments as $p)
        <tr>
            <td class="text-center desc-9 align-top">
                1
            </td>
            <td class="text-center desc-9 align-top">NIU</td>
            <td class="text-left desc-9 align-top">
                ANTICIPO: {{($p->document_type_id == '02')? 'FACTURA':'BOLETA'}} NRO. {{$p->number}}
            </td>
            <td class="text-right  desc-9 align-top">-{{ number_format($p->total, 2) }}</td>
            <td class="text-right  desc-9 align-top">-{{ number_format($p->total, 2) }}</td>
        </tr>
        <tr>
            <td colspan="5" class="border-bottom"></td>
        </tr>
        @endforeach
    @endif

        @if($document->total_exportation > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP. EXPORTACIÓN: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_exportation, 2) }}</td>
            </tr>
        @endif
        @if($document->total_free > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP. GRATUITAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_free, 2) }}</td>
            </tr>
        @endif
        @if($document->total_unaffected > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP. INAFECTAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_unaffected, 2) }}</td>
            </tr>
        @endif
        @if($document->total_exonerated > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP. EXONERADAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_exonerated, 2) }}</td>
            </tr>
        @endif
        @if($document->total_taxed > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">OP. GRAVADAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_taxed, 2) }}</td>
            </tr>
        @endif
        @if($document->total_discount > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">DESCUENTO TOTAL: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_discount, 2) }}</td>
            </tr>
        @endif
        @if($document->total_plastic_bag_taxes > 0)
            <tr>
                <td colspan="4" class="text-right font-bold desc">ICBPER: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold desc">{{ number_format($document->total_plastic_bag_taxes, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="4" class="text-right font-bold desc">IGV: {{ $currency_type->symbol }}</td>
            <td class="text-right font-bold desc">{{ number_format($document->total_igv, 2) }}</td>
        </tr>
        <tr>
            <td colspan="4" class="text-right font-bold desc">TOTAL A PAGAR: {{ $currency_type->symbol }}</td>
            <td class="text-right font-bold desc">{{ number_format($document->total, 2) }}</td>
        </tr>
        @if($balance < 0)
           <tr>
               <td colspan="4" class="text-right font-bold desc">VUELTO: {{ $currency_type->symbol }}</td>
               <td class="text-right font-bold desc">{{ number_format(abs($balance),2, ".", "") }}</td>
           </tr>
        @endif
    </tbody>
</table>
<table class="full-width">
    <tr>

       {{-- @foreach(array_reverse((array) $document->legends) as $row) --}}
       @php
           $legend = json_decode($document->legends);
       @endphp
            <tr>
                @if ($legend ->code == "1000")
                    <td class="desc pt-3">Son: <span class="font-bold">{{ $legend ->value }} {{ $currency_type->description }}</span></td>
                    @if (count((array) $document->legends)>1)
                    <tr><td class="desc pt-3"><span class="font-bold">Leyendas</span></td></tr>
                    @endif
                @else
                    <td class="desc pt-3">{{$legend->code}}: {{ $legend->value }}</td>
                @endif
            </tr>
        {{-- @endforeach --}}
    </tr>


    @if ($document->detraction)
        <tr>
            <td class="desc pt-3 font-bold">
                Operación sujeta al Sistema de Pago de Obligaciones Tributarias
            </td>
        </tr>
    @endif

    <tr>
        <td class="desc pt-3">

            @if ($document->additional_information)
                <strong>Información adicional</strong>
                <p>{{ $document->additional_information }}</p>
            @endif

            <br>
            {{--
            @if(in_array($document->document_type->id,['01','03']))
                @foreach($accounts as $account)
                    <span class="font-bold">{{$account->bank->description}}</span> {{$account->currency_type->description}} {{$account->number}}
                @endforeach
            @endif
            --}}
        </td>
    </tr>
    <tr>
        <td class="text-center pt-3"><img class="qr_code" src="data:image/png;base64, {{ $document->qr }}" /></td>
    </tr>
    <tr>
        <td class="text-center desc">Código Hash: {{ $document->hash }}</td>
    </tr>

    @if ($customer->department_id == 16)
        <tr>
            <td class="text-center desc pt-5">
                Representación impresa del Comprobante de Pago Electrónico.
                <br/>Esta puede ser consultada en:
                <br/> <b>{!! url('/buscar') !!}</b>
                <br/> "Bienes transferidos en la Amazonía
                <br/>para ser consumidos en la misma
            </td>
        </tr>
    @endif

    @if($payments->count())
        <tr>
            <td class="desc pt-5">
                <strong>PAGOS:</strong>
            </td>
        </tr>
        @foreach($payments as $row)
            <tr>
                <td class="desc">&#8226; {{ $row->description }} - {{ $row->reference ? $row->reference.' - ':'' }} {{ $currency_type->symbol }} {{ number_format($row->payment + $row->change, 2, '.', '') }}</td>
            </tr>
        @endforeach
    @endif
    <tr>
        <td class="desc pt-2">
        <strong>Vendedor:</strong> </td>
    </tr>
    <tr>
        <td class="desc">{{ $user->name }}</td>
    </tr>
    <tr>
        <td class="text-center desc pt-5">Para consultar el comprobante ingresar a {!! url('/buscar') !!}</td>
    </tr>
</table>

</body>
</html>
