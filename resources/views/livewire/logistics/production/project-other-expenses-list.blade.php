<div>
    <div class="panel-container show">
        <div class="panel-content">
            <div class="panel-tag"><code>PROYECTO</code> {{ $project_description }}</div>
        </div>
        <div class="panel-content d-flex flex-row align-items-center">
            <a href="{{ route('logistics_production_projects_other_expenses_create',$project_id) }}" class="btn btn-success ml-auto waves-effect waves-themed">{{ __('messages.new') }}</a>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="bg-info-900">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{ __('messages.state') }}</th>
                            <th>{{ __('messages.f_issuance') }}</th>
                            <th>{{ __('messages.number') }}</th>
                            <th>{{ __('messages.provider') }}</th>
                            <th>{{ __('messages.type') }}</th>
                            <th>{{ __('messages.reason') }}</th>
                            <th class="text-center">{{ __('messages.total') }}</th>
                            <th style="width: 60px" class="text-center">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    @php
                        $total = 0;
                    @endphp
                    <tbody>
                        @if(count($otherexpenses)>0)
                            @foreach ($otherexpenses as $key => $otherexpense)
                            <tr>
                                <td class="text-center align-middle">{{ $key + 1 }}</td>
                                <td class="text-center align-middle">
                                    @if($otherexpense->state == 0)
                                        <span class="badge badge-danger">anulado</span>
                                    @elseif($otherexpense->state == 1)
                                        <span class="badge badge-warning">registrado</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">{{ \Carbon\Carbon::parse($otherexpense->date_of_issue)->format('d/m/Y') }}</td>
                                <td class="align-middle">{{ $otherexpense->number }}</td>
                                <td class="align-middle">{{ json_decode($otherexpense->supplier)->trade_name }}</td>
                                <td class="align-middle">{{ $otherexpense->type_description }}</td>
                                <td class="align-middle">{{ $otherexpense->reason_description }}</td>
                                <td class="align-middle text-right">{{ $otherexpense->total }}</td>
                                <td class="align-middle text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="btn btn-info rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fal fa-cogs"></i>
                                        </a>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="javascript:void(0)" wire:click="openModalExpenses('{{ $otherexpense->id }}','items','{{ $otherexpense->total }}')"><i class="fal fa-search mr-1"></i>Ver detalles</a>
                                            <a class="dropdown-item" href="javascript:void(0)" wire:click="openModalExpenses('{{ $otherexpense->id }}','payments','{{ $otherexpense->total }}')"><i class="fal fa-search-dollar mr-1"></i>Ver pagos</a>
                                            @if($otherexpense->state == 1)
                                                <a class="dropdown-item text-danger" href="javascript:void(0)" wire:click="expensesCancel('{{ $otherexpense->id }}')"><i class="fal fa-times mr-1"></i>{{ __('messages.ticket_cancel') }}</a>
                                            @else
                                                <a class="dropdown-item text-primary" href="javascript:void(0)" wire:click="expensesRestore('{{ $otherexpense->id }}')"><i class="fal fa-check mr-1"></i>Restaurar</a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @if($otherexpense->state == 1)
                                @php
                                    $total = $total + $otherexpense->total;
                                @endphp
                            @endif

                            @endforeach
                        @else
                        <tr class="odd">
                            <td colspan="8" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                        </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="7">{{ __('messages.total') }}</td>
                            <td class="text-right">{{ number_format($total, 2, '.', '') }}</td>
                            <td class="text-center"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('logistics_production_projects') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
        </div>
    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalDetailsExpenses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $modalTitle }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        @if(count($items)>0)
                            <table class="table table-bordered table-hover">
                                <thead class="bg-info-900">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">{{ __('messages.description') }}</th>
                                        <th class="text-center">{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $k => $item)
                                        <tr>
                                            <td class="text-center">{{ $k + 1 }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td class="text-right">{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right"><b>Total</b></td>
                                        <td class="text-right">{{ $total_details }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        @elseif(count($payments)>0)
                            <table class="table table-bordered table-hover">
                                <thead class="bg-info-900">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Fecha de pago</th>
                                        <th>Metodo</th>
                                        <th>Salio</th>
                                        <th>Referencia</th>
                                        <th class="text-center">{{ __('messages.amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $k => $item)
                                        <tr>
                                            <td class="text-center">{{ $k + 1 }}</td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($item->date_of_payment)->format('d/m/Y') }}</td>
                                            <td>{{ $item->card_brand_description }}{{ $item->description }}</td>
                                            <td>{{ $item->bank_account_description }}</td>
                                            <td>{{ $item->reference }}</td>
                                            <td class="text-right">{{ $item->payment }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-right"><b>Total</b></td>
                                        <td class="text-right">{{ $total_details }}</td>
                                    </tr>
                                </tfoot>
                            </table>
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
        window.addEventListener('response_modal_expenses_details', event => {
            openModalHtml();
        });
        function openModalHtml(){
            $('#exampleModalDetailsExpenses').modal('show');
        }
    </script>
</div>
