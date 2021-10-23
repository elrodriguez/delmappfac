<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>@lang('messages.search_filters')</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="warehouse" class="form-label">Código Ticket</label>
                        <input wire:model.defer="ticket_id" type="text" class="form-control" />
                        @error('ticket_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                        <button wire:click="searchTicket" wire:loading.attr="disabled" type="button" class="btn btn-primary ml-auto waves-effect waves-themed" >
                            <span class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                            <span>{{ __('messages.search') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    @if($ticket_start)
        <div id="panel-2" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <div style="width:100%">
                        <h1 class="time-line-h1">Ticket {{ $ticket_start->internal_id }}</h1>
                        <ol class="time-line-ol" style="width:100%">
                            <li class="time-line-li text-light">
                                <p class="event-date">{{ $ticket_start->trade_name }}</p>
                                <p class="event-date">{{ __('messages.application_date') }}: {{ \Carbon\Carbon::parse($ticket_start->date_application)->format('d/m/Y') }}</p>
                                <p class="event-description">
                                    {{ $ticket_start->description_of_problem }}
                                </p>
                            </li>
                            @foreach($records as $record)
                                <li class="time-line-li">
                                    <p class="event-date">{{ $record->trade_name }}</p>
                                    <p class="event-date">{{ __('messages.'.$record->state) }}: {{ \Carbon\Carbon::parse($record->created_at)->format('d/m/Y H:i:s') }}</p>
                                    <p class="event-date text-primary">{{ $record->area_description }}</p>
                                    <p class="event-date text-primary">{{ $record->group_description }}</p>
                                    <p class="event-description">
                                        {{ $record->description }}
                                    </p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-3" class="panel">
            <div class="panel-container show">
                <div class="panel-content">
                    <div style="width:100%">
                        <h1 class="time-line-h1">Mensajes Internos</h1>
                        <ul class="timeline">
                            @foreach ($chats as $key => $chat)
                                <li>
                                    <div class="{{ $key == 0? 'direction-l':'direction-r' }}">
                                        <div class="flag-wrapper">
                                            <span class="hexa"></span>
                                            <span class="flag" data-toggle="tooltip" data-placement="top" data-original-title="{{ $chat->trade_name }}" title="{{ $chat->trade_name }}">{{ strlen($chat->trade_name) > 19 ? substr($chat->trade_name, 0, 20).'...' : $chat->trade_name }}</span>
                                            <span class="time-wrapper"><span class="time">{{ \Carbon\Carbon::parse($chat->created_at)->format('d/m/Y') }}</span></span>
                                        </div>
                                        <div class="desc">{{ $chat->message }}</div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
