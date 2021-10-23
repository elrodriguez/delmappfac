<div>
    <div class="modal" tabindex="-1" id="modal-edit-parameters" wire:ignore.self >
        <form class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('messages.edit') @lang('messages.parameter')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="example-select">@lang('messages.type')</label>
                                <select wire:model="id_type" class="custom-select form-control" id="example-select" wire:change="changeType()">
                                    <option value="">{{ __('messages.to_select') }}</option>
                                    @foreach($types as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('id_type'))
                                    <div class="invalid-feedback-2">{{ $errors->first('id_type') }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="form-label" for="parameter">@lang('messages.parameter')</label>
                                <input disabled type="text" wire:model.defer="id_parameter" class="form-control" id="parameter">
                            </div>
                            @if($errors->has('id_parameter'))
                                <div class="invalid-feedback-2">{{ $errors->first('id_parameter') }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label" for="value_default_1">@lang('messages.value_default')</label>
                        @if($id_type == 8)
                            <textarea wire:model="value_default" class="form-control" id="value_default_1" maxlength="255"></textarea>
                            @if($errors->has('value_default'))
                                <div class="invalid-feedback-2">{{ $errors->first('value_default') }}</div>
                            @enderror
                        @else
                            <input type="text" wire:model="value_default" class="form-control" id="value_default_1">
                            @if($errors->has('value_default'))
                                <div class="invalid-feedback-2">{{ $errors->first('value_default') }}</div>
                            @enderror
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="description">@lang('messages.description')</label>
                        <textarea type="text" wire:model="description" class="form-control" id="description"></textarea>
                        @if($errors->has('description'))
                            <div class="invalid-feedback-2">{{ $errors->first('description') }}</div>
                        @enderror
                    </div>
                    @if($display)
                        <div class="form-group">
                            <label class="form-label" for="code_sql">@lang('messages.value_array_sql')</label>
                            <textarea type="text" wire:model="code_sql" class="form-control mb-2" id="code_sql"></textarea>
                            <code class="mb-2">1,hotel|2,Restaurante|3,Almacen</code><br>
                            <code>SELECT * FROM My_Table</code>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.cancel')</button>
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="update">@lang('messages.save')</button>
                </div>
            </div>
        </form>
    </div>
    <script defer>
        function openthis(parameter_id){
            @this.set('parameter_id',parameter_id);
            @this.loadParameter();
            $('#modal-edit-parameters').modal('show');
        }
        window.addEventListener('message-confir-modal-paramter-update', event => {
            $('#modal-edit-parameters').modal('hide');
            reloadList();
            swalAlert();
        });
        function swalAlert(){
            Swal.fire("{{ __('messages.congratulations') }}", "{{ __('messages.successfully_registered') }}", "success");
        }
    </script>
</div>
