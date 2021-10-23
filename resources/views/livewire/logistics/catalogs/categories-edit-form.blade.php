<div class="panel-container show">
    <div class="panel-content">
        <div class="form-row">
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.category') }} </label>
                <select wire:model.defer="item_category_id" class="custom-select form-control">
                    <option value="">Ninguno</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('name')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ __('messages.name') }} <span class="text-danger">*</span> </label>
                <input class="form-control" id="name" name="name" required="" wire:model.defer="name">
                @error('name')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-sm-4 mb-3">
                <label class="form-label">@lang('messages.state')</label>
                <div class="custom-control custom-checkbox">
                    <input wire:model.defer="state" type="checkbox" class="custom-control-input" id="defaultUnchecked">
                    <label class="custom-control-label" for="defaultUnchecked">@lang('messages.active')</label>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('logistics_catalogs_categories') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
        <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:loading.attr="disabled" wire:click="update"><i class="fal fa-check mr-1"></i>{{ __('messages.to_update') }}</button>
    </div>

    <script>
        window.addEventListener('response_categories_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
