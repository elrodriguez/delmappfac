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
    //dd($invoice);
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
    $colspan = 5;
    $colspan6 = 6;
@endphp
<html>
<head>
    {{--<title>{{ $document_number }}</title>--}}
    {{--<link href="{{ $path_style }}" rel="stylesheet" />--}}
</head>
<body>
@if($document->state_type_id == '11')
    <div class="company_logo_box" style="position: absolute; text-align: center; top:30%;">
        <img src="data:{{mime_content_type(public_path("status_images".DIRECTORY_SEPARATOR."anulado.png"))}};base64, {{base64_encode(file_get_contents(public_path("status_images".DIRECTORY_SEPARATOR."anulado.png")))}}" alt="anulado" class="" style="opacity: 0.6;">
    </div>
@endif
<table class="full-width">
    <tr>
        @if($company->logo)
            <td width="20%">
                <div class="company_logo_box">
                    <img src="data:{{mime_content_type(public_path("storage/{$company->logo}"))}};base64, {{base64_encode(file_get_contents(public_path("storage/{$company->logo}")))}}" alt="{{$company->name}}" class="company_logo" style="max-width: 150px;">
                </div>
            </td>
        @else
            <td width="20%">
                {{--<img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px">--}}
            </td>
        @endif
        <td width="50%" class="pl-3">
            <div class="text-left">
                <h4 class="">{{ $company->name }}</h4>
                <h5>{{ 'RUC '.$company->number }}</h5>
                <h6>
                    {{ $establishment->address }}
                    {{ ', '.$district->description }}
                    {{ ', '.$province->description }}
                    {{ '- '.$department->description }}
                </h6>

                @isset($establishment->trade_address)
                    <h6>{{ ($establishment->trade_address !== '-')? 'D. Comercial: '.$establishment->trade_address : '' }}</h6>
                @endisset

                <h6>{{ ($establishment->telephone !== '-')? 'Central telefónica: '.$establishment->telephone : '' }}</h6>

                <h6>{{ ($establishment->email !== '-')? 'Email: '.$establishment->email : '' }}</h6>

                @isset($establishment->web_address)
                    <h6>{{ ($establishment->web_address !== '-')? 'Web: '.$establishment->web_address : '' }}</h6>
                @endisset

                @isset($establishment->aditional_information)
                    <h6>{{ ($establishment->aditional_information !== '-')? $establishment->aditional_information : '' }}</h6>
                @endisset
            </div>
        </td>
        <td width="30%" class="border-box py-4 px-2 text-center">
            <h5 class="text-center">{{ $documentType->description }}</h5>
            <h3 class="text-center">{{ $document_number }}</h3>
        </td>
    </tr>
</table>
<table class="full-width mt-5">
    <tr>
        <td width="120px">FECHA DE EMISIÓN</td>
        <td width="8px">:</td>
        <td>{{$document->date_of_issue}}</td>

        @if ($document->detraction)

            <td width="120px">N. CTA DETRACCIONES</td>
            <td width="8px">:</td>
            <td>{{ $document->detraction->bank_account}}</td>
        @endif
    </tr>
    @isset($invoice)
        @foreach ($invoice as $item)
        @if($item->date_of_due != $document->date_of_issue)
        <tr>
            <td>FECHA DE VENCIMIENTO</td>
            <td width="8px">:</td>
            <td>{{$item->date_of_due}}</td>
        </tr>
        @endif
        @endforeach
    @endisset

    @if ($document->detraction)
        <td width="140px">B/S SUJETO A DETRACCIÓN</td>
        <td width="8px">:</td>
        @inject('detractionType', 'App\Services\DetractionTypeService')
        <td width="220px">{{$document->detraction->detraction_type_id}} - {{ $detractionType->getDetractionTypeDescription($document->detraction->detraction_type_id ) }}</td>

    @endif
    <tr>
        <td>CLIENTE:</td>
        <td>:</td>
        <td>{{ $customer->name }}</td>

        @if ($document->detraction)
            <td width="120px">MÉTODO DE PAGO</td>
            <td width="8px">:</td>
            <td width="220px">{{ $detractionType->getPaymentMethodTypeDescription($document->detraction->payment_method_id ) }}</td>
        @endif

    </tr>
    <tr>
        <td>{{ $identity_document_type->description }}</td>
        <td>:</td>
        <td>{{$customer->number}}</td>

        @if ($document->detraction)

            <td width="120px">P. DETRACCIÓN</td>
            <td width="8px">:</td>
            <td>{{ $document->detraction->percentage}}%</td>
        @endif
    </tr>
    @if ($customer->address !== '')
    <tr>
        <td class="align-top">DIRECCIÓN:</td>
        <td>:</td>
        <td>
            {{ $customer->address }}
            @if($customer_district && $customer_province && $customer_department)
                {{ ', '.$customer_district->description }}
                {{ ', '.$customer_province->description }}
                {{ '- '.$customer_department->description }}
            @endif
        </td>

        @if ($document->detraction)
            <td width="120px">MONTO DETRACCIÓN</td>
            <td width="8px">:</td>
            <td>{{ $currency_type->symbol }} {{ $document->detraction->amount}}</td>
        @endif
    </tr>
    @endif
    @if ($document->detraction)
        @if($document->detraction->pay_constancy)
        <tr>
            <td colspan="3">
            </td>
            <td width="120px">CONSTANCIA DE PAGO</td>
            <td width="8px">:</td>
            <td>{{ $document->detraction->pay_constancy}}</td>
        </tr>
        @endif
    @endif
</table>

{{--<table class="full-width mt-3">--}}
    {{--@if ($document->purchase_order)--}}
        {{--<tr>--}}
            {{--<td width="25%">Orden de Compra: </td>--}}
            {{--<td>:</td>--}}
            {{--<td class="text-left">{{ $document->purchase_order }}</td>--}}
        {{--</tr>--}}
    {{--@endif--}}
    {{--@if ($document->quotation_id)--}}
        {{--<tr>--}}
            {{--<td width="15%">Cotización:</td>--}}
            {{--<td class="text-left" width="85%">{{ $document->quotation->identifier }}</td>--}}
        {{--</tr>--}}
    {{--@endif--}}
{{--</table>--}}

@if ($document->guides)
<br/>
{{--<strong>Guías:</strong>--}}
<table>
    @foreach($document->guides as $guide)
        <tr>
            @if(isset($guide->document_type_description))
            <td>{{ $guide->document_type_description }}</td>
            @else
            <td>{{ $guide->document_type_id }}</td>
            @endif
            <td>:</td>
            <td>{{ $guide->number }}</td>
        </tr>
    @endforeach
</table>
@endif



@if ($document->reference_guides)
<br/>
<strong>Guias de remisión</strong>
<table>
    @foreach($document->reference_guides as $guide)
        <tr>
            <td>{{ $guide->series }}</td>
            <td>-</td>
            <td>{{ $guide->number }}</td>
        </tr>
    @endforeach
</table>
@endif


<table class="full-width mt-3">
    @if ($document->prepayments)
        @foreach($document->prepayments as $p)
        <tr>
            <td width="120px">ANTICIPO</td>
            <td width="8px">:</td>
            <td>{{$p->number}}</td>
        </tr>
        @endforeach
    @endif
    @if ($document->purchase_order)
        <tr>
            <td width="120px">ORDEN DE COMPRA</td>
            <td width="8px">:</td>
            <td>{{ $document->purchase_order }}</td>
        </tr>
    @endif
    @if ($document->quotation_id)
        <tr>
            <td width="120px">COTIZACIÓN</td>
            <td width="8px">:</td>
            <td>{{ $document->quotation->identifier }}</td>

            @isset($document->quotation->delivery_date)
                    <td width="120px">F. ENTREGA</td>
                    <td width="8px">:</td>
                    <td>{{ $document->quotation->delivery_date->format('Y-m-d')}}</td>
            @endisset
        </tr>

    @endif
    @isset($document->quotation->sale_opportunity)
        <tr>
            <td width="120px">O. VENTA</td>
            <td width="8px">:</td>
            <td>{{ $document->quotation->sale_opportunity->number_full}}</td>
        </tr>
    @endisset
    @if(!is_null($document_base))
    <tr>
        <td width="120px">DOC. AFECTADO</td>
        <td width="8px">:</td>
        <td>{{ $affected_document_number }}</td>
    </tr>
    <tr>
        <td>TIPO DE NOTA</td>
        <td>:</td>
        <td>{{ ($document_base->note_type === 'credit')?$document_base->note_credit_type->description:$document_base->note_debit_type->description}}</td>
    </tr>
    <tr>
        <td>DESCRIPCIÓN</td>
        <td>:</td>
        <td>{{ $document_base->note_description }}</td>
    </tr>
    @endif
</table>

{{--<table class="full-width mt-3">--}}
    {{--<tr>--}}
        {{--<td width="25%">Documento Afectado:</td>--}}
        {{--<td width="20%">{{ $document_base->affected_document->series }}-{{ $document_base->affected_document->number }}</td>--}}
        {{--<td width="15%">Tipo de nota:</td>--}}
        {{--<td width="40%">{{ ($document_base->note_type === 'credit')?$document_base->note_credit_type->description:$document_base->note_debit_type->description}}</td>--}}
    {{--</tr>--}}
    {{--<tr>--}}
        {{--<td class="align-top">Descripción:</td>--}}
        {{--<td class="text-left" colspan="3">{{ $document_base->note_description }}</td>--}}
    {{--</tr>--}}
{{--</table>--}}

<table class="full-width mt-10 mb-10">
    <thead class="">
    <tr class="bg-grey">
        <th class="border-top-bottom text-center py-2" width="8%">CANT.</th>
        <th class="border-top-bottom text-center py-2" width="8%">UNIDAD</th>
        <th class="border-top-bottom text-left py-2">DESCRIPCIÓN</th>
        <!--th class="border-top-bottom text-center py-2" width="8%">LOTE</th-->
        <!--th class="border-top-bottom text-center py-2" width="8%">SERIE</th-->
        <th class="border-top-bottom text-right py-2" width="12%">P.UNIT</th>
        <th class="border-top-bottom text-right py-2" width="8%">DTO.</th>
        <th class="border-top-bottom text-right py-2" width="12%">TOTAL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($document_items as $row)
        <tr>
            <td class="text-center align-top">
                @if(((int)$row->quantity != $row->quantity))
                    {{ $row->quantity }}
                @else
                    {{ number_format($row->quantity, 0) }}
                @endif
            </td>
            <td class="text-center align-top">{{ json_decode($row->item)->unit_type_id }}</td>
            <td class="text-left align-top">
                {{ json_decode($row->item)->description }}
            </td>
            <!--td class="text-center align-top">
                {{--
                @inject('itemLotGroup', 'App\Services\ItemLotsGroupService')
                {{ $itemLotGroup->getLote($row->item->IdLoteSelected) }}
                --}}
            </td>
            <td class="text-center align-top">

                @isset($row->item->lots)
                    @foreach($row->item->lots as $lot)
                        @if( isset($lot->has_sale) && $lot->has_sale)
                            <span style="font-size: 9px">{{ $lot->series }}</span><br>
                        @endif
                    @endforeach
                @endisset

            </td-->
            <td class="text-right align-top">{{ number_format($row->unit_price, 2) }}</td>
            <td class="text-right align-top">
                @if($row->discounts)
                    @php
                        $total_discount_line = 0;
                        foreach ($row->discounts as $disto) {
                            $total_discount_line = $total_discount_line + $disto->amount;
                        }
                    @endphp
                    {{ number_format($total_discount_line, 2) }}
                @else
                0
                @endif
            </td>
            <td class="text-right align-top">{{ number_format($row->total, 2) }}</td>
        </tr>
        <tr>
            <td colspan="{{ $colspan6 }}" class="border-bottom"></td>
        </tr>
    @endforeach



    @if ($document->prepayments)
        @foreach($document->prepayments as $p)
        <tr>
            <td class="text-center align-top">
                1
            </td>
            <td class="text-center align-top">NIU</td>
            <td class="text-left align-top">
                ANTICIPO: {{($p->document_type_id == '02')? 'FACTURA':'BOLETA'}} NRO. {{$p->number}}
            </td>
            <td class="text-right align-top">-{{ number_format($p->total, 2) }}</td>
            <td class="text-right align-top">
                0
            </td>
            <td class="text-right align-top">-{{ number_format($p->total, 2) }}</td>
        </tr>
        <tr>
            <td colspan="6" class="border-bottom"></td>
        </tr>
        @endforeach
    @endif

        @if($document->total_exportation > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">OP. EXPORTACIÓN: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_exportation, 2) }}</td>
            </tr>
        @endif
        @if($document->total_free > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">OP. GRATUITAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_free, 2) }}</td>
            </tr>
        @endif
        @if($document->total_unaffected > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">OP. INAFECTAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_unaffected, 2) }}</td>
            </tr>
        @endif
        @if($document->total_exonerated > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">OP. EXONERADAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_exonerated, 2) }}</td>
            </tr>
        @endif
        @if($document->total_taxed > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">OP. GRAVADAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_taxed, 2) }}</td>
            </tr>
        @endif
         @if($document->total_discount > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">{{(($document->total_prepayment > 0) ? 'ANTICIPO':'DESCUENTO TOTAL')}}: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_discount, 2) }}</td>
            </tr>
        @endif
        @if($document->total_plastic_bag_taxes > 0)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">ICBPER: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_plastic_bag_taxes, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="{{ $colspan }}" class="text-right font-bold">IGV: {{ $currency_type->symbol }}</td>
            <td class="text-right font-bold">{{ number_format($document->total_igv, 2) }}</td>
        </tr>

        @if($document->perception)
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold"> IMPORTE TOTAL: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total, 2) }}</td>
            </tr>
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">PERCEPCIÓN: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->perception->amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">TOTAL A PAGAR: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format(($document->total + $document->perception->amount), 2) }}</td>
            </tr>
        @else
            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">TOTAL A PAGAR: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total, 2) }}</td>
            </tr>
        @endif

        @if($balance < 0)

            <tr>
                <td colspan="{{ $colspan }}" class="text-right font-bold">VUELTO: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format(abs($balance),2, ".", "") }}</td>
            </tr>

        @endif



    </tbody>
</table>
<table class="full-width">
    <tr>
        <td width="65%" style="text-align: top; vertical-align: top;">
            @php
            $legend = json_decode($document->legends);
            @endphp
            {{-- @foreach(array_reverse( (array) $legends) as $row) --}}
                @if ($legend->code == "1000")
                    <p>Son: <span class="font-bold">{{ $legend->value }} {{ $currency_type->description }}</span></p>
                    @if (count((array) $document->legends)>1)
                        <p><span class="font-bold">Leyendas</span></p>
                    @endif
                @else
                    <p> {{$legend->code}}: {{ $legend->value }} </p>
                @endif

            {{-- @endforeach --}}
            <br/>
            @if ($document->detraction)
            <p>
                <span class="font-bold">
                Operación sujeta al Sistema de Pago de Obligaciones Tributarias
                </span>
            </p>
            <br/>
            @endif
            @if ($customer->department_id == 16)
                <br/><br/><br/>
                <div>
                    <center>
                        Representación impresa del Comprobante de Pago Electrónico.
                        <br/>Esta puede ser consultada en:
                        <br/><b>{!! url('/buscar') !!}</b>
                        <br/> "Bienes transferidos en la Amazonía
                        <br/>para ser consumidos en la misma".
                    </center>
                </div>
                <br/>
            @endif

            @if ($document->additional_information)
                <strong>Información adicional</strong>
                <p>{{ $document->additional_information }}</p>
            @endif

            <br>
            {{--
            @if(in_array($document->document_type_id,['01','03']))
                @foreach($accounts as $account)
                    <p><span class="font-bold">{{$account->description}}</span> {{$account->currency_type->description}} {{$account->number}}</p>
                @endforeach
            @endif
            --}}
        </td>
        <td width="35%" class="text-right">
            <img src="data:image/png;base64, {{ $document->qr }}" style="margin-right: -10px;" />
            <p style="font-size: 9px">Código Hash: {{ $document->hash }}</p>
        </td>
    </tr>
</table>
@if($payments->count())


    <table class="full-width">
        <tr>
            <td>
                <strong>PAGOS:</strong>
            </td>
        </tr>
            @php
                $payment = 0;
            @endphp
            @foreach($payments as $row)
                <tr>
                    <td>&#8226; {{ $row->description }} - {{ $row->reference ? $row->reference.' - ':'' }} {{ $currency_type->symbol }} {{ number_format($row->payment + $row->change, 2, '.', '') }}</td>
                </tr>
            @endforeach
        </tr>

    </table>
@endif

@if($document->user)
     <br>
    <table class="full-width">
        <tr>
            <td>
                <strong>Vendedor:</strong>
            </td>
        </tr>
        <tr>
            <td>{{ $user->name  }}</td>
        </tr>
    </table>

@endif
</body>
</html>
