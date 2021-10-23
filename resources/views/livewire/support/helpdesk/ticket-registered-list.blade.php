<div>
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
                <div class="card-footer text-center">
                @can('soporte_tecnico_helpdesk_ticket_registrados_editar')
                    <button wire:click="edit('{{ myencrypt($ticket->id) }}')" type="button" class="btn btn-sm btn-outline-dark waves-effect waves-themed">{{ __('messages.edit') }}
                        <i class="fal fa-arrow-right ml-3"></i>
                    </button>
                @endcan
                </div>
            </div>
        @endforeach
    </div>
    <div>
        {{ $tickets->links() }}
    </div>
</div>
