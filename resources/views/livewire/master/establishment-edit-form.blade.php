<div>
    <form class="needs-validation" novalidate wire:submit.prevent="update">
        <div class="panel-content">
            <div class="row">
                <div class="col-sm-4 mn-3">
                    <label for="inputname" class="form-label">@lang('messages.name') <span class="text-danger">*</span></label>
                    <input wire:model.defer="name" type="text" name="name" class="form-control" id="inputname">
                    @error('name')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="address" class="form-label">@lang('messages.address')</label>
                    <input wire:model.defer="address" type="text" name="address" class="form-control" id="address">
                    @error('address')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="phone" class="form-label">Urbanization</label>
                    <input wire:model.defer="urbanization" type="text" name="urbanization" class="form-control" id="phone">
                    @error('urbanization')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <label for="email" class="form-label">@lang('messages.email')</label>
                    <input wire:model.defer="email" type="text" name="email" class="form-control" id="phone">
                    @error('email')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="phone" class="form-label">@lang('messages.telephone')</label>
                    <input wire:model.defer="phone" type="text" name="phone" class="form-control" id="phone">
                    @error('phone')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-4 mb-3">
                    <label for="email" class="form-label">Pagina web</label>
                    <input wire:model.defer="web_page" type="text" name="web_page" class="form-control" id="web_page">
                    @error('web_page')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="row">
                <div class="col-md-4 mb-3" wire:ignore>
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
                <div class="col-md-4 mb-3" wire:ignore >
                    <label class="form-label" for="ubigeo">Ubigeo </label>
                    <select id="ubigeo" name="ubigeo" class="form-control" data="{{ $ubigeos }}" data-change="selectubigeo" data-default="{{ $ubigeo }}">
                    </select>
                    @error('ubigeo')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-3 mb-3">
                    <label class="form-label">@lang('messages.state')</label>
                    <div class="custom-control custom-checkbox">
                        <input wire:model.defer="state" type="checkbox" class="custom-control-input" id="defaultUnchecked">
                        <label class="custom-control-label" for="defaultUnchecked">@lang('messages.active')</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 ">
                    <label for="observation" class="form-label">@lang('messages.observation')</label>
                    <textarea wire:model.defer="observation" name="observation" class="form-control" id="observation"></textarea>
                    @error('observation')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('establishments') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            <button wire:loading.attr="disabled" class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.to_update')</button>
        </div>
    </form>
    <script defer>
        function selectubigeo(e){
            @this.set('ubigeo', e);
        }
        window.addEventListener('response_establishment_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
