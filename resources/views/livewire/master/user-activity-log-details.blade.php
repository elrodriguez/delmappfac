<div>
    <div class="row">
        <div class="col-6">
            <div class="card mb-g rounded-top">
                <div class="row no-gutters row-grid">
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center justify-content-center p-4">
                            <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}" style="width:130px;height: 130px;" class="rounded-circle shadow-2 img-thumbnail" alt="">
                            <h5 class="mb-0 fw-700 text-center mt-3">
                                {{ $this->user->name }}
                                <small class="text-muted mb-0">{{ $this->user->email }}</small>
                            </h5>
                        </div>
                        <div class="mt-2" x-show="photoPreview">
                            <span class="block rounded-full w-20 h-20"
                                x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card border m-auto m-lg-0 mb-g">
                <div class="card-body">
                    <h5 class="card-title">@lang('messages.browser_sessions')</h5>
                </div>

                @if (count($this->sessions) > 0)
                    <ul class="list-group list-group-flush">
                        <!-- Other Browser Sessions -->
                        @foreach ($this->sessions as $session)
                            <li class="list-group-item">
                                <div class="d-flex flex-row">
                                    <!-- profile photo : lazy loaded -->
                                    <span class="status status-danger">
                                    @if ($session->agent->is_desktop)
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
                                        <h4 class="d-block fw-700 text-dark">{{ $session->agent->platform }} - {{ $session->agent->browser }}</h4>
                                        <p>
                                            {{ __('Last active') }} {{ $session->last_active }}
                                            <small> ip:{{ $session->ip_address }}</small>
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.activity')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <div class="form-row">
                            <div class="col-md-4 mb-3" wire:ignore>
                                <label class="form-label">{{ __('messages.date_range') }}</label>
                                <input type="text" class="form-control" id="custom-range">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function setDatesEndStart(date_start,date_end){
            @this.set('date_start',date_start)
            @this.set('date_end',date_end)
        }
    </script>
</div>
