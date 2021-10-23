<div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="translateModalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="translateModalFormLabel">{{ __('messages.transfer_between_warehouses') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="simpleinput">{{ __('messages.product') }}</label>
                                <input type="text" class="form-control" value="{{ $this->product_description }}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="warehouse_id">{{ __('messages.origin_warehouse') }}</label>
                                <input type="text" class="form-control" value="{{ $this->warehouse_name }}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="destination_warehouse_id">{{ __('messages.destination_warehouse') }}</label>
                                <select wire:model.defer="destination_warehouse_id" class="custom-select form-control">
                                    <option value="">{{ __('messages.to_select') }}</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option {{ $warehouse->id == $warehouse_id?'disabled':'' }} value="{{ $warehouse->id }}">{{ $warehouse->description }}</option>
                                    @endforeach
                                </select>
                                @error('destination_warehouse_id')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4 mb-3">
                            <div class="form-group">
                                <label class="form-label" for="quantity">{{ __('messages.actual_quantity') }}</label>
                                <input wire:model.defer="quantity" type="text" id="quantity" class="form-control text-right" disabled>
                                @error('quantity')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="quantity_move">{{ __('messages.amount_to_transfer') }}</label>
                                <input wire:model.defer="quantity_move" type="text" id="quantity_move" class="form-control text-right">
                                @error('quantity_move')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="quantity">{{ __('messages.reason_for_transfer') }}</label>
                                <textarea class="form-control" rows="3" wire:model.defer="detail"></textarea>
                                @error('detail')
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
        function translateModalForm(prodruct_id,warehouse_id,stock){
            @this.set('product_id',prodruct_id);
            @this.set('warehouse_id',warehouse_id);
            @this.set('quantity',stock)
            $('#translateModalForm').modal('show');
        }
        window.addEventListener('response_translate_store', event => {
           swalAlert(event.detail.title,event.detail.message,event.detail.icon);
        });
        function swalAlert(title,msg,icon){
            $('#dt-basic-example').DataTable().draw();
            $('#translateModalForm').modal('hide');
            Swal.fire(title, msg, icon);
        }
    </script>
</div>
