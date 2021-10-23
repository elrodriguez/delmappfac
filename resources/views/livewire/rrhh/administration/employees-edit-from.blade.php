<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="update()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="validationCustom01">Tipo Doc. Identidad <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="identity_document_type_id" name="identity_document_type_id" required="" wire:model.defer="identity_document_type_id">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($identity_document_types as $identity_document_type)
                            <option value="{{ $identity_document_type->id }}">{{ $identity_document_type->description }}</option>
                        @endforeach
                    </select>
                    @error('identity_document_type_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="number">@lang('messages.number')<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model="number" id="number" name="number" required="">
                    @error('number')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="marital_state">@lang('messages.state')</label>
                    <select class="custom-select form-control" wire:model="marital_state" id="marital_state" name="marital_state" required="">
                        <option>@lang('messages.to_select')</option>
                        <option value="soltero">Soltero</option>
                        <option value="casado">Casado</option>
                        <option value="divorciado">Divorciado</option>
                        <option value="conviviente">Conviviente</option>
                    </select>
                    @error('marital_state')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="family_burden">@lang('messages.family_burden')</label>
                    <div class="frame-wrap">
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline1Radio" name="family_burden" value="SI" wire:model="family_burden">
							<label class="custom-control-label" for="defaultInline1Radio">{{ __('messages.yes') }}</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline2Radio" name="family_burden" value="NO" wire:model="family_burden">
							<label class="custom-control-label" for="defaultInline2Radio">{{ __('messages.no') }}</label>
						</div>
					</div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="name">{{ __('messages.name') }} <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" wire:model="name" id="name" name="name" required="">
                    @error('name')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="last_paternal">@lang('messages.last_paternal')<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model="last_paternal" id="last_paternal" name="last_paternal" required="">
                    @error('last_paternal')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="last_maternal">@lang('messages.last_maternal')<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" wire:model="last_maternal" id="last_maternal" name="last_maternal" required="">
                    @error('last_maternal')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="email">@lang('messages.email')</label>
                    <input type="text" class="form-control" wire:model="email" id="email" name="email">
                    @error('email')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="telephone">@lang('messages.telephone')</label>
                    <input type="text" class="form-control" wire:model="telephone" id="telephone" name="telephone">
                    @error('telephone')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="place_birth">@lang('messages.place_birth')</label>
                    <input type="text" class="form-control" wire:model="place_birth" id="place_birth" name="place_birth">
                    @error('place_birth')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3" wire:ignore>
                    <label class="form-label" for="country_id">@lang('messages.country_of_origin')</label>
                    <select class="custom-select form-control" id="country_id" name="country_id"  wire:model="country_id">
                        <option value>@lang('messages.to_select')</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->description }}</option>
                        @endforeach
                    </select>
                    @error('country_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="ubigeo">@lang('messages.ubigeo_of_origin') </label>
                    <div wire:ignore >
                        <select id="ubigeo" name="ubigeo" class="form-control" data="{{ $ubigeos }}" data-change="selectubigeo" data-default="{{ $ubigeo }}"></select>
                    </div>
                    @error('ubigeo')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="address">@lang('messages.address')</label>
                    <input type="text" class="form-control" id="address" name="address" required="" wire:model.defer="address">
                    @error('address')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3" wire:ignore>
                    <label class="form-label" for="sex">@lang('messages.sex')</label>
                    <select class="custom-select form-control" wire:model="sex" id="sex" name="sex" required="">
                        <option>@lang('messages.to_select')</option>
                        <option value="m">Masculino</option>
                        <option value="f">Femenino</option>
                    </select>
                    @error('sex')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="birth_date">@lang('messages.birth_date')<span class="text-danger">*</span></label>
                    <div class="input-group" wire:ignore>
                        <input required="" type="text" class="form-control" wire:model="birth_date" name="birth_date" id="datepicker-7" onchange="this.dispatchEvent(new InputEvent('input'))">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    @error('birth_date')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('rrhh_administration_employees') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="submit"><i class="fal fa-check mr-1"></i>@lang('messages.to_update')</button>
        </div>
    </form>
    <script>
        function selectubigeo(e){
            @this.set('ubigeo', e);
        }
        window.addEventListener('response_employees_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>

