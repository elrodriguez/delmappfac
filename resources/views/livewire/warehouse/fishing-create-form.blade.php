<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="saveDocumentFishing()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="serie">@lang('messages.serie') <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="serie" name="serie" required="" wire:model.defer="serie">
                    @error('serie')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="numero">@lang('messages.number') <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="numero" name="numero" required="" wire:model.defer="numero">
                    @error('numero')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="f_issuance">@lang('messages.f_issuance') <span class="text-danger">*</span> </label>
                    <div class="input-group" wire:ignore>
                        <input required="" type="text" class="form-control" wire:model="f_issuance" name="f_issuance" id="datepicker-7" onchange="this.dispatchEvent(new InputEvent('input'))">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    @error('f_issuance')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="f_transfer">@lang('messages.f_transfer')</label>
                    <div class="input-group" wire:ignore>
                        <input required="" type="text" class="form-control" wire:model="f_transfer" name="f_transfer" id="datepicker-6" onchange="this.dispatchEvent(new InputEvent('input'))">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    @error('f_transfer')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3" wire:ignore>
                    <label class="form-label" for="select2-ajax">@lang('messages.customer') <span class="text-danger">*</span> </label>
                    <select data-placeholder="@lang('messages.select_state')" name="customer_id" class="js-data-example-ajax form-control" id="select2-ajax" onchange="selectCustomer(event)"></select>
                    @error('customer_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="modo_traslado">Modo de translado <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="modo_traslado" name="modo_traslado" required="" wire:model.defer="modo_traslado">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($transport_mode_types as $transport_mode_type)
                            <option value="{{ $transport_mode_type->id }}">{{ $transport_mode_type->description }}</option>
                        @endforeach
                    </select>
                    @error('modo_traslado')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="motivo_traslado">Motivo de translado <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="motivo_traslado" name="motivo_traslado" required="" wire:model.defer="motivo_traslado">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($transfer_reason_types as $transfer_reason_type)
                            <option value="{{ $transfer_reason_type->id }}">{{ $transfer_reason_type->description }}</option>
                        @endforeach
                    </select>
                    @error('motivo_traslado')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="descripcion_traslado">Descripción de motivo de traslado  </label>
                    <input type="text" class="form-control" id="descripcion_traslado" name="descripcion_traslado" required="" wire:model.defer="descripcion_traslado">
                    @error('descripcion_traslado')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="medida">@lang('messages.measure') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="medida" name="medida" required="" wire:model.defer="medida">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($unit_types as $unit_type)
                            <option value="{{ $unit_type->id }}">{{ $unit_type->description }}</option>
                        @endforeach
                    </select>
                    @error('medida')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="peso">Peso Total <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="peso" name="peso" required="" wire:model.defer="peso">
                    @error('peso')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label" for="paquetes">Num. de paquetes <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="paquetes" name="paquetes" required="" wire:model.defer="paquetes">
                    @error('paquetes')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="observaciones">Observaciones</label>
                    <input type="text" class="form-control" id="observaciones" name="observaciones" required="" wire:model.defer="observaciones">
                    @error('observaciones')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
            <h4>Datos envío</h4>
            <div class="form-group">
                <label class="form-label" for="pier_id">Muelle <span class="text-danger">*</span></label>
                <select class="custom-select form-control" id="pier_id" name="pier_id"  wire:model="pier_id">
                    <option value>@lang('messages.to_select')</option>
                    @foreach ($piers as $pier)
                        <option value="{{ $pier->id }}">{{ $pier->name }}</option>
                    @endforeach
                </select>
                @error('pier_id')
                <div class="invalid-feedback-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3" wire:ignore>
                    <label class="form-label" for="pais_desde">@lang('messages.country_of_origin') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="pais_desde" name="pais_desde"  wire:model="pais_desde">
                        <option value>@lang('messages.to_select')</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->description }}</option>
                        @endforeach
                    </select>
                    @error('pais_desde')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3" wire:ignore >
                    <label class="form-label" for="ubigeo_desde">@lang('messages.ubigeo_of_origin') <span class="text-danger">*</span> </label>
                    <select id="ubigeo_desde" name="ubigeo_desde" class="form-control" data="{{ $ubigeo }}" data-change="selectubigeodesde">
                    </select>
                    @error('ubigeo_desde')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label" for="direccion_desde">@lang('messages.address') <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="direccion_desde" name="direccion_desde" required="" wire:model.defer="direccion_desde">
                    @error('direccion_desde')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3" wire:ignore>
                    <label class="form-label" for="pais_llegada">@lang('messages.country_of_arrival') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="pais_llegada" name="pais_llegada" required="" wire:model="pais_llegada">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->description }}</option>
                        @endforeach
                    </select>
                    @error('pais_llegada')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3" wire:ignore>
                    <label class="form-label" for="ubigeo_llegada">@lang('messages.ubigeo_of_arrival') <span class="text-danger">*</span> </label>
                    <select id="ubigeo_llegada" name="ubigeo_llegada" class="form-control" data="{{ $ubigeo }}" data-change="selectubigeollega"></select>
                    @error('ubigeo_llegada')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label" for="direccion_llegada">@lang('messages.address') <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="direccion_llegada" name="direccion_llegada" required="" wire:model.defer="direccion_llegada">
                    @error('direccion_llegada')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
            <h4>Datos transportista</h4>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="transporte_tipo_documento">Tipo Doc. Identidad <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="transporte_tipo_documento" name="transporte_tipo_documento" required="" wire:model.defer="transporte_tipo_documento">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($identity_document_types as $identity_document_type)
                            <option value="{{ $identity_document_type->id }}">{{ $identity_document_type->description }}</option>
                        @endforeach
                    </select>
                    @error('transporte_tipo_documento')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="transporte_numero">@lang('messages.number') <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="transporte_numero" name="transporte_numero" required="" wire:model.defer="transporte_numero">
                    @error('transporte_numero')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="transporte_nombre_o_razon_social">Nombre y/o razón social <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="transporte_nombre_o_razon_social" name="transporte_nombre_o_razon_social" required="" wire:model.defer="transporte_nombre_o_razon_social">
                    @error('transporte_nombre_o_razon_social')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <h4>Datos conductor</h4>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="conductor_tipo_documento">Tipo Doc. Identidad <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="conductor_tipo_documento" name="conductor_tipo_documento" required="" wire:model.defer="conductor_tipo_documento">
                        <option>@lang('messages.to_select')</option>
                        @foreach ($identity_document_types as $identity_document_type)
                            <option value="{{ $identity_document_type->id }}">{{ $identity_document_type->description }}</option>
                        @endforeach
                    </select>
                    @error('conductor_tipo_documento')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="conductor_numero">@lang('messages.number') <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="conductor_numero" name="conductor_numero" required="" wire:model.defer="conductor_numero">
                    @error('conductor_numero')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="vehiculo_placa">Numero de placa del vehiculo <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" id="vehiculo_placa" name="vehiculo_placa" required="" wire:model.defer="vehiculo_placa">
                    @error('vehiculo_placa')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
            <div class="card">
                <div class="card-header pr-3 d-flex align-items-center flex-wrap">
                    <!-- we wrap header title inside a div tag with utility padding -->
                    <div class="card-title">@lang('messages.fish')</div>
                    <button type="button" class="btn btn-info ml-auto waves-effect waves-themed" onclick="openAddProductModal()">
                        @lang('messages.add')
                    </button>
                    <button type="button" class="btn btn-link ml-2 waves-effect waves-themed" onclick="openCreateProductModal()">
                        @lang('messages.new')
                    </button>
                </div>
                <div class="card-body p-0">
                    <table class="table">
                        <thead>
                        <tr >
                            <th scope="col" style="border-top: 0px;width:60px" class="text-center">#</th>
                            <th scope="col" style="border-top: 0px;width:100px">@lang('messages.name')</th>
                            <th scope="col" style="border-top: 0px">@lang('messages.description')</th>
                            <th scope="col" style="border-top: 0px;width:180px" class="text-center">@lang('messages.tons')</th>
                            <th scope="col" class="text-center" style="border-top: 0px;width:60px">@lang('messages.actions')</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($fishing_items as $key => $item)
                                <tr>
                                    <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td class="text-center"><input type="number" wire:model.defer="fishing_items.{{ $key }}.quantity" class="form-control text-right"></td>
                                    <td class="text-center">
                                        <button class="btn btn-default btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="removeItemFishing({{ $key }})" type="button">
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
            <a href="{{ route('warehouse_fishing') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.save')</button>
        </div>
    </form>
    <form class="modal" tabindex="-1" id="modal-product-create" wire:ignore.self novalidate wire:submit.prevent="newFishing()">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">@lang('messages.create_product_income')</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">@lang('messages.name')</label>
                            <input type="text" name="nombre" class="form-control" wire:model.defer="nombre">
                            @error('nombre')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-label">@lang('messages.tons')</label>
                            <input type="text" name="quantity" class="form-control" wire:model.defer="quantity">
                            @error('quantity')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">@lang('messages.description')</label>
                    <input type="text" name="descripcion" class="form-control" wire:model.defer="descripcion">
                    @error('descripcion')
                        <div>{{ $message }}</div>
                    @enderror
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
                        <ul class="list-group " style="background: #fff;">
                            @foreach ($items as $row)
                            <li class="list-group-item list-group-item-action" style="cursor: pointer" wire:click="addFishingBox('{{ $row->id }}','{{ $row->name }}','{{ $row->description }}')">
                                <i class="fal fa-check-circle width-2 fs-xl"></i>
                                <span data-filter-tags="reports file">{{ $row->name }} - {{ $row->description }}</span>
                            </li>
                            @endforeach
                        </ul>
                        <div class="mt-4">
                            {{ $items->links() }}
                        </div>
                    @endif
                </div>
            </div>
          </div>
        </div>
    </div>
</div>
<script>
    function openCreateProductModal(){
        $('#modal-product-create').modal('show')
    }
    function openAddProductModal(){
        $('#modal-product-add').modal('show')
    }
    function selectCustomer(e){
        @this.set('customer_id', e.target.value);
    }
    function selectubigeodesde(e){
        @this.set('ubigeo_desde', e);
    }
    function selectubigeollega(e){
        @this.set('ubigeo_llegada', e);
    }
    window.addEventListener('response_fishing_error_box_empty', event => {
        swalAlert(event.detail.message);
    });
    window.addEventListener('response_customer_id_error_empty', event => {
        swalAlert(event.detail.message);
    });
    window.addEventListener('response_success_fishing', event => {
        swalAlertSuccess(event.detail.message);
    });
    function swalAlert(msg){
        Swal.fire("{{ __('messages.error') }}", msg, "info");
    }
    function swalAlertSuccess(msg){
        Swal.fire("{{ __('messages.congratulations') }}", msg, "info");
    }
</script>
