<div class="panel-container show">
    <div class="panel-content">
        <form>
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label" for="document_type">{{ __('messages.document_type') }}</label>
                        <select class="custom-select form-control" id="document_type" wire:model="document_type" name="document_type">
                            <option value="">{{ __('messages.to_select') }}</option>
                            @foreach($document_types as $document_type)
                            <option value="{{ $document_type->id }}">{{ $document_type->description }}</option>
                            @endforeach
                        </select>
                        @error('document_type')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label" for="serie_id">{{ __('messages.serie') }}</label>
                        <input name="serie_id" wire:model.defer="serie_id" type="text" id="serie_id" class="form-control">
                        @error('serie_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label class="form-label" for="correlative">{{ __('messages.correlative') }}</label>
                        <input name="correlative" wire:model.defer="correlative" type="text" id="correlative" class="form-control">
                        @error('correlative')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">{{ __('messages.state') }}</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultInline1" value="1" wire:model="state">
                            <label class="custom-control-label" for="defaultInline1">{{ __('messages.active') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('establishments_series',['id'=>$establisment_id]) }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
        <button class="btn btn-primary ml-auto waves-effect waves-themed" wire:loading.attr="disabled" type="button" wire:click="store">
            <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
            <span>{{ __('messages.to_update') }}</span>
        </button>
    </div>
    <script>
        window.addEventListener('response_series_update', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
