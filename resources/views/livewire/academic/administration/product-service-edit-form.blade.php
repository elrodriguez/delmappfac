<div class="panel-container show">
    <form class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="update()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-2 mb-3" wire:ignore>
                    <label class="form-label">{{ __('messages.type') }} <span class="text-danger">*</span></label>
                    <select class="custom-select form-control" name="item_type_id" wire:model="item_type_id">
                        @foreach($item_types as $item_type)
                        <option value="{{ $item_type->id }}">{{ $item_type->description }}</option>
                        @endforeach
                    </select>
                    @error('item_type_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3" wire:ignore>
                    <label class="form-label">{{ __('messages.measure') }} <span class="text-danger">*</span></label>
                    <select class="custom-select form-control" name="unit_type_id" wire:model="unit_type_id">
                        @foreach($unit_types as $unit_type)
                        <option value="{{ $unit_type->id }}">{{ $unit_type->description }}</option>
                        @endforeach
                    </select>
                    @error('unit_type_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" name="description" wire:model.defer="description" required="">
                    @error('description')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.price') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="price" wire:model.defer="price" required="">
                    @error('price')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3" wire:ignore>
                    <label class="form-label">{{ __('messages.affectation_igv_types') }} <span class="text-danger">*</span></label>
                    <select class="custom-select form-control" name="affectation_igv_type_id" wire:model="affectation_igv_type_id">
                        @foreach($affectation_igv_types as $affectation_igv_type)
                        <option value="{{ $affectation_igv_type->id }}">{{ $affectation_igv_type->description }}</option>
                        @endforeach
                    </select>
                    @error('affectation_igv_type_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('academic_products_and_services') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.to_update')</button>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_product_service_update', event => {
            swalAlertSuccess(event.detail.message);
        });
        function swalAlertSuccess(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "info");
        }
    </script>
</div>
