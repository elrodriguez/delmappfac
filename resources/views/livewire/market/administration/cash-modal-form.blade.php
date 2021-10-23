<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success waves-effect waves-themed" data-toggle="modal" data-target="#cashModalForm" wire:click="newCash">
        <i class="fal fa-lock-open-alt mr-1"></i> Aperturar Caja chica
    </button>

    <!-- Modal -->
    <div class="modal fade" id="cashModalForm" tabindex="-1" aria-labelledby="cashModalFormLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cashModalFormLabel">{{ $title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        @role('SuperAdmin|Administrator')
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.users') }}</label>
                            <select class="custom-select form-control" wire:model.defer="user_id">
                                <option value="">{{ __('messages.to_select') }}</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        @endrole
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Saldo inicial <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-right" wire:model.defer="initial">
                            @error('initial')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Referencia </label>
                            <input type="text" class="form-control" wire:model.defer="reference">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    @if($cash_id)
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="update">{{ __('messages.to_update') }}</button>
                    @else
                    <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="store">{{ __('messages.save') }}</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script defer>
        window.addEventListener('response_store_cash_event', event => {
            $('#cashModalForm').modal('hide');
           swalAlert(event.detail.title,event.detail.message,event.detail.icon);
        });
        function swalAlert(title,msg,icon){
            Swal.fire(title, msg, icon);
        }
    </script>
</div>
