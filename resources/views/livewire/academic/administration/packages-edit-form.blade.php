<div class="panel-container show">
    <form class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="update()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="description">@lang('messages.description') <span class="text-danger">*</span> </label>
                    <textarea rows="1" class="form-control" wire:model.defer="description"></textarea>
                    @error('description')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="state" wire:model="state" value="1">
                        <label class="custom-control-label" for="state">{{ __('messages.active') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('academic_packages') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.to_update')</button>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_packages_update', event => {
            swalAlertSuccess(event.detail.message);
        });
        function swalAlertSuccess(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "info");
        }
    </script>
</div>
