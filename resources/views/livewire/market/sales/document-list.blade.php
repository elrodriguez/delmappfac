<div>
    <button class="btn btn-primary waves-effect waves-themed mb-3" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
        {{ __('messages.search_filters') }}
    </button>
    <div class="collapse mb-3" id="collapseExample" style="">
        <div class="card card-body">
            <div class="form-row">
                <div class="col-md-3 mb-3" wire:ignore>
                    <label class="form-label">{{ __('messages.date_range') }}</label>
                    <input type="text" class="form-control" id="custom-range">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.voucher_type') }}</label>
                    <select class="custom-select form-control" wire:model.defer="document_type_id">
                        <option value="">{{ __('messages.all') }}</option>
                        @foreach ($document_types as $document_type)
                        <option value="{{ $document_type->id }}">{{ $document_type->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.serie') }}</label>
                    <input type="text" class="form-control" wire:model.defer="serie_id">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.number') }}</label>
                    <input type="text" class="form-control" wire:model.defer="number">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">{{ __('messages.state') }}</label>
                    <select class="custom-select form-control" wire:model.defer="state_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @role('SuperAdmin|Administrator')
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ __('messages.users') }}</label>
                    <select class="custom-select form-control" wire:model.defer="user_id">
                        <option value="">{{ __('messages.to_select') }}</option>
                        @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endrole
            <div class="form-row">
                <div class="col-md-12 d-flex flex-row align-items-center">
                    <button type="button" class="btn btn-primary ml-auto waves-effect waves-themed" wire:loading.attr="disabled" wire:click="searchDocument">
                        <span wire:loading wire:target="searchDocument" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-search" class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                        <span>{{ __('messages.search') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
        <thead class="bg-primary-600">
            <tr>
                <th class="align-middle">{{ __('messages.actions') }}</th>
                <th class="text-center align-middle">{{ __('messages.broadcast_date') }}</th>
                <th class="align-middle">{{ __('messages.customer') }}</th>
                <th class="text-center align-middle">{{ __('messages.number') }}</th>
                <th class="align-middle">{{ __('messages.state') }}</th>
                <th class="align-middle">{{ __('messages.coin') }}</th>
                <th class="align-middle">{{ __('messages.t_gravado') }}</th>
                <th class="align-middle">{{ __('messages.t_igv') }}</th>
                <th class="align-middle">{{ __('messages.total') }}</th>
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
                                @can('market_ventas_documentos_nota')
                                    <a class="dropdown-item" href="{{ route('market_sales_note',$item->external_id) }}" ><i class="fal fa-file-invoice mr-1"></i>{{ __('messages.note') }}</a>
                                @endcan
                                <a class="dropdown-item" href="javascript:openPayments('{{ $item->id }}','{{ $item->series }} {{ str_pad($item->number, 8, "0", STR_PAD_LEFT) }}')" ><i class="fal fa-money-bill-wave mr-1"></i>{{ __('messages.payments') }}</a>
                                <a class="dropdown-item" href="{{ route('download_sale_document',['market','xml',$item->filename]) }}"><i class="fal fa-download mr-1"></i>XML</a>
                                <a class="dropdown-item" href="{{ route('download_sale_document',['market','cdr','R-'.$item->filename]) }}"><i class="fal fa-download mr-1"></i>CDR</a>
                                <a class="dropdown-item" href="javascript:void(0)" onclick="openModalPrint('{{ $item->external_id }}')"><i class="fal fa-print mr-1"></i>Imprimir</a>
                            </div>
                        </div>
                    </td>
                    <td class="text-center align-middle">{{ $item->document_date }}</td>
                    <td class="align-middle">{{ json_decode($item->customer)->trade_name }}</td>
                    <td class="align-middle">
                        <span class="fw-900">{{ $item->series }} {{ str_pad($item->number, 8, "0", STR_PAD_LEFT) }}</span>
                        <br>
                        <span class="fw-300 font-italic">{{ $item->document_type_description }}</span>
                    </td>
                    <td class="align-middle">
                        @if ($item->state_type_id == '01')
                            <span class="badge badge-info">{{ $item->description }}</span>
                        @elseif ($item->state_type_id == '03')
                            <span class="badge badge-success">{{ $item->description }}</span>
                        @elseif ($item->state_type_id == '05')
                            <span class="badge badge-primary">{{ $item->description }}</span>
                        @elseif ($item->state_type_id == '07')
                            <span class="badge badge-secondary">{{ $item->description }}</span>
                        @elseif ($item->state_type_id == '09')
                            <span class="badge badge-danger">{{ $item->description }}</span>
                        @elseif ($item->state_type_id == '11')
                            <span class="badge badge-dark">{{ $item->description }}</span>
                        @elseif ($item->state_type_id == '13')
                            <span class="badge badge-warning">{{ $item->description }}</span>
                        @endif
                    </td>
                    <td class="align-middle">{{ $item->currency_type_id }}</td>
                    <td class="text-right align-middle">{{ $item->total_taxed }}</td>
                    <td class="text-right align-middle">{{ $item->total_igv }}</td>
                    <td class="text-right align-middle">{{ $item->total }}</td>
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
    <div class="modal fade" id="modalPayments" tabindex="-1" aria-labelledby="modalPaymentsLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pagos del comprobante: <span id="modalPaymentsLabel" wire:ignore></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                          <tr >
                            <th scope="col" class="border-top-0">#</th>
                            <th scope="col" class="border-top-0">Fecha de pago</th>
                            <th scope="col" class="border-top-0">Método de pago</th>
                            <th scope="col" class="border-top-0">Destino</th>
                            <th scope="col" class="border-top-0">Referencia</th>
                            <th scope="col" class="border-top-0">Monto</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $key => $payment)
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td>{{ \Carbon\Carbon::parse($payment->date_of_payment)->format('d/m/Y') }}</td>
                                <td>{{ $payment->description }}</td>
                                <td>
                                    @if($payment->user_id)
                                    {{ 'CAJA GENERAL'.($payment->reference_number?' - '.$payment->reference_number:'') }}
                                    @else
                                    {{ $payment->bank_name.' - '.$payment->back_account_description }}
                                    @endif
                                </td>
                                <td>{{ $payment->reference }}</td>
                                <td>{{ $payment->payment }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalprint" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Imprimir</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="document_external_id" value="">
                    <div class="row js-list-filter">
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center mb-g">
                            <a type="button" onclick="printPDF('a4')" href="javascript:void(0)" class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100 js-showcase-icon shadow-hover-2">
                                <div class="rounded-top color-fusion-300 w-100 bg-primary-300">
                                    <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x hover-bg">
                                        <i class="fal fa-file"></i>
                                    </div>
                                </div>
                                <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                                    <span class="d-block text-truncate text-muted">A4</span>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center mb-g">
                            <a type="button" onclick="printPDF('ticket')" href="javascript:void(0)" class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100 js-showcase-icon shadow-hover-2">
                                <div class="rounded-top color-fusion-300 w-100 bg-primary-300">
                                    <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x hover-bg">
                                        <i class="fal fa-receipt"></i>
                                    </div>
                                </div>
                                <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                                    <span class="d-block text-truncate text-muted">Ticket</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!--div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
                </div-->
            </div>
        </div>
    </div>
    <script>
        function openPayments(id,number){
            $('#modalPaymentsLabel').html(number);
            @this.paymentsByDocument(id);
            $('#modalPayments').modal('show');
        }
        function setDatesEndStart(start_date,date_end){
            @this.set('start_date',start_date);
            @this.set('date_end',date_end);
        }
        function clearEndStart(){
            @this.set('start_date',null);
            @this.set('date_end',null);
        }
        function openModalPrint(external_id){
            $('#document_external_id').val(external_id)
            $('#exampleModalprint').modal('show');
        }
        function printPDF(format){
            let external_id = $('#document_external_id').val();
            window.open(`../../print/document/`+external_id+`/`+format, '_blank');
        }
    </script>
</div>
