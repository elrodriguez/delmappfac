<div>
    <div class="card m-auto border">
        <div class="card-header py-2">
            <div class="card-title">
                {{ __('messages.change_area') }}
            </div>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="select6-ajax"> {{ __('messages.area') }} <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" wire:change="loadGroup" wire:model.defer="sup_service_area_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area['id'] }}" {{ $area['id']== $ticket->sup_service_area_id?'disabled':'' }}>{{ $area['description'] }}</option>
                        @endforeach
                    </select>
                    @error('sup_service_area_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="select6-ajax"> {{ __('messages.group') }} <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" wire:model.defer="sup_service_area_group_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group['id'] }}" {{ $group['id']== $ticket->sup_service_area_group_id?'disabled':'' }}>{{ $group['description'] }}</option>
                        @endforeach
                    </select>
                    @error('sup_service_area_group_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="select6-ajax"> {{ __('messages.add_user') }} <span class="text-danger">*</span> </label>
                    <div wire:ignore>
                        <select data-placeholder="@lang('messages.select_state')" class="js-data-example-ajax form-control" id="select6-ajax"  onchange="selectUser(event)"></select>
                    </div>
                </div>
            </div> --}}
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="select6-ajax"> {{ __('messages.description') }} <span class="text-danger">*</span> </label>
                    <textarea wire:model.defer="description" class="form-control"></textarea>
                    @error('description')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex flex-row align-items-center">
            <button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary ml-auto btn-sm waves-effect waves-themed">
                {{ __('messages.save') }}
            </button>
        </div>
    </div>
    <script>
        function selectUser(e){
            @this.set('user_id_add',e.target.value);
        }
    </script>
</div>
