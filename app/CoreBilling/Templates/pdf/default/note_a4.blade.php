@php
    $establishment = json_decode($document->establishment);
    $customer = json_decode($document->customer);

    $district = \Illuminate\Support\Facades\DB::table('districts')->where('id',$establishment->district_id)->first();
    $province = \Illuminate\Support\Facades\DB::table('provinces')->where('id',$establishment->province_id)->first();
    $department = \Illuminate\Support\Facades\DB::table('departments')->where('id',$establishment->department_id)->first();

    $customer_district = \Illuminate\Support\Facades\DB::table('districts')->where('id',$customer->district_id)->first();
    $customer_province = \Illuminate\Support\Facades\DB::table('provinces')->where('id',$customer->province_id)->first();
    $customer_department = \Illuminate\Support\Facades\DB::table('departments')->where('id',$customer->department_id)->first();

    $identity_document_type = \App\Models\Catalogue\IdentityDocumentType::find($customer->identity_document_type_id);
    $documentType = \App\Models\Catalogue\DocumentType::find($document->document_type_id);

    $document_base = $document->note;
    $document_number = $document->series.'-'.str_pad($document->number, 8, '0', STR_PAD_LEFT);
    $currency_type = \App\Models\Catalogue\CurrencyType::find($document->currency_type_id);

    $note_credit_type = \App\Models\Catalogue\NoteCreditType::find($document_base->note_credit_type_id);
    $note_debit_type = \App\Models\Catalogue\NoteDebitType::find($document_base->note_debit_type_id);

    $document_type_description_array = [
        '01' => 'FACTURA',
        '03' => 'BOLETA DE VENTA',
        '07' => 'NOTA DE CREDITO',
        '08' => 'NOTA DE DEBITO',
    ];
    $identity_document_type_description_array = [
        '-' => 'S/D',
        '0' => 'S/D',
        '1' => 'DNI',
        '6' => 'RUC',
    ];

    $affected_document_number = ($document_base->affected_document) ? $document_base->affected_document->series.'-'.str_pad($document_base->affected_document->number, 8, '0', STR_PAD_LEFT) : $document_base->data_affected_document->series.'-'.str_pad($document_base->data_affected_document->number, 8, '0', STR_PAD_LEFT);

    //$affected_document_number = $document_base->affected_document->series.'-'.str_pad($document_base->affected_document->number, 8, '0', STR_PAD_LEFT);
    //$path_style = app_path('CoreFacturalo'.DIRECTORY_SEPARATOR.'Templates'.DIRECTORY_SEPARATOR.'pdf'.DIRECTORY_SEPARATOR.'style.css');
@endphp
<html>
<head>
    {{--<title>{{ $document_number }}</title>--}}
    {{--<link href="{{ $path_style }}" rel="stylesheet" />--}}
</head>
<body>

<table class="full-width">
    <tr>
        @if($company->logo)
            <td width="20%">
                <div class="company_logo_box">
                    <img src="data:{{mime_content_type(public_path("storage/{$company->logo}"))}};base64, {{base64_encode(file_get_contents(public_path("storage/{$company->logo}")))}}" alt="{{$company->name}}" alt="{{ $company->name }}" class="company_logo" style="max-width: 150px;">
                </div>
            </td>
        @else
            <td width="20%">
                <img src="{{ asset('logo/logo.jpg') }}" class="company_logo" style="max-width: 150px">
            </td>
        @endif
        <td width="50%" class="pl-3">
            <div class="text-left">
                <h4 class="">{{ $company->name }}</h4>
                <h5>{{ 'RUC '.$company->number }}</h5>
                <h6>
                    {{ ($establishment->address !== '-')? $establishment->address : '' }}
                    {{ ($establishment->district_id !== '-')? ', '.$district->description : '' }}
                    {{ ($establishment->province_id !== '-')? ', '.$province->description : '' }}
                    {{ ($establishment->department_id !== '-')? '- '.$department->description : '' }}
                </h6>
                <h6>{{ ($establishment->email !== '-')? $establishment->email : '' }}</h6>
                <h6>{{ ($establishment->phone !== '-')? $establishment->phone : '' }}</h6>
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
        <td width="5px">:</td>
        <td>{{ $document->date_of_issue }}</td>
    </tr>
    <tr>
        <td>CLIENTE</td>
        <td>:</td>
        <td>{{ $customer->name }}</td>
    </tr>
    <tr>
        
        <td>{{ $identity_document_type->description }}</td>
        <td>:</td>
        <td>{{ $customer->number }}</td>
        {{--@isset($document->date_of_due)--}}
            {{--<td>Fecha de vencimiento:</td>--}}
            {{--<td>{{ $document->date_of_due }}</td>--}}
        {{--@endisset--}}
    </tr>

    @if ($customer->address !== '')
    <tr>
        <td class="align-top">DIRECCIÓN</td>
        <td>:</td>
        <td>
            {{ $customer->address }}
            @if($customer_district && $customer_province && $customer_department)
                {{ ($customer->district_id !== '-')? ', '.$customer_district->description : '' }}
                {{ ($customer->province_id !== '-')? ', '.$customer_province->description : '' }}
                {{ ($customer->department_id !== '-')? '- '.$customer_department->description : '' }}
            @endif
            
        </td>
    </tr>
    @endif
</table>

