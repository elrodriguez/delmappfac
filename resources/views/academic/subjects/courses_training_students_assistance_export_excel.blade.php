@php
    $day = '';
    $days = json_decode($assistances[0]['assistance']);
@endphp
<table>
    <thead>
    <tr>
        <th>DNI</th>
        <th>{{ __('messages.name') }}</th>
        @foreach ($days as $item)
            @if ($day != $item->day)
                <th>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</th>
            @endif
            @php
                $day = $item->day;
            @endphp
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($assistances as $assistance)
        <tr>
            <td>{{ $assistance['number'] }}</td>
            <td>{{ $assistance['trade_name'] }}</td>
            @foreach (json_decode($assistance['assistance']) as $item)
                <td>{{ ($item->attended?'Asistió':'Faltó') }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
