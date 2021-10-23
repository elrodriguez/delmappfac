<div>
    <div wire:ignore.self class="modal fade" id="modalMovementsForm" tabindex="-1" aria-labelledby="modalMovementsFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalMovementsFormLabel" wire:ignore>Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">{{ __('messages.product') }}</label>
                                <div wire:ignore>
                                    <input class="form-control basicAutoComplete" type="text"
                                        data-url="{{ route('logistics_warehouse_inventory_movements_product_search') }}"
                                        autocomplete="off"
                                    >
                                </div>
                                <div>
                                    @error('product_id')
                                        <div class="invalid-feedback-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="warehouse_id">{{ __('messages.warehouse') }}</label>
                                <select wire:model.defer="warehouse_id" class="custom-select form-control">
                                    <option value="">{{ __('messages.to_select') }}</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->description }}</option>
                                    @endforeach
                                </select>
                                @error('warehouse_id')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="transaction_id">{{ __('messages.reason') }}</label>
                                <select wire:model.defer="transaction_id" class="custom-select form-control">
                                    <option value="">{{ __('messages.to_select') }}</option>
                                    @foreach ($transactions as $transaction)
                                        <option value="{{ $transaction->id }}">{{ $transaction->description }}</option>
                                    @endforeach
                                </select>
                                @error('transaction_id')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="quantity">{{ __('messages.quantity') }}</label>
                                <input wire:model.defer="quantity" type="text" id="quantity" class="form-control text-right">
                                @error('quantity')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="store" wire:loading.attr="disabled">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModalMovements(t){
            @this.set('type',t);

            if(t == 'i'){
                $('#modalMovementsFormLabel').html('Ingreso de producto al almacén')
            }else{
                $('#modalMovementsFormLabel').html('Salida de producto del almacén')
            }
            $('#modalMovementsForm').modal('show');
        }
        function selectProduct(val){
            @this.set('product_id',val)
        }

        window.addEventListener('response_movements_store', event => {
           swalAlert(event.detail.title,event.detail.message,event.detail.icon);
        });
        
        function swalAlert(title,msg,icon){
            $('.basicAutoComplete').autoComplete('clear');
            $('#dt-basic-example').DataTable().draw();
            $('#modalMovementsForm').modal('hide');
            Swal.fire(title, msg, icon);
        }
    </script>
</div>
