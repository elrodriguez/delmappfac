<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="description" name="description" required="" wire:model.defer="description">
                    @error('description')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.percentage') }} <span class="text-danger">*</span> </label>
                    <input class="form-control" id="percentage" name="percentage" required="" wire:model.defer="percentage">
                    @error('percentage')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                <label class="form-label">{{ __('messages.operation') }} <span class="text-danger">*</span> </label><br>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline1Radio" name="operation" value="0" wire:model="operation" >
							<label class="custom-control-label" for="defaultInline1Radio">{{ __('messages.academic_discount') }}</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="defaultInline2Radio" name="operation" value="1" wire:model="operation">
							<label class="custom-control-label" for="defaultInline2Radio">{{ __('messages.increase') }}</label>
						</div>
                    </div>
                    @error('operation')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
               
                
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('rrhh_administration_concepts') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="submit"><i class="fal fa-check mr-1"></i>{{ __('messages.save') }}</button>
        </div>
    </form>
    <script>
        window.addEventListener('response_concepts_store', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