@if ($document->guides)
<table class="full-width mt-3">
@foreach($document->guides as $guide)
    <tr>
        <td>{{ $guide->document_type_id }}</td>
        <td>{{ $guide->number }}</td>
    </tr>
@endforeach
</table>
@endif

<table class="full-width mt-3">
    @if ($document->purchase_order)
    <tr>
        <td>ORDEN DE COMPRA</td>
        <td>:</td>
        <td>{{ $document->purchase_order }}</td>
    </tr>
    @endif
    <tr>
        <td width="120px">DOC. AFECTADO</td>
        <td width="5px">:</td>
        <td>{{ $affected_document_number }}</td>
    </tr>
    <tr>
        <td>TIPO DE NOTA</td>
        <td>:</td>
        <td>{{ ($document_base->note_type === 'credit')?$note_credit_type->description:$note_debit_type->description}}</td>
    </tr>
    <tr>
        <td>DESCRIPCIÓN</td>
        <td>:</td>
        <td>{{ $document_base->note_description }}</td>
    </tr>
</table>

<table class="full-width mt-10 mb-10">
    <thead class="">
    <tr class="bg-grey">
        <th class="border-top-bottom text-center py-2" width="8%">CANT.</th>
        <th class="border-top-bottom text-center py-2" width="8%">UNIDAD</th>
        <th class="border-top-bottom text-left py-2">DESCRIPCIÓN</th>
        <th class="border-top-bottom text-right py-2" width="12%">P.UNIT</th>
        <th class="border-top-bottom text-right py-2" width="8%">DTO.</th>
        <th class="border-top-bottom text-right py-2" width="12%">TOTAL</th>
    </tr>
    </thead>
    <tbody>
        
    @foreach($document->items as $row)
        <tr>
            <td class="text-center">
                @if(((int)$row->quantity != $row->quantity))
                    {{ $row->quantity }}
                @else
                    {{ number_format($row->quantity, 0) }}
                @endif
            </td>
            <td class="text-center">{{ $row->unit_type_id }}</td>
            <td class="text-left">
                {!! $row->description !!}
                @if($row->attributes)
                    @foreach($row->attributes as $attr)
                        <br/><span style="font-size: 9px">{!! $attr->description !!} : {{ $attr->value }}</span>
                    @endforeach
                @endif
                @if($row->discounts)
                    @foreach($row->discounts as $dtos)
                        <br/><span style="font-size: 9px">{{ $dtos->factor * 100 }}% {{$dtos->description }}</span>
                    @endforeach
                @endif
            </td>
            <td class="text-right">{{ number_format($row->unit_price, 2) }}</td>
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
            <td class="text-right">{{ number_format($row->total, 2) }}</td>
        </tr>
        <tr>
            <td colspan="6" class="border-bottom"></td>
        </tr>
    @endforeach
        @if($document->total_exportation > 0)
            <tr>
                <td colspan="5" class="text-right font-bold">OP. EXPORTACIÓN: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_exportation, 2) }}</td>
            </tr>
        @endif
        @if($document->total_free > 0)
            <tr>
                <td colspan="5" class="text-right font-bold">OP. GRATUITAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_free, 2) }}</td>
            </tr>
        @endif
        @if($document->total_unaffected > 0)
            <tr>
                <td colspan="5" class="text-right font-bold">OP. INAFECTAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_unaffected, 2) }}</td>
            </tr>
        @endif
        @if($document->total_exonerated > 0)
            <tr>
                <td colspan="5" class="text-right font-bold">OP. EXONERADAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_exonerated, 2) }}</td>
            </tr>
        @endif
        @if($document->total_taxed > 0)
            <tr>
                <td colspan="5" class="text-right font-bold">OP. GRAVADAS: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_taxed, 2) }}</td>
            </tr>
        @endif
        @if($document->total_discount > 0)
            <tr>
                <td colspan="5" class="text-right font-bold">{{(($document->total_prepayment > 0) ? 'ANTICIPO':'DESCUENTO TOTAL')}}: {{ $currency_type->symbol }}</td>
                <td class="text-right font-bold">{{ number_format($document->total_discount, 2) }}</td>
            </tr>
        @endif
        <tr>
            <td colspan="5" class="text-right font-bold">IGV: {{ $currency_type->symbol }}</td>
            <td class="text-right font-bold">{{ number_format($document->total_igv, 2) }}</td>
        </tr>
        <tr>
            <td colspan="5" class="text-right font-bold">TOTAL A PAGAR: {{ $currency_type->symbol }}</td>
            <td class="text-right font-bold">{{ number_format($document->total, 2) }}</td>
        </tr>
    </tbody>
    <tfoot style="border-top: 1px solid #333;">
    <tr>
        <td colspan="5" class="font-lg"  style="padding-top: 2rem;">Son: <span class="font-bold">{{ $document->number_to_letter }} {{ $currency_type->description }}</span></td>
    </tr>
    @if(isset($document->optional->observations))
        <tr>
            <td colspan="3"><b>Obsevaciones</b></td>
            <td colspan="2"></td>
        </tr>
        <tr>
            <td colspan="3">{{ $document->optional->observations }}</td>
            <td colspan="2"></td>
        </tr>
    @endif
    </tfoot>
</table>

<table class="full-width">
    <tr>
        <td width="65%">
            <div class="text-left"><img class="qr_code" src="data:image/png;base64, {{ $document->qr }}" /></div>
            <p>Código Hash: {{ $document->hash }}</p>
        </td>
    </tr>
</table>
</body>
</html>