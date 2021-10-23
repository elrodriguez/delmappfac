<div>
    <div class="card border m-auto m-lg-0 mb-g">
        <div class="card-body">
            <h5 class="card-title">@lang('messages.browser_sessions')</h5>
            <p class="card-text">@lang('messages.msg_info_browser')</p>
        </div>

        @if (count($this->sessions) > 0)
            <ul class="list-group list-group-flush">
                <!-- Other Browser Sessions -->
                @foreach ($this->sessions as $session)
                    <li class="list-group-item">
                        <div class="d-flex flex-row">
                            <!-- profile photo : lazy loaded -->
                            <span class="status status-danger">
                            @if ($session->agent->isDesktop())
                                <svg class="profile-image d-inline-block" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                    <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            @else
                                <svg class="profile-image d-inline-block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                                </svg>
                            @endif
                            </span>
                            <!-- profile photo end -->
                            <div class="ml-3">
                                <h4 class="d-block fw-700 text-dark">{{ $session->agent->platform() }} - {{ $session->agent->browser() }}</h4>
                                <p>
                                    @if ($session->is_current_device)
                                        <span class="text-green-500 font-semibold">{{ __('This device') }}</span>
                                    @else
                                        {{ __('Last active') }} {{ $session->last_active }}
                                    @endif
                                    <small> ip:{{ $session->ip_address }}</small>
                                </p>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
        <div class="card-body text-center">
            <x-jet-action-message class="ml-3" on="loggedOut">
                @lang('messages.done')
            </x-jet-action-message>
            <a href="#" data-toggle="modal" data-target="#exampleModal" wire:loading.attr="disabled" class="card-link">@lang('messages.logout_other_browser_sessions')</a>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="exampleModal" wire:model="confirmingLogout">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('messages.logout_other_browser_sessions')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>@lang('messages.msg_rowser_sessions')</p>
                    <div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
                        <input class="form-control" type="password" class="mt-1 block w-3/4" placeholder="{{ __('Password') }}"
                                    x-ref="password"
                                    wire:model.defer="password"
                                    wire:keydown.enter="logoutOtherBrowserSessions" />

                        <x-jet-input-error for="password" class="mt-2" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" wire:click="$toggle('confirmingLogout')">@lang('messages.nevermind')</button>
                    <button type="button" class="btn btn-primary" wire:click="logoutOtherBrowserSessions" data-dismiss="modal">@lang('messages.logout_other_browser_sessions')</button>
                </div>
            </div>
        </div>
    </div>
</div>
