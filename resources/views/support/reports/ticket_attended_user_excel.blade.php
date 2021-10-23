<table>
    <thead>
        <tr>
            <th colspan="8"><h1>@lang('messages.ticket_attended_by_user')</h1></th>
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
            <td class="align-middle">{{ __('messages.name') }}</td>
            <td class="align-middle">{{ __('messages.state') }}</td>
            <td class="text-center align-middle">{{ __('messages.quantity') }}</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item['trade_name'] }}</td>
                <td>
                    @if($item['state'] == 'sent')
                        <span class="badge badge-primary badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'attended')
                        <span class="badge badge-secondary badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'derivative')
                        <span class="badge badge-dark badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'cancel')
                        <span class="badge badge-danger badge-pill">{{ __('messages.rejected') }}</span>
                    @elseif($item['state'] == 'closed_ok')
                        <span class="badge badge-info badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'closed_fail')
                        <span class="badge badge-warning badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @endif
                </td>
                <td class="text-right">{{ $item['quantity'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
