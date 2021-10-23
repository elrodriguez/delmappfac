<table>
    <thead>
        <tr>
            <th colspan="8"><h1>@lang('messages.state_summaries')</h1></th>
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
            <th class="text-center align-middle" rowspan="2">{{ __('messages.name') }} {{ __('messages.group') }}</th>
            <th class="text-center align-middle" colspan="10">{{ __('messages.state') }}</th>
        </tr>
        <tr>
            <td class="text-center">{{ __('messages.attended') }}</td>
            <td class="text-center align-middle">{{ __('messages.derivative') }}</td>
            <td class="text-center align-middle">{{ __('messages.rejected') }}</td>
            <td class="text-center align-middle">{{ __('messages.closed_ok') }}</td>
            <td class="text-center align-middle">{{ __('messages.closed_fail') }}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($items['groups'] as $group)
            <tr>
                <td>{{ $group['description'] }}</td>
                <td class="text-right">{{ $group['attended'] }}</td>
                <td class="text-right">{{ $group['derivative'] }}</td>
                <td class="text-right">{{ $group['cancel'] }}</td>
                <td class="text-right">{{ $group['closed_ok'] }}</td>
                <td class="text-right">{{ $group['closed_fail'] }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" style="text-align: center">{{ __('messages.grand_total') }}</th>
        </tr>
        <tr>
            <th class="text-right">{{ __('messages.total_ticket') }}</th>
            <th colspan="5" class="text-right">{{ $items['tickets'] }}</th>
        </tr>
        <tr>
            <th class="text-right">{{ __('messages.total_pending_attention') }}</th>
            <th colspan="5" class="text-right">{{ $items['tickets_pending'] }}</th>
        </tr>
    </tfoot>
</table>
