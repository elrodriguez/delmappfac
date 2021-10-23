<div>
    <div class="input-group input-group-lg mb-5 shadow-1 rounded">
		<input wire:model.defer="search" wire:keydown.enter="searchTicket" type="text" class="form-control shadow-inset-2" id="filter-icon" aria-label="type 2 or more letters" placeholder="{{ __('messages.search_ticket_by_code') }}">
		<div class="input-group-append">
			<button wire:click="searchTicket" class="btn btn-primary hidden-sm-down waves-effect waves-themed" type="button"><i class="fal fa-search mr-lg-2"></i><span class="hidden-md-down">{{ __('messages.search') }}</span></button>
			<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="sr-only">Toggle Dropdown</span>
			</button>
			<div class="dropdown-menu dropdown-menu-right" style="">
				<a class="dropdown-item" href="javascript:void(0)" wire:click="changeView('cards')"><i class="fal fa-window-maximize mr-1"></i>{{ __('messages.cards') }}</a>
				<a class="dropdown-item" href="javascript:void(0)" wire:click="changeView('table')"><i class="fal fa-table mr-1"></i>{{ __('messages.table') }}</a>
			</div>
		</div>
	</div>
    @if($perspective == 'cards')
        <div class="card-columns">
            @foreach ($tickets as $ticket)
                <div class="card">
                    <div class="card-header py-2 pr-2 d-flex align-items-center flex-wrap">
                        <div class="card-title">{{ __('messages.number') }} {{ $ticket->internal_id }}</div>
                        <div class="d-flex position-relative ml-auto" style="max-width: 10rem;">
                            {{ \Carbon\Carbon::parse($ticket->date_application)->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">{{ $ticket->description_of_problem }}</p>
                        <p class="card-text text-center">
                            @if ($ticket->sup_panic_level_id == 1)
                                <span class="badge badge-warning">{{ $ticket->description }}</span>
                            @else
                                <span class="badge badge-danger">{{ $ticket->description }}</span>
                            @endif
                        </p>
                        <p class="card-text text-center">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($ticket->created_at)->diffForHumans() }}</small>
                        </p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="fw-900">{{ __('messages.state') }}</span>
                            @if($ticket->state == 'sent')
                                <span class="badge badge-primary badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                            @elseif($ticket->state == 'attended')
                                <span class="badge badge-secondary badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                            @elseif($ticket->state == 'derivative')
                                <span class="badge badge-dark badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                            @elseif($ticket->state == 'cancel')
                                <span class="badge badge-danger badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                            @elseif($ticket->state == 'closed_ok')
                                <span class="badge badge-info badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                            @elseif($ticket->state == 'closed_fail')
                                <span class="badge badge-warning badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                            @endif
                        </li>
                    </ul>
                    <div class="row row-grid no-gutters">
                        <div class="col-12">
                            <div class="p-3">
                                <h2 class="mb-0 fs-xl">
                                    {{ __('messages.participants') }}
                                </h2>
                            </div>
                        </div>
                        @foreach (json_decode($ticket->users) as $user)
                            <div class="col-4">
                                <div class="text-center p-3 d-flex flex-column hover-highlight">
                                    @if($user->avatar)
                                        <span class="profile-image rounded-circle d-block m-auto" style="background-image:url('{{ asset('storage/'.$user->avatar) }}'); background-size: cover;"></span>
                                    @else
                                        <span class="profile-image rounded-circle d-block m-auto" style="background-image:url('{{ ui_avatars_url($user->name,32,'none') }}'); background-size: cover;"></span>
                                    @endif
                                    <span class="d-block text-truncate text-muted fs-xs mt-1">{{ $user->name }}</span>
                                    <span class="d-block text-truncate text-gradient fs-xs mt-1 fw-900">{{ __('messages.'.$user->type) }}</span>
                                    <span class="d-block text-truncate text-muted fs-xs mt-1">{{ $user->description }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($ticket->state == 'sent' || $ticket->state == 'attended' || $ticket->state == 'derivative')
                        <div class="card-footer text-center">
                            <button wire:click="attended({{ $ticket->id }})" type="button" class="btn btn-sm btn-outline-dark waves-effect waves-themed">{{ __('messages.attend') }}
                                <i class="fal fa-arrow-right ml-3"></i>
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @elseif($perspective == 'table')
        <div class="table-responsive">
            <table id="dt-basic-example" class="table table-bordered table-striped w-100">
                <thead class="bg-primary-600">
                    <tr>
                        <th class="text-center">{{ __('messages.actions') }}</th>
                        <th class="text-center">{{ __('messages.date') }}</th>
                        <th class="text-center">{{ __('messages.ticket') }}</th>
                        <th>{{ __('messages.description') }}</th>
                        <th class="text-center">{{ __('messages.priority') }}</th>
                        <th class="text-center">{{ __('messages.state') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td class="text-center align-middle">
                                @if($ticket->state == 'sent' || $ticket->state == 'attended' || $ticket->state == 'derivative')
                                    <a wire:click="attended({{ $ticket->id }})" href="javascript:void(0);" class="btn btn-primary btn-icon rounded-circle waves-effect waves-themed" data-toggle="tooltip" data-placement="right" title="{{ __('messages.attend') }}" data-original-title="{{ __('messages.attend') }}">
                                        <i class="fal fa-arrow-alt-right"></i>
                                    </a>
                                @else
                                    <i class="fal fa-lock-alt"></i>
                                @endif
                            </td>
                            <td class="text-center align-middle">{{ \Carbon\Carbon::parse($ticket->date_application)->format('d/m/Y') }}</td>
                            <td class="text-center align-middle">{{ $ticket->internal_id }}</td>
                            <td class="align-middle">{{ $ticket->description_of_problem }}</td>
                            <td class="align-middle">{{ $ticket->description }}</td>
                            <td class="align-middle">
                                @if($ticket->state == 'sent')
                                    <span class="badge badge-primary badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                                @elseif($ticket->state == 'attended')
                                    <span class="badge badge-secondary badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                                @elseif($ticket->state == 'derivative')
                                    <span class="badge badge-dark badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                                @elseif($ticket->state == 'cancel')
                                    <span class="badge badge-danger badge-pill">{{ __('messages.rejected') }}</span>
                                @elseif($ticket->state == 'closed_ok')
                                    <span class="badge badge-info badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                                @elseif($ticket->state == 'closed_fail')
                                    <span class="badge badge-warning badge-pill">{{ __('messages.'.$ticket->state) }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    <div>
        {{ $tickets->links() }}
    </div>
</div>
