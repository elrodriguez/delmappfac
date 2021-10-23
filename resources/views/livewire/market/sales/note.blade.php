<div>
    <div class="panel-container show">
        <form class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self>
            <div class="panel-content">
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="document_type_id">@lang('messages.voucher_type') <span class="text-danger">*</span> </label>
                        <select class="custom-select form-control" wire:change="changeSeries" wire:model.defer="document_type_id">
                            @foreach ($document_types as $document_type)
                            <option value="{{ $document_type->id }}">{{ $document_type->description }}</option>
                            @endforeach
                        </select>
                        @error('document_type_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="serie_id">@lang('messages.serie') <span class="text-danger">*</span> </label>
                        <div class="input-group">
                            <select class="custom-select form-control" wire:change="selectCorrelative" wire:model.defer="serie_id">
                                @foreach ($series as $serie)
                                <option value="{{ $serie->id }}">{{ $serie->id }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text">{{ $correlative }}</span>
                            </div>
                        </div>
                        @error('serie_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="note_type_id">Tipo nota <span class="text-danger">*</span> </label>
                        <select class="custom-select form-control" wire:model.defer="note_type_id">
                            <option value="">{{ __('messages.to_select') }}</option>
                            @foreach ($note_types as $note_type)
                            <option value="{{ $note_type->id }}">{{ $note_type->description }}</option>
                            @endforeach
                        </select>
                        @error('note_type_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="f_issuance">@lang('messages.f_issuance') <span class="text-danger">*</span> </label>
                        <div class="input-group">
                            <input type="text" class="form-control " name="f_issuance" wire:model="f_issuance" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-1">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            @lang('messages.customer')
                        </label>
                        <input type="text" class="form-control" value="{{ json_decode($this->customer)->trade_name }}" disabled />
                        @error('customer_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            @lang('messages.description')
                        </label>
                        <input type="text" class="form-control" wire:model.defer="note_description"/>
                        @error('note_description')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="table-responsive">
                            <table class="table m-0 table-bordered table-sm table-striped">
                                <thead class="bg-info-900">
                                  <tr>
                                    <th class="text-center"></th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th class="text-center">{{ __('messages.price') }}</th>
                                    <th class="text-center">{{ __('messages.quantity') }}</th>
                                    <th class="text-center">{{ __('messages.total') }}</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @if (count($box_items)>0)
                                        @foreach ($box_items as $key => $box_item)
                                        <tr>
                                            <td class="align-middle text-center" width="10%">
                                                <button class="btn btn-default btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="removeItem({{ $key }})" type="button">
                                                    <i class="fal fa-trash-alt"></i>
                                                </button>
                                            </td>
                                            <td width="50%" class="align-middle">{{ json_decode($box_item['item'])->description }}</td>
                                            <td class="align-middle  text-right">{{ $box_item['input_unit_price_value'] }}</td>
                                            <td width="10%" class="align-middle text-center">
                                                @if (json_decode($box_item['item'])->item_type_id== '01')
                                                    <input type="text" wire:model="box_items.{{ $key }}.quantity" class="form-control text-right form-control-sm" name="box_items[{{ $key }}].quantity">
                                                    @error('box_items.'.$key.'.quantity')
                                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                                    @enderror
                                                @else
                                                    <i class="fal fa-times"></i>
                                                @endif

                                            </td>
                                            <td class="align-middle text-right pr-3">{{ number_format($box_item['total'], 2, '.', '') }}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                <div class="row">
                    <div class="col-md-4 offset-md-8 mb-3">
                        @if($total_exportation>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">OP.EXPORTACIÓN:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_exportation">
                            </div>
                        </div>
                        @endif
                        @if($total_free>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">OP.GRATUITAS:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_free">
                            </div>
                        </div>
                        @endif
                        @if($total_unaffected>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">OP.INAFECTAS:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_unaffected">
                            </div>
                        </div>
                        @endif
                        @if($total_exonerated>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">OP.EXONERADAS:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_exonerated">
                            </div>
                        </div>
                        @endif
                        @if($total_taxed>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">OP.GRAVADA:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_taxed">
                            </div>
                        </div>
                        @endif
                        @if($total_prepayment>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">ANTICIPOS:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_prepayment">
                            </div>
                        </div>
                        @endif
                        @if($total_igv>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">IGV:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_igv">
                            </div>
                        </div>
                        @endif
                        @if($total_plastic_bag_taxes>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">ICBPER:</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total_plastic_bag_taxes">
                            </div>
                        </div>
                        @endif
                        @if($total>0)
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right">TOTAL A PAGAR</label>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control rounded-0 border-top-0 border-left-0 border-right-0 pr-3 bg-transparent text-right" wire:model.defer="total">
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex flex-row align-items-center">
                        <a href="{{ route('market_sales_document_list') }}" type="button" class="btn btn-default ml-auto waves-effect waves-themed mr-3"><i class="fal fa-times mr-1"></i>{{ __('messages.cancel') }}</a>
                        <button type="button" class="btn btn-primary waves-effect waves-themed" wire:loading.attr="disabled" wire:click="validateForm()">
                            <span wire:loading wire:target="validateForm" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                            <span>Generar</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
        {{-- modals --}}
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
                    <input type="hidden" id="document_external_id" value="{{ $external_id }}">
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
        window.addEventListener('response_payment_total_different', event => {
            swalAlertError(event.detail.message);
        });
        function swalAlertError(msg){
            Swal.fire("Error", msg, "error");
        }
        function selectCustomer(e){
            @this.set('customer_id', e.target.value);
        }
        function selectProduct(e){
            @this.set('item_id', e.target.value);
            @this.clickAddItem();
        }
        function clearSelect2(){
            $('#select2-ajax').val(null).trigger('change');
            $('#select3-ajax').val(null).trigger('change');
        }
        function clearSelect3(){
            $('#select3-ajax').val(null).trigger('change');
        }
        window.addEventListener('response_clear_select_products_alert', event => {
            let showmsg = event.detail.showmsg;
            if(showmsg == true){
                swalAlert(event.detail.message)
            }
            clearSelect3();
        });
        window.addEventListener('response_success_document_charges_store', event => {
           openModalPrint();
           clearSelect2();
        });
        window.addEventListener('response_customer_not_ruc_exists', event => {
            swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire('',msg,"info");
        }
        function openModalPrint(){
            $('#exampleModalprint').modal('show');
        }
        function printPDF(format){
            let external_id = $('#document_external_id').val();
            window.open(`../../../print/document/`+external_id+`/`+format, '_blank');
        }
        window.addEventListener('response_success_customer_store', event => {
           swalAlert(event.detail.message);
           setSelect2(event.detail.idperson,event.detail.nameperson);
        });
        function setSelect2(id,title){
            let html = '<option value="'+title+'" selected="selected">'+title+'</option>';
            $('#select2-ajax').html(html);
            $('#select2-ajax').trigger('change');
            $('#exampleModalClientNew').modal('hide');
            @this.set('customer_id', id);
        }
    </script>
</div>
