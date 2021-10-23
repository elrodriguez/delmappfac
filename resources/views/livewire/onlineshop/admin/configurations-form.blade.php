<div>
    <div class="panel-content">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-label" for="fixed_phone">{{ __('messages.fixed_phone') }} <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" wire:model.defer="fixed_phone">
                @error('fixed_phone') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label" for="mobile_phone">{{ __('messages.mobile_phone') }} <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" wire:model.defer="mobile_phone">
                @error('mobile_phone') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3" wire:ignore >
                <label class="form-label" for="logo">{{ __('messages.logo') }} </label><br>
                <input type="file" wire:model.defer="logo" name="logo" accept="image/*"><br>
                @error('logo') <span class="error">{{ $message }}</span> @enderror
                <small id="passwordHelpBlock" class="form-text text-muted">Imagen de 224x51</small>
            </div>
        </div>
        @if($logo_view)
        <div class="form-row">
            <div class="col-md-12 mb-3" >
                <img src="{{ url('storage/'.$this->logo_view) }}" width="224" height="51" class="img-thumbnail">
            </div>
        </div>
        @endif
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-label" for="email">{{ __('messages.email') }} <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" wire:model.defer="email">
                @error('email') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-label" for="address">{{ __('messages.address') }} <span class="text-danger">*</span> </label>
                <input type="text" class="form-control" wire:model.defer="address">
                @error('address') <span class="error">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-12 mb-3">
                <label class="form-label" for="longitude">{{ __('messages.map_code') }} <span class="text-danger">*</span> </label>
                <textarea class="form-control" wire:model.defer="map" rows="4"></textarea>
            </div>
        </div>
        @if($this->map)
        <div class="form-row">
            {!! $this->map !!}
        </div>
        @endif
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:loading.attr="disabled" wire:click="save"><i class="fal fa-check mr-1"></i>{{ __('messages.save') }}</button>
    </div>
    <script>
        window.addEventListener('response_configurations_save', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>

