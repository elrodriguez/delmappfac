<table>
    <thead>
        <tr>
            <th colspan="8"><h1>@lang('messages.incidents')</h1></th>
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
            <th class="text-center">{{ __('messages.si_no') }}</th>
            <th class="text-center">{{ __('messages.date') }}</th>
            <th class="text-center">{{ __('messages.ticket') }}</th>
            <th>{{ __('messages.final_comment') }}</th>
            <th>{{ __('messages.description') }}</th>
            <th>{{ __('messages.establishment') }}</th>
            <th>{{ __('messages.category') }}</th>
            <th>{{ __('messages.subcategory') }}</th>
            <th>{{ __('messages.user') }}</th>
            <th class="text-center">{{ __('messages.state') }}</th>
            <th>{{ __('messages.area') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>
                    @if($item['time_elapsed'] <= $item['time_limit'])
                        <span class="text-primary">{{ __('messages.during_time') }}</span>
                    @else
                        <span class="text-danger">{{ __('messages.out_of_time') }}</span>
                    @endif
                </td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y') }}</td>
                <td class="text-center">{{ $item['internal_id'] }}</td>
                <td>
                    @if(json_decode($item['solutions']))
                        @foreach (json_decode($item['solutions']) as $solution)
                            <p>{{ $solution->description }}</p>
                        @endforeach
                    @endif
                </td>
                <td>{{ $item['description_of_problem'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['category_description'] }}</td>
                <td>{{ $item['subcategory_description'] }}</td>
                <td>{{ $item['user_email'] }}</td>
                <td>
                    @if($item['state'] == 'sent')
                        <span class="badge badge-primary badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'attended')
                        <span class="badge badge-secondary badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'derivative')
                        <span class="badge badge-dark badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'cancel')
                        <span class="badge badge-danger badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'closed_ok')
                        <span class="badge badge-info badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @elseif($item['state'] == 'closed_fail')
                        <span class="badge badge-warning badge-pill">{{ __('messages.'.$item['state']) }}</span>
                    @endif
                </td>
                <td>{{ $item['area_description'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
