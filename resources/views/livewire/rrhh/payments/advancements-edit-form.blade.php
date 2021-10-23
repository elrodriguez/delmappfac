<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="update()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="select2-ajax">
                        @lang('messages.employee') <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" value="{{ $person_name }}" disabled>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="concepts">
                        @lang('messages.concepts') <span class="text-danger">*</span>
                    </label>
                    <select class="custom-select form-control" id="concept_id" name="concept_id" wire:model.defer="concept_id" wire:change="changeAmount">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach($concepts as $concept)
                            <option value="{{ $concept->id }}">{{ $concept->description }}</option>
                        @endforeach
                    </select> 
                    @error('concept_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="amount">
                        @lang('messages.amount') <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="amount" name="amount" wire:model.defer="amount">
                    @error('amount')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="amount">
                        @lang('messages.observations') <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control" name="observations" id="observations" cols="5" rows="4" wire:model.defer="observations"></textarea>
                    @error('observations')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('rrhh_payments_advancements') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="submit" wire:loading.attr="disabled">
                <span wire:loading wire:target="update" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-1" role="status" aria-hidden="true"></span>
                <span >{{ __('messages.to_update') }}</span>
            </button>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_advancement', event => {
           swalAlert(event.detail.title,event.detail.message,event.detail.state);
        });
        function swalAlert(tit,msg,sta){
            Swal.fire(tit, msg, sta);
        }
    </script>
</div>
