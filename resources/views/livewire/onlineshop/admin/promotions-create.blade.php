<div class="panel-container show">
    <div class="panel-content">
        <div class="row">
            <div class="col-6">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">{{ __('messages.shop_carousel_title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model.defer="title">
                        @error('title')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span></label>
                        <textarea class="form-control" wire:model.defer="description"></textarea>
                        @error('description')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">URL <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model.defer="url_action">
                        @error('url_action')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3" style="display:none">
                        <label class="form-label">{{ __('messages.price') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model.defer="total_price">
                        @error('total_price')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">{{ __('messages.state') }}</label>
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="customControlValidation1" wire:model.defer="state">
                            <label class="custom-control-label" for="customControlValidation1">{{ __('messages.active') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <div class="text-center">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}" width="400" height="225">
                            @else
                                <img src="{{ asset('theme/img/default.jpg') }}" width="400" height="225" >
                            @endif
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="form-label">{{ __('messages.image') }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="custom-file" wire:ignore>
                                <input wire:model="photo" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" accept="image/*">
                                <label class="custom-file-label" for="inputGroupFile01">Elija el archivo</label>
                            </div>
                        </div>
                        @error('photo') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('onlineshop_administration_promotions') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
        <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:loading.attr="disabled" wire:click="store"><i class="fal fa-check mr-1"></i>{{ __('messages.save') }}</button>
    </div>

    <script>
        window.addEventListener('response_promotion_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>