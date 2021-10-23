<div>
    @if (Gate::check('addTeamMember', $team))
        <div id="panel-2" class="panel">
            <div class="panel-hdr">
                <h2>
                @lang('messages.add_team_member') <span class="fw-300"><i>@lang('messages.msg_add_member')</i></span>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <form wire:submit.prevent="addTeamMember">
                    <div class="panel-content">
                        <div class="panel-tag">
                        @lang('messages.msg_add_member_info')
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">@lang('messages.email')</label>
                            <input id="email"
                                type="text"
                                class="form-control"
                                wire:model.defer="addTeamMemberForm.email" />
                            <x-jet-input-error for="email" class="mt-2" />
                        </div>
                        @if (count($this->roles) > 0)
                            <div class="form-group">
                                <label class="form-label" for="role" />@lang('messages.role')</label>
                                <x-jet-input-error for="role" class="mt-2" />

                                <div class="mt-1">
                                    @foreach ($this->roles as $index => $role)
                                        <div class="card mb-2 {{ $addTeamMemberForm['role'] == $role->key ? 'border-warning' : '' }}" wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')" style="cursor:pointer;">
                                            <div class="card-body {{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="icon-stack display-3 flex-shrink-0">
                                                        @if ($addTeamMemberForm['role'] == $role->key)
                                                            <svg width="56px" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        @endif
                                                    </div>
                                                    <div class="ml-3 {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                        <strong>
                                                        {{ $role->name }}
                                                        </strong>
                                                        <br>
                                                        {{ $role->description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    @if (Gate::check('update', $team))
                    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                        <x-jet-action-message class="mr-3" on="saved">
                            {{ __('Added.') }}
                        </x-jet-action-message>
                        <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    @endif

    @if ($team->users->isNotEmpty())
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                {{ __('Team Members') }} <span class="fw-300"><i>{{ __('All of the people that are part of this team.') }}</i></span>
                </h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="d-flex flex-wrap demo demo-h-spacing mt-3 mb-3">
                    @foreach ($team->users->sortBy('name') as $user)
                        <div class="rounded-pill bg-white shadow-sm p-2 border-faded mr-3 d-flex flex-row align-items-center justify-content-center flex-shrink-0">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="img-thumbnail img-responsive rounded-circle" style="width:5rem; height: 5rem;">
                            <div class="ml-2 mr-3">
                                <h5 class="m-0">
                                    {{ $user->name }}
                                </h5>
                                @if (Gate::check('addTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                    <a href="javascript:void(0)" class="text-info fs-sm" wire:click="manageRole('{{ $user->id }}')" data-toggle="modal" data-target="#exampleModal-update-role">
                                        {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                    </a>
                                @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                    <a href="javascript:void(0)" class="text-info fs-sm" >
                                        {{ Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name }}
                                    </a>
                                @endif
                                &#8211;
                                <!-- Leave Team -->
                                @if ($this->user->id === $user->id)
                                    <a href="javascript:void(0)" class="text-info fs-sm" wire:click="$toggle('confirmingLeavingTeam')">
                                        {{ __('Leave') }}
                                    </a>

                                <!-- Remove Team Member -->
                                @elseif (Gate::check('removeTeamMember', $team))
                                    <a href="javascript:void(0)" title="{{ __('Remove') }}" class="text-info fs-sm" wire:click="confirmTeamMemberRemoval('{{ $user->id }}')" data-toggle="modal" data-target="#exampleModal-remove-member">
                                        <i class="fal fa-trash-alt"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div wire:ignore.self wire:model="currentlyManagingRole" class="modal fade" id="exampleModal-update-role" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Manage Role') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach ($this->roles as $index => $role)
                        <div class="card mb-2 {{ $addTeamMemberForm['role'] == $role->key ? 'border-warning' : '' }}" wire:click="$set('currentRole', '{{ $role->key }}')" style="cursor:pointer;">
                            <div class="card-body {{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="icon-stack display-3 flex-shrink-0">
                                        @if ($currentRole == $role->key)
                                            <svg width="56px" class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>
                                    <div class="ml-3 {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                        <strong>
                                        {{ $role->name }}
                                        </strong>
                                        <br>
                                        {{ $role->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="stopManagingRole" wire:loading.attr="disabled">Close</button>
                    <button type="button" class="btn btn-primary"  wire:click="updateRole" wire:loading.attr="disabled" data-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self wire:model="confirmingLeavingTeam" class="modal" tabindex="-1" id="exampleModal-remove-my-user">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Leave Team') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ __('Are you sure you would like to leave this team?') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">{{ __('Nevermind') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="leaveTeam" wire:loading.attr="disabled">{{ __('Leave') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self wire:model="confirmingTeamMemberRemoval" class="modal fade" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" id="exampleModal-remove-member">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Remove Team Member') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert bg-info-400 text-white fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon">
                            <i class="fal fa-info-circle"></i>
                        </div>
                        <div class="flex-1">
                            {{ __('Are you sure you would like to remove this person from the team?') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">{{ __('Nevermind') }}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" wire:click="removeTeamMember" wire:loading.attr="disabled">{{ __('Remove') }}</button>
            </div>
            </div>
        </div>
    </div>
</div>
