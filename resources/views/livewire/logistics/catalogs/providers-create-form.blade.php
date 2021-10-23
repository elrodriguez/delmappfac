<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
        <div class="panel-content">

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
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="trade_name">{{ __('messages.trade_name') }} <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" wire:model="trade_name" id="trade_name" name="trade_name" required="">
                    @error('trade_name')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>

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
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="telephone">@lang('messages.telephone')</label>
                    <input type="text" class="form-control" wire:model="telephone" id="telephone" name="telephone">
                    @error('telephone')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
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
                <div class="col-md-3 mb-3" wire:ignore >
                    <label class="form-label" for="ubigeo">@lang('messages.ubigeo_of_origin') </label>
                    <select id="ubigeo" name="ubigeo" class="form-control" data="{{ $ubigeos }}" data-change="selectubigeo">
                    </select>
                    @error('ubigeo')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="address">@lang('messages.address')</label>
                    <input type="text" class="form-control" id="address" name="address" required="" wire:model.defer="address">
                    @error('address')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="address">@lang('messages.time_arrival')</label>
                    <input class="form-control" id="time_arrival" type="time" name="time_arrival" required="" wire:model.defer="time_arrival">
                    @error('time_arrival')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('logistics_catalogs_providers') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="store()"><i class="fal fa-check mr-1"></i>Guardar</button>
        </div>
    </form>
    <script>
        function selectubigeo(e){
            @this.set('ubigeo', e);
        }
        window.addEventListener('response_providers_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
