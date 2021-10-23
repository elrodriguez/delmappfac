<table>
    <thead>
        <tr>
            <th colspan="8"><h1>@lang('messages.kardex_valued')</h1></th>
        </tr>
        <tr>
            <th colspan="2">{{ __('messages.date') }}</th>
            <th colspan="6">{{ $parameters['start'].' - '.$parameters['end']  }}</th>
        </tr>
        <tr>
            <th colspan="2">{{ __('messages.establishment') }}</th>
            <th colspan="6">{{ $parameters['establisment'] }}</th>
        </tr>
        <tr>
            <th colspan="8"></th>
        </tr>
        <tr>
            <th colspan="8"></th>
        </tr>
        <tr>
            {{-- <th>{{ __('messages.image') }}</th> --}}
            <th>{{ __('messages.product') }}</th>
            <th>{{ __('messages.brand') }}</th>
            <th>Unidad</th>
            <th>Unidades físicas vendidas</th>
            <th>Costo unitario</th>
            <th>Valor de ventas</th>
            <th>Costo de producto</th>
            <th>Unidad valorizada</th>
        </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            {{-- <td>
                <img src="{{ asset('storage/items/'.$item["id"].'.jpg')}}" width=50px height=50px  ></img>
            </td> --}}
            <td>{{ $item['description'] }}</td>
            <td>{{ $item['name'] }}</td>
            <td>{{ $item['unit_type_id'] }}</td>
            <td>{{ $item['item_quantity'] }}</td>
            <td>{{ $item['purchase_unit_price'] }}</td>
            <td>{{ $item['item_total'] }}</td>
            <td>{{ $item['item_cost'] }}</td>
            <td>{{ $item['valued_unit'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
