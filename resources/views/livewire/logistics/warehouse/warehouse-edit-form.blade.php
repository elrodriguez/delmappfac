<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="update">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.establishment') }} <span class="text-danger">*</span> </label>
                    <select wire:model.defer="establishment_id" disabled class="custom-select form-control">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($establishments as $establishment)
                            <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                        @endforeach
                    </select>
                    @error('establishment_id')
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
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('logistics_warehouse_inventory_locations') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button type="submit" class="btn btn-primary ml-auto waves-effect waves-themed" wire:loading.attr="disabled" >
                <span wire:loading wire:target="update" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                <span>{{ __('messages.to_update') }}</span>
            </button>
        </div>
    </form>
    <script>
        window.addEventListener('response_warehouse_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
