<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.user') }} <span class="text-danger">*</span></label>
                    <div wire:ignore>
                    <select data-placeholder="@lang('messages.select_state')" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectUser(event)"></select>
                    </div>
                    @error('user_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.area') }} <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="area_id" name="area_id" wire:change="loadGroup" wire:model.defer="area_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->description }}</option>
                        @endforeach
                    </select>
                    @error('area_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.group') }} <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="group_id" name="group_id" required="" wire:model.defer="group_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->description }}</option>
                        @endforeach
                    </select>
                    @error('group_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div wire:ignore class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('support_administration_area_user') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button wire:loading.attr="disabled" class="btn btn-primary ml-auto waves-effect waves-themed" type="submit">
                <i class="fal fa-check mr-1"></i>{{ __('messages.save') }}
            </button>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_supservice_area_user_store', event => {
           clearSelect2();
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function selectUser(e){
            @this.set('user_id', e.target.value);
        }
        function clearSelect2(){
            $('#select2-ajax').val(null).trigger('change');
        }
    </script>
</div>
