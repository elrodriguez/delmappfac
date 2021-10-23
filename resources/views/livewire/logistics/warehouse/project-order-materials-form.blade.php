<div class="panel-container show">
    <div class="panel-content">
        <div class="panel-tag"><code>PROYECTO</code> {{ $project_description }}</div>

    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="bg-info-900">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">{{ __('messages.image') }}</th>
                        <th class="text-center">{{ __('messages.state') }}</th>
                        <th>{{ __('messages.description') }}</th>
                        <th>{{ __('messages.brand') }}</th>
                        <th>{{ __('messages.measure') }}</th>
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
                                <img src="{{ asset('storage/items/'.$material['item_id'].'.jpg')}}" width=50px height=50px ></img>
                            </td>
                            <td class="text-center align-middle">
                                @if($material['state'] == 0)
                                <span class="badge badge-danger">{{ __('messages.pending') }}</span>
                                @elseif($material['state'] == 1)
                                <span class="badge badge-warning">{{ __('messages.pedido') }}</span>
                                @elseif($material['state'] == 2)
                                <span class="badge badge-success ">{{ __('messages.accepted') }}</span>
                                @elseif($material['state'] == 3)
                                <span class="badge badge-info ">{{ __('messages.received') }}</span>
                                @elseif($material['state'] == 4)
                                <span class="badge badge-dark ">{{ __('messages.rejected') }}</span>
                                @elseif($material['state'] == 5)
                                <span class="badge badge-warning">Proyecto terminado</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $material['description'] }}</td>
                            <td class="align-middle">{{ $material['name'] }}</td>
                            <td class="align-middle">{{ $material['measure'] }}</td>
                            <td class="text-right align-middle" wire:ignore>{{ $material['quantity'] }}</td>
                            <td class="text-right align-middle" wire:ignore>{{ $material['unit_price'] }}</td>
                            <td class="text-right align-middle">{{ $material['expenses'] }}</td>
                            <td class="text-center align-middle" style="width: 60px">
                                @if($material['state'] == 1)
                                <button wire:click="change_state_rejected('{{ $material['id'] }}')"   type="button" class="btn btn-dark btn-icon rounded-circle waves-effect waves-themed">
                                    <i class="fal fa-ban" alt="{{ __('messages.rejected') }}" data-original-title="{{ __('messages.rejected') }}" ></i>
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
                        <td class="text-right" colspan="7">{{ __('messages.total') }}</td>
                        <td class="text-right">{{ number_format($total, 2, '.', '') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-block waves-effect waves-themed" wire:loading.attr="disabled" wire:click="change_state_accepted">
                                <span wire:loading wire:target="change_state_accepted" wire:loading.class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span wire:loading.remove >{{ __('messages.accept') }}</span>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('logistics_warehouse_proyectos_orden') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
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
        function printImg(idimg){
            var img = `<img src="{{ asset('storage/items/`+idimg+`.jpg')}}" width=50px height=50px  ></img>`;
            return img;
        }
    </script>
</div>
