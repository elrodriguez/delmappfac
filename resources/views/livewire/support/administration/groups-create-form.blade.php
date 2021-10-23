<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.area') }}</label>
                    <select class="custom-select form-control" wire:model.defer="area_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->description }}</option>
                        @endforeach
                    </select>
                    @error('area_id')
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
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="state" wire:model.defer="state">
                        <label class="custom-control-label" for="state">{{ __('messages.active') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('support_administration_groups') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
            <button wire:loading.attr="disabled" class="btn btn-primary ml-auto waves-effect waves-themed" type="submit">
                <i class="fal fa-check mr-1"></i>{{ __('messages.save') }}
            </button>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_supservice_area_group_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
