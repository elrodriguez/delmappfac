<div>
    <div class="row">
        <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
            <div class="ml-auto">
                @livewire('market.administration.cash-modal-form')
            </div>
        </div>
    </div>
    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
        <thead class="bg-primary-600">
            <tr>
                <th class="text-center align-middle">{{ __('messages.actions') }}</th>
                <th class="text-center align-middle">Referencia</th>
                <th class="align-middle">Vendedor</th>
                <th class="text-center align-middle">Apertura</th>
                <th class="text-center align-middle">Cierre</th>
                <th class="text-center align-middle">Saldo inicial</th>
                <th class="text-center align-middle">Saldo final</th>
                <th class="text-center align-middle">{{ __('messages.state') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($collection as $item)
                <tr>
                    <td class="text-center align-middle">
                        <div class="dropdown">
                            <a href="javascript:void(0)" class="btn btn-info rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fal fa-cogs"></i>
                            </a>
                            <div class="dropdown-menu" style="">
                                @if ($item->state)
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#cashModalForm" wire:click="showEdit('{{ $item->id }}')" ><i class="fal fa-edit mr-1"></i>{{ __('messages.edit') }}</a>
                                    <a class="dropdown-item text-danger" href="javascript:closeCash('{{ route('market_administration_cash_close',$item->id) }}')"><i class="fal fa-lock-alt mr-1"></i>Cerrar Caja</a>
                                    <div class="dropdown-divider"></div>
                                @endif
                                <a class="dropdown-item" href="{{ route('market_administration_cash_report_pdf',$item->id) }}" target="_blank"><i class="fal fa-file-pdf mr-1"></i>Reporte Caja PDF</a>
                                <a class="dropdown-item" href="{{ route('market_administration_cash_report_products_pdf',$item->id) }}" target="_blank"><i class="fal fa-file-pdf mr-1"></i>Reporte Productos PDF</a>
                                <a class="dropdown-item" href="{{ route('market_administration_cash_reportproducts_excel_pdf',$item->id) }}"><i class="fal fa-file-excel mr-1"></i>Reporte Productos EXCEL</a>
                            </div>
                        </div>
                    </td>
                    <td class="text-center align-middle">{{ $item->reference_number }}</td>
                    <td class="align-middle">{{ $item->name }}</td>
                    <td class="text-center align-middle">{{ \Carbon\Carbon::parse($item->date_opening)->format('d/m/Y') }}<br><code>{{ $item->time_opening }}</code></td>
                    <td class="text-center align-middle">{{ \Carbon\Carbon::parse($item->date_closed)->format('d/m/Y') }}<br><code>{{ $item->time_closed }}</code></td>
                    <td class="text-right align-middle">{{ $item->beginning_balance }}</td>
                    <td class="text-right align-middle">{{ $item->final_balance }}</td>
                    <td class="text-center align-middle">
                        @if ($item->state)
                            <span class="badge badge-info">Aperturada</span>
                        @else
                            <span class="badge badge-success">Cerrada</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        @if($collection->links())
        <tfoot>
            <tr>
                <td colspan="10">
                    <div class="row">
                        <div class="col-md-12 d-flex flex-row align-items-center">
                            <div class="ml-auto">{{ $collection->links() }}</div>
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
    <script defer>
        function closeCash(close_url){
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Cerrar la caja",
                cancelButtonText: "Cancelar"
            }).then(function(result)
            {
                if (result.value)
                {
                    $.get(close_url, function(data) {
                        if(data.success == true){
                            @this.listCash();
                            Swal.fire("¡Exito!", "Caja cerrada", "success");
                        }
                    }).fail(function( data ) {
                        Swal.fire("¡Error!","{{ __('messages.msg_access_permission') }}", "error");
                    });

                }
            });
        }
    </script>
</div>
