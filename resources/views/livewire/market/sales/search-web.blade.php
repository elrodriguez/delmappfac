<div>
    <div class="row">
        <div class="col-xl-12">
            <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                Buscar comprobante electrónico
                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                    Todos los campos son requeridos para la búsqueda
                </small>
            </h2>
        </div>
        <div class="col-xl-6 ml-auto mr-auto">
            <div class="card p-4  bg-faded">
                <form novalidate="" wire:submit.prevent="searhDocument">
                    <div class="form-group row">
                        <div class="col-3">
                            <label class="form-label" for="document_type_id">@lang('messages.voucher_type')</label>
                            <select class="custom-select form-control" wire:model.defer="document_type_id">
                                <option value="">Seleccionar</option>
                                @foreach ($document_types as $document_type)
                                <option value="{{ $document_type->id }}">{{ $document_type->description }}</option>
                                @endforeach
                            </select>
                            @error('document_type_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="f_issuance">@lang('messages.f_issuance') <span class="text-danger">*</span> </label>
                            <div class="input-group">
                                <input type="text" class="form-control " name="f_issuance" wire:model="f_issuance" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-1">
                                <div class="input-group-append">
                                    <span class="input-group-text fs-xl">
                                        <i class="fal fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            @error('f_issuance')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="serie">@lang('messages.serie') <span class="text-danger">*</span> </label>
                            <input wire:model.defer="serie" id="serie" type="text" class="form-control">
                            @error('serie')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="number">@lang('messages.number') <span class="text-danger">*</span> </label>
                            <input wire:model.defer="number" id="number" type="text" class="form-control">
                            @error('number')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <label class="form-label" for="client_number">Número Cliente (RUC/DNI/CE) <span class="text-danger">*</span> </label>
                            <input wire:model.defer="client_number" id="client_number" type="text" class="form-control">
                            @error('client_number')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-3">
                            <label class="form-label" for="total_amount">Monto total <span class="text-danger">*</span> </label>
                            <input wire:model.defer="total_amount" id="total_amount" type="text" class="form-control">
                            @error('total_amount')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div> 
                    <div class="row no-gutters">
                        <div class="col-md-4 ml-auto text-right">
                            <button id="js-login-btn" type="submit" class="btn btn-block btn-danger btn-lg mt-3">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
            @if($document)
                <div class="card mb-g mt-3 border shadow-0">
                    <div class="card-header p-0">
                        <div class="row no-gutters row-grid align-items-stretch">
                            <div class="col-12 col-md">
                                <div class="text-uppercase text-muted py-2 px-3">Cliente</div>
                            </div>
                            <div class="col-sm-4 col-md-2 col-xl-1 hidden-md-down text-center">
                                <div class="text-uppercase text-muted py-2 px-3">Numero</div>
                            </div>
                            <div class="col-sm-4 col-md-2 hidden-md-down text-center">
                                <div class="text-uppercase text-muted py-2 px-3">Total</div>
                            </div>
                            <div class="col-sm-4 col-md-2 hidden-md-down text-center">
                                <div class="text-uppercase text-muted py-2 px-3">Descargas</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row no-gutters row-grid">
                            <div class="col-12">
                                <div class="row no-gutters row-grid align-items-stretch">
                                    <div class="col-md align-middle">
                                        <div class="p-3">
                                            <span class="fs-lg fw-500 d-block">{{ json_decode($document->customer)->trade_name }}</span>
                                            <div class="d-block text-muted fs-sm">
                                                {{ json_decode($document->customer)->number }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-2 col-xl-1 hidden-md-down text-center align-middle">
                                        <div class="p-3 p-md-3">
                                            {{ $document->series.'-'.str_pad($document->number, 8, "0", STR_PAD_LEFT) }}
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-2 hidden-md-down text-right align-middle">
                                        <div class="p-3 p-md-3">
                                            {{ $document->total }}
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-2 hidden-md-down text-center align-middle">
                                        <div class="p-3 p-md-3">
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('download_sale_document_web',['market','xml',$document->filename]) }}" type="button" class="btn btn-secondary waves-effect waves-themed">XML</a>
                                                <button onclick="openModalPrint('{{ $document->external_id }}')" type="button" class="btn btn-secondary waves-effect waves-themed">PDF</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                     
                        </div>
                    </div>
                </div>
            @endif
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
        window.addEventListener('response_sales_search', event => {
        swalAlert(event.detail.tit,event.detail.ico,event.detail.msg);
        });
        function swalAlert(tit,ico,msg){
            Swal.fire(tit, msg, ico);
        }
        function openModalPrint(external_id){
            $('#document_external_id').val(external_id)
            $('#exampleModalprint').modal('show');
        }
        function printPDF(format){
            let external_id = $('#document_external_id').val();
            window.open(`../../search/print/document/`+external_id+`/`+format, '_blank');
        }
    </script>
</div>