<div>
    <div class="panel-content">
        <form>
            <div class="form-group">
                <label class="form-label" for="name">{{ __('messages.name') }}</label>
                <input wire:model.defer="name" type="text" id="name" class="form-control">
                @error('name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="trade_name">{{ __('messages.trade_name') }}</label>
                <input wire:model.defer="trade_name" type="text" id="trade_name" class="form-control">
                @error('trade_name') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="logo">{{ __('messages.logo') }}</label>
                <input wire:model="logo" type="file" class="form-control" id="logo">
                <span class="help-block">{{ __('messages.700x300_resolutions_recommended') }}</span><br>
                @error('logo') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="management_types">{{ __('messages.management_types') }}</label>
                <select wire:model.defer="management_type_id" id="management_types" class="custom-select form-control">
                    @foreach ($management_types as $management_type)
                        <option value="{{ $management_type->id }}">{{ $management_type->description }}</option>
                    @endforeach
                </select>
                @error('management_type_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
        </form>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:click="store">
            <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
            <span>{{ __('messages.save') }}</span>
        </button>
    </div>
    <script defer>
        window.addEventListener('response_company_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
