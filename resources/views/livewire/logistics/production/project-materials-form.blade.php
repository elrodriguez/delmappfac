<div class="panel-container show">
    <div class="panel-content">
        <div class="panel-tag"><code>PROYECTO</code> {{ $project_description }}</div>
        <form id="formProjects" class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.product') }} <span class="text-danger">*</span> </label>
                    <div wire:ignore>
                        <select data-additional="" data-placeholder="@lang('messages.select_state')" name="item_id" class="js-data-example-ajax form-control" id="item-id-ajax"  onchange="selectItem(event)"></select>
                    </div>
                    @error('item_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ __('messages.stage') }} <span class="text-danger">*</span> </label>
                    <div class="input-group">
                        <select class="custom-select form-control" id="stage_id" name="stage_id" wire:model.defer="stage_id">
                            <option value="">{{ __('messages.to_select') }}</option>
                            @foreach ($stages as $stage)
                            <option value="{{ $stage['id'] }}">{{ $stage['description'] }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary waves-effect waves-themed">{{ __('messages.add') }}</button>
                        </div>
                    </div>
                    @error('stage_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </form>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
        <div class="table-responsive">
            @php
                $colspan = 8;
            @endphp
            <table class="table table-bordered table-hover">
                <thead class="bg-info-900">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">{{ __('messages.state') }}</th>
                        <th>Imagen</th>
                        <th>{{ __('messages.description') }}</th>
                        <th>{{ __('messages.brand') }}</th>
                        <th>{{ __('messages.measure') }}</th>
                        @if($project['state'] == 'terminado')
                            @php
                                $colspan = 13;
                            @endphp
                            <th class="text-center">Obsoletos</th>
                            <th class="text-center">Perdidos</th>
                            <th class="text-center">Pendientes</th>
                            <th class="text-center">Sobrantes</th>
                            <th class="text-center">Observaciones</th>
                        @endif
                        <th class="text-center">{{ __('messages.quantity') }}</th>
                        <th class="text-center">{{ __('messages.price') }}</th>
                        <th class="text-center">{{ __('messages.total') }}</th>
                        <th style="width: 60px" class="text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                @php
                    $total = 0;
                @endphp
                <tbody>
                    @if(count($materials)>0)
                        @foreach ($materials as $key => $material)
                        <tr>
                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                            <td class="text-center align-middle">
                                @if($material['state'] == 0)
                                <span class="badge badge-danger">{{ __('messages.pending') }}</span>
                                @elseif($material['state'] == 1)
                                <span class="badge badge-warning">{{ __('messages.pedido') }}</span>
                                @elseif($material['state'] == 2)
                                <span class="badge badge-warning">aceptado</span>
     							@elseif($material['state'] == 3)
                                <span class="badge badge-warning">{{ __('messages.received') }}</span>
  								@elseif($material['state'] == 4)
                                <span class="badge badge-warning">rechazado</span>
                                @elseif($material['state'] == 5)
                                <span class="badge badge-warning">Proyecto terminado</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <img src="{{ $material['image_url'] }}" alt="{{ $material['description'] }}" style="width: 54px">
                            </td>
                            <td class="align-middle">{{ $material['description'] }}</td>
                            <td class="align-middle">{{ $material['name'] }}</td>
                            <td class="align-middle">{{ $material['measure'] }}</td>
                            @if($project['state'] == 'terminado')
                                <td class="text-right align-middle" wire:ignore>
                                    @if($material['module_type'] == 'GOO')
                                        <a href="#" class="xeditablequantity xed" id="o{{ $material['id'] }}" data-type="text" data-fun="ob" data-pk="{{ $material['id'] }}" data-title="Obsoletos">{{ $material['obsolete_quantity'] }}</a>
                                    @endif
                                </td>
                                <td class="text-right align-middle" wire:ignore>
                                    @if($material['module_type'] == 'GOO')
                                        <a href="#" class="xeditablequantity xed" id="l{{ $material['id'] }}" data-type="text" data-fun="lo" data-pk="{{ $material['id'] }}" data-title="Perdidos">{{ $material['lost_quantity'] }}</a>
                                    @endif
                                </td>
                                <td class="text-right align-middle" wire:ignore>
                                    @if($material['module_type'] == 'GOO')
                                        <a href="#" class="xeditablequantity xed" id="p{{ $material['id'] }}" data-type="text" data-fun="pe" data-pk="{{ $material['id'] }}" data-title="Pendientes">{{ $material['pending_quantity'] }}</a>
                                    @endif
                                </td>
                                <td class="text-right align-middle" wire:ignore>
                                    @if($material['module_type'] <> 'GOO')
                                        <a href="#" class="xeditablequantity xed" id="p{{ $material['id'] }}" data-type="text" data-fun="so" data-pk="{{ $material['id'] }}" data-title="Sobrantes">{{ $material['leftovers_quantity'] }}</a>
                                    @endif
                                </td>
                                <td class="align-middle" wire:ignore><a href="#" class="xeditablequantity xed" id="t{{ $material['id'] }}" data-type="textarea" data-fun="os" data-pk="{{ $material['id'] }}" data-title="Observaciones">{{ $material['observations'] }}</a></td>
                            @endif
                            @if ($material['state'] == 0)
                                <td class="text-right align-middle" wire:ignore><a href="#" class="xeditablequantity xed" id="q{{ $material['id'] }}" data-type="text" data-fun="qu" data-pk="{{ $material['id'] }}" data-title="{{ __('messages.quantity') }}">{{ $material['quantity'] }}</a></td>
                                {{-- <td class="text-right align-middle" wire:ignore><a href="#" class="xeditableprice xed" id="p{{ $material['id'] }}" data-type="text" data-pk="{{ $material['id'] }}" data-title="{{ __('messages.quantity') }}">{{ $material['unit_price'] }}</a></td> --}}
                                <td class="text-right align-middle" wire:ignore>{{ $material['unit_price'] }}</td>
                            @else
                                <td class="text-right align-middle" wire:ignore>{{ $material['quantity'] }}</td>
                                <td class="text-right align-middle" wire:ignore>{{ $material['unit_price'] }}</td>
                            @endif
                            <td class="text-right align-middle">{{ $material['expenses'] }}</td>
                            <td class="text-center align-middle" style="width: 60px">
                                @if($material['state'] == 0)
                                <button wire:click="deleteMateiral('{{ $material['id']}}')" type="button" class="btn btn-default btn-icon rounded-circle waves-effect waves-themed">
                                    <i class="fal fa-trash-alt"></i>
                                </button>
                                @else
                                <i class="fal fa-lock"></i>
                                @endif
                            </td>
                        </tr>
                        @php
                            $total = $total + $material['expenses'];
                        @endphp
                        @endforeach
                    @else
                    <tr class="odd">
                        <td colspan="12" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="{{ $colspan }}">{{ __('messages.total') }}</td>
                        <td class="text-right">{{ number_format($total, 2, '.', '') }}</td>
                        <td class="text-center">
                            @if ($project['state'] == 'terminado')
                                <button type="button" class="btn btn-success btn-block waves-effect waves-themed" wire:loading.attr="disabled" wire:click="returnMaterials">
                                    <span wire:loading wire:target="returnMaterials" wire:loading.class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span wire:loading.remove >{{ __('messages.return') }}</span>
                                </button>
                            @else
                                <button type="button" class="btn btn-primary btn-block waves-effect waves-themed" wire:loading.attr="disabled" wire:click="orderMaterials">
                                    <span wire:loading wire:target="orderMaterials" wire:loading.class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    <span wire:loading.remove >{{ __('messages.ask') }}</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('logistics_production_projects') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
    </div>

    <script>
        function materialsListReload(){
            @this.materialsList();
        }
        function selectItem(e){
            let xid = e.target.value;
            @this.set('item_id',xid);
        }
        window.addEventListener('response_projects_materials', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            $("#item-id-ajax").val("").trigger("change");
            xeditableLoad();
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>
