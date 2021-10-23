<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="update()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.type') }} <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="item_type_id" name="item_type_id" required="" wire:model.defer="item_type_id">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($item_types as $item_type)
                            <option value="{{ $item_type->id }}">{{ $item_type->description }}</option>
                        @endforeach
                    </select>
                    @error('unit_type_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.code') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="internal_id" name="internal_id" required="" wire:model.defer="internal_id">
                    @error('internal_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="description" name="description" required="" wire:model.defer="description">
                    @error('description')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.measure') }} <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="unit_type_id" name="unit_type_id" required="" wire:model.defer="unit_type_id">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($unit_types as $unit_type)
                            <option value="{{ $unit_type->id }}">{{ $unit_type->description }}</option>
                        @endforeach
                    </select>
                    @error('unit_type_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.category') }} <span class="text-danger">*</span> </label>
                    <div wire:ignore>
                        <select class="custom-select form-control" wire:model.defer="category_id">
                            <option>@lang('messages.to_select')</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('category_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.brand') }} <span class="text-danger">*</span> </label>
                    <div wire:ignore>
                        <select class="custom-select form-control" wire:model.defer="brand_id">
                            <option>@lang('messages.to_select')</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('brand_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.stock_min') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="stock_min" name="stock_min" required="" wire:model.defer="stock_min">
                    @error('stock_min')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.initial_stock') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="stock" name="stock" disabled wire:model.defer="stock">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.price_purchase') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="price_purchase" name="price_purchase" required="" wire:model.defer="price_purchase">
                    @error('price_purchase')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.price_sale') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="price_sale" name="price_sale" required="" wire:model.defer="price_sale">
                    @error('price_sale')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.upload_image_file') }} <span class="text-danger">*</span> </label>
                    <label class="btn btn-primary btn-upload waves-effect waves-themed" for="file_image" title="{{ __('messages.upload_image_file') }}">
                        <input type="file" class="sr-only" id="file_image" wire:model="file_image" name="file_image" accept="image/x-png,image/gif,image/jpeg">
                        <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="" data-original-title="Import image">
                        <span class="fal fa-image mr-1"></span> Upload</span>
                    </label>
                    @error('file_image')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12 mb-3">
                    <div class="frame-wrap">
                        <div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline1Radio" name="module_type" value="GOO" wire:model="module_type" >
							<label class="custom-control-label" for="defaultInline1Radio">Activo fijo</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline1Radio" name="module_type" value="PUC" wire:model="module_type" >
							<label class="custom-control-label" for="defaultInline1Radio">Solo se compra</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline2Radio" name="module_type" value="SAL" wire:model="module_type">
							<label class="custom-control-label" for="defaultInline2Radio">Solo se vende</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline4Radio" name="module_type" value="PAL" wire:model="module_type">
							<label class="custom-control-label" for="defaultInline4Radio">Se compra y vende</label>
						</div>
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="icbper" wire:model="has_icbper">
                            <label class="custom-control-label" for="icbper">Impuesto a la bolsa plásticas</label>
                        </div>
                    </div>
                    {{-- @error('module_type')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror --}}
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('logistics_catalogs_products') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="submit"><i class="fal fa-check mr-1"></i>{{ __('messages.to_update') }}</button>
        </div>
    </form>
    <script>

        window.addEventListener('response_products_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
