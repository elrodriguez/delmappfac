<div>
    <div class="panel-container show">
        <div class="panel-content">
            <div class="row">
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">{{ __('messages.origin_warehouse') }}</label>
                        <select wire:model="warehouse_id" class="custom-select form-control">
                            <option value="">{{ __('messages.to_select') }}</option>
                            @foreach ($warehouses as $warehouse)
                                <option {{ $warehouse->id == $destination_warehouse_id?'disabled':'' }} value="{{ $warehouse->id }}">{{ $warehouse->description }}</option>
                            @endforeach
                        </select>
                        @error('warehouse_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">{{ __('messages.destination_warehouse') }}</label>
                        <select wire:model="destination_warehouse_id" class="custom-select form-control">
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
                <div class="col-12 mb-3">
                    <div class="form-group">
                        <label class="form-label" for="simpleinput">{{ __('messages.details') }}</label>
                        <textarea wire:model.defer="detail" rows="4" class="form-control"></textarea>
                        @error('detail')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-6 mb-3">
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
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                <thead class="bg-primary-600">
                    <tr>
                        <th>{{ __('messages.product') }}</th>
                        <th class="text-right">{{ __('messages.actual_quantity') }}</th>
                        <th class="text-right">{{ __('messages.amount_to_transfer') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($products)>0)
                        @foreach ($products as $key => $product)
                            <tr>
                                <td class="align-middle">{{ $product['description'] }}</td>
                                <td class="text-right align-middle">{{ $product['stock'] }}</td>
                                <td class="text-right align-middle">
                                    <input class="form-control text-right" type="text" wire:model.defer="products.{{ $key }}.quantity" name="products[{{ $key }}].quantity">
                                    @error('products.'.$key.'.quantity')
                                        <div class="invalid-feedback-2">{{ $message }}</div>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                    @else
                    <tr class="odd">
                        <td colspan="12" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('logistics_warehouse_inventory_transfers') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            <button wire:click="store" wire:loading.attr="disabled" class="btn btn-primary ml-auto waves-effect waves-themed" type="button"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
        </div>
    </div>
    <script>
        function selectProduct(id){
            @this.addProduct(id);
        }
        window.addEventListener('response_transfer_store', event => {
           swalAlert(event.detail.title,event.detail.message,event.detail.icon);
        });
        function swalAlert(title,msg,icon){
            Swal.fire(title, msg, icon);
        }
    </script>
</div>
