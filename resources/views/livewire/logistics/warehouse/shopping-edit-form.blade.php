<div>
    <form class="needs-validation" wire:ignore.self novalidate wire:submit.prevent="updateDocument()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo comprobante <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" wire:model="document_type" name="document_type">
                        @foreach($document_types as $document_type)
                        <option value="{{ $document_type->id }}">{{ $document_type->description }}</option>
                        @endforeach
                    </select>
                    @error('document_type')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">@lang('messages.serie')<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="document_serie" wire:model.defer="document_serie">
                    @error('document_serie')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">@lang('messages.number') <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="document_number" wire:model.defer="document_number">
                    @error('document_number')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3" wire:ignore>
                    <label class="form-label">@lang('messages.f_issuance')<span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" class="form-control " name="f_issuance" wire:model="f_issuance" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-1">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!--div class="col-md-2 mb-3" >
                    <label class="form-label">@lang('messages.f_expiration')</label>
                    <div class="input-group">
                        <input type="text" class="form-control " name="f_expiration" wire:model="f_expiration" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-2">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                </div-->
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3" wire:ignore>
                    <label class="form-label" for="select2-ajax">
                        @lang('messages.supplier')
                    </label>
                    <select data-placeholder="@lang('messages.select_state')" name="supplier_id" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectSupplier(event)">
                        <option value="{{ $supplier_name }}" selected="selected"></option>
                    </select>
                    @error('supplier_id')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="card">
                <div class="card-header pr-3 d-flex align-items-center flex-wrap">
                    <!-- we wrap header title inside a div tag with utility padding -->
                    <div class="card-title">Productos</div>
                    <button type="button" class="btn btn-info ml-auto waves-effect waves-themed" onclick="openAddProductModal()">
                        @lang('messages.add')
                    </button>
                    <!--<button type="button" class="btn btn-link ml-2 waves-effect waves-themed" onclick="openCreateProductModal()">
                        @lang('messages.new')
                    </button>-->
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr >
                            <th scope="col" style="border-top: 0px;width:60px" class="text-center">#</th>
                            <th scope="col" style="border-top: 0px;width:50px" class="text-center">@lang('messages.image')</th>
                            <th scope="col" style="border-top: 0px;width:100px" class="text-center">@lang('messages.code')</th>
                            <th scope="col" style="border-top: 0px">@lang('messages.description')</th>
                            <th scope="col" style="border-top: 0px;width:180px" class="text-center">@lang('messages.quantity')</th>
                            <th scope="col" style="border-top: 0px;width:180px" class="text-center">@lang('messages.price')</th>
                            <th scope="col" class="text-center" style="border-top: 0px;width:60px">@lang('messages.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_items as $key => $item)
                                <tr>
                                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                    <td class="text-center"><img src="{{ asset('storage/items/'.$item['id'].'.jpg')}}" width=50px height=50px ></img></td>
                                    <td class="text-center"><span class="badge border border-dark text-dark">{{ $item['internal_id'] }}</span></td>
                                    <td>{{ $item['description'] }}</td>
                                    @if($item['new_item']==0)
                                    <td class="text-right">{{ $item['quantity'] }}</td>
                                    <td class="text-center">{{ $item['purchase_unit_price'] }}</td>
                                    @else
                                    <td class="text-center"><input type="text" wire:model.defer="purchase_items.{{ $key }}.quantity" class="form-control text-right"></td>
                                    <td class="text-center"><input type="text" wire:model.defer="purchase_items.{{ $key }}.purchase_unit_price" class="form-control text-right"></td>
                                    @endif
                                    <td class="text-center">
                                        <button class="btn btn-default btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="removeItemProduct({{ $key }})" type="button">
                                            <i class="fal fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('logistics_warehouse_shopping') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.to_update')</button>
        </div>
    </form>
    <form class="modal" tabindex="-1" id="modal-product-create" wire:ignore.self novalidate wire:submit.prevent="newProduct()">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">@lang('messages.create_product_income')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="codeAutomatic">@lang('messages.code')</label>
                    <div class="input-group">
                        <input id="internal_id" type="text" name="internal_id" class="form-control" wire:model.defer="internal_id" @if($checkmeout2) {{ 'disabled' }} @endif>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="checkmeout2" value="1" wire:model="checkmeout2">
                                    <label class="custom-control-label" for="checkmeout2">@lang('messages.automatic')</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="simpleinput">@lang('messages.description')</label>
                    <input type="text" id="simpleinput" name="description" class="form-control" wire:model.defer="description">
                    @error('description')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="validationCustom01">@lang('messages.stock') <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control" wire:model.defer="stock" name="stock">
                        @error('stock')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label" >@lang('messages.stock_min') <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model.defer="stock_min" name="stock_min">
                        @error('stock_min')
                            <div>{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('messages.cancel')</button>
              <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
            </div>
          </div>
        </div>
    </form>
    <div class="modal" tabindex="-1" id="modal-product-add" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">@lang('messages.add_product')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div id="js_default_list" class="js-list-filter">
                    <div class="input-group mb-g">
                        <input type="text" class="form-control shadow-inset-2" wire:model.defer="search_product">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary waves-effect waves-themed" wire:click="searchProduct()">
                                <i class="fal fa-search fs-xl"></i>
                            </button>
                        </div>
                    </div>

                    @if($items)
                        <ul class="list-group">
                            @foreach ($items as $row)
                            <li class="list-group-item list-group-item-action" style="cursor: pointer" wire:click="addProductBox('{{ $row->id }}','{{ $row->internal_id }}','{{ $row->name }} - {{ $row->description }}','{{ $row->purchase_unit_price }}')">
                                <i class="fal fa-check-circle width-2 fs-xl"></i>
                                <span><img src="{{ asset('storage/items/'.$row->id.'.jpg')}}" width=50px height=50px ></img></span>
                                <span class="badge border border-dark text-dark">{{ $row->internal_id }} </span>
                                <span>{{ $row->name }} - {{ $row->description }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mt-4">

                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
            </div>
          </div>
        </div>
    </div>
    <script defer>

        function openCreateProductModal(){
            $('#modal-product-create').modal('show')
        }
        function openAddProductModal(){
            $('#modal-product-add').modal('show')
        }
        function selectSupplier(e){
            @this.set('supplier_id', e.target.value);
        }
        window.addEventListener('response_purchase_error_box_empty', event => {
           swalAlert(event.detail.message);
        });
        window.addEventListener('response_supplier_id_error_empty', event => {
           swalAlert(event.detail.message);
        });
        window.addEventListener('response_success_purchase', event => {
            swalAlertSuccess(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.error') }}", msg, "info");
        }
        function swalAlertSuccess(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "info");
        }
    </script>
</div>
