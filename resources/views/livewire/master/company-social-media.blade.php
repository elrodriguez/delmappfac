<div>
    <div class="panel-content">
        <div class="form-row">
            <div class="col-md-6 mb-3" wire:ignore.self>
                <label class="form-label" for="social_media_name_id">{{ __('messages.name') }}</label>
                <select wire:model.defer="social_media_name_id" type="text" id="social_media_name_id" class="custom-select form-control">
                    <option value="">{{ __('messages.to_select') }}</option>
                    @foreach ($social_media_names as $social_media_name)
                        <option value="{{ $social_media_name }}">{{ $social_media_name }}</option>
                    @endforeach
                </select>
                @error('social_media_name_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="cp5b">Color</label>
                <div id="cp5b" class="input-group colorpicker-element" title="Using format option" data-colorpicker-id="7">
                    <input type="text" class="form-control input-lg" value="#3b5998">
                    <span class="input-group-append">
                    <span class="input-group-text colorpicker-input-addon" data-original-title="" title="" tabindex="0"><i style="background: rgb(91, 54, 54);"></i></span>
                    </span>
                </div>
                @error('background_color') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-label" for="url_event">URL</label>
                <input wire:model.defer="url_event" type="text" class="form-control input-lg">
                @error('url_event') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-label" for="logo">Icono</label>
                <input wire:model.defer="logo" type="text" class="form-control">
                <span class="help-block">ejemplo: <code>fab fa-facebook</code></span><br>
                @error('logo') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.type') }}</label>
                <div class="custom-control custom-switch">
                    <input wire:model="state" value="1" type="checkbox" class="custom-control-input" id="state">
                    <label class="custom-control-label" for="state">{{ __('messages.public') }}</label>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.add_credentials') }}</label>
                <div class="custom-control custom-switch">
                    <input wire:model="credentials" value="1" type="checkbox" class="custom-control-input" id="credentials">
                    <label class="custom-control-label" for="credentials">{{ __('messages.yes') }}</label>
                </div>
            </div>
        </div>
        @if($credentials)
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">{{ __('messages.username') }}</label>
                    <input wire:model.defer="username" type="text" class="form-control">
                    @error('username') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">{{ __('messages.password') }}</label>
                    <input wire:model.defer="user_password" type="text" class="form-control">
                    @error('user_password') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">TOKEN</label>
                    <input wire:model.defer="access_token" type="text" class="form-control">
                    @error('access_token') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">KEY ID</label>
                    <input wire:model.defer="access_key_id" type="text" class="form-control">
                    @error('access_key_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">SECRET KEY ID</label>
                    <input wire:model.defer="access_secret_key_id" type="text" class="form-control">
                    @error('access_secret_key_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">PORT</label>
                    <input wire:model.defer="access_port" type="text" class="form-control">
                    @error('access_port') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">HOST</label>
                    <input wire:model.defer="access_host" type="text" class="form-control">
                    @error('access_host') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">API</label>
                    <input wire:model.defer="access_api" type="text" class="form-control">
                    @error('access_api') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        @if($new)
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="store">
                <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                <span>{{ __('messages.save') }}</span>
            </button>
        @else
            <button type="button" class="btn btn-secondary ml-auto waves-effect waves-themed mr-2" wire:click="clearForm">{{ __('messages.cancel') }}</button>
            <button class="btn btn-primary waves-effect waves-themed" type="button" wire:click="update">
                <span wire:loading wire:target="update" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                <span>{{ __('messages.to_update') }}</span>
            </button>
        @endif
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
        <div class="accordion" id="js_demo_accordion-5">
            @foreach ($social_medias as $social_media)
            <div class="card">
                <div class="card-header">
                    <a href="javascript:void(0);" class="card-title collapsed" data-toggle="collapse" data-target="#js_demo_accordion_{{ $social_media->id }}" aria-expanded="false">
                        <i class="{{ $social_media->logo }} width-2 fs-xl"></i>
                        {{ $social_media->social_media_name }}
                        <span class="ml-auto">
                            <span class="collapsed-reveal">
                                <i class="fal fa-minus fs-xl"></i>
                            </span>
                            <span class="collapsed-hidden">
                                <i class="fal fa-plus fs-xl"></i>
                            </span>
                        </span>
                    </a>
                </div>
                <div id="js_demo_accordion_{{ $social_media->id }}" class="collapse" data-parent="#js_demo_accordion-5" style="">
                    <div class="card-body">
                        <dl class="row">
							<dt class="col-sm-3">URL WEB</dt>
							<dd class="col-sm-9">{{ $social_media->url_event }}</dd>
                            <dt class="col-sm-3">Icono</dt>
							<dd class="col-sm-9">{{ $social_media->logo }}</dd>
                            <dt class="col-sm-3">Color</dt>
							<dd class="col-sm-9">{{ $social_media->background_color }}</dd>
                            <dt class="col-sm-3">{{ __('messages.state') }}</dt>
							<dd class="col-sm-9">
                                @if($social_media->state)
                                <span class="text-primary">{{ __('messages.active') }}</span>
                                @else
                                <span class="text-danger">{{ __('messages.inactive') }}</span>
                                @endif
                            </dd>
                        </dl>
                        <p class="text-center">
							Credenciales
						</p>
                        <dl class="row" style="border: 1px dashed;">
                            <dt class="col-sm-3">USER</dt>
							<dd class="col-sm-9">{{ $social_media->username }}</dd>
                            <dt class="col-sm-3">PASSWORD</dt>
							<dd class="col-sm-9">{{ $social_media->user_password }}</dd>
                            <dt class="col-sm-3">TOKEN</dt>
							<dd class="col-sm-9">{{ $social_media->access_token }}</dd>
                            <dt class="col-sm-3">KEY</dt>
							<dd class="col-sm-9">{{ $social_media->access_key_id }}</dd>
                            <dt class="col-sm-3">SECRET KEY</dt>
							<dd class="col-sm-9">{{ $social_media->access_secret_key_id }}</dd>
                            <dt class="col-sm-3">PORT</dt>
							<dd class="col-sm-9">{{ $social_media->access_port }}</dd>
                            <dt class="col-sm-3">HOST</dt>
							<dd class="col-sm-9">{{ $social_media->access_host }}</dd>
                            <dt class="col-sm-3">URL API</dt>
							<dd class="col-sm-9">{{ $social_media->access_api }}</dd>
                        </dl>
                        <button wire:click="edit({{ $social_media->id }})" class="btn btn-link" type="button">{{ __('messages.edit') }}</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <script defer>
        window.addEventListener('response_company_social_media_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function changeColor(color){
            @this.set('background_color',color)
        }
    </script>
</div>
