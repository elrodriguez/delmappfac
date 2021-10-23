<div>
    <div class="panel-container show">
        <form class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self>
            <div class="panel-content">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div wire:ignore>
                                    <label class="form-label">
                                        @lang('messages.customer')
                                        <span class="ml-1"><a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalClientNew">[ +Nuevo ]</a></span>
                                    </label>
                                    <input class="form-control basicAutoComplete" type="text" placeholder="@lang('messages.search_customer')" data-url="{{ route('market_sales_customers_search') }}" autocomplete="off" />
                                </div>
                                @error('customer_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <div wire:ignore>
                                    <label class="form-label" for="select3-ajax">
                                        @lang('messages.products')
                                    </label>
                                    <select data-placeholder="@lang('messages.select_state')" class="js-data-example-ajax form-control" id="select3-ajax"  onchange="selectProduct(event)"></select>
                                </div>
                                @error('item_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
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
                            <div class="col-md-6 mb-3">
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
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
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
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="f_expiration">@lang('messages.f_expiration') <span class="text-danger">*</span> </label>
                                <div class="input-group">
                                    <input type="text" class="form-control " name="f_expiration" wire:model="f_expiration" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-2">
                                    <div class="input-group-append">
                                        <span class="input-group-text fs-xl">
                                            <i class="fal fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="example-textarea">{{ __('messages.additional_information') }}</label>
                                <textarea class="form-control" id="example-textarea" rows="5" name="additional_information" wire:model.defer="additional_information"></textarea>
                            </div>
                        </div>
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

            @if(count($payment_method_types)>0)
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
                    <div class="col-md-12 mb-3">
                        <h3>Métodos de pago
                            <span class="ml-1"><a href="javascript:void(0)" wire:click="newPaymentMethodTypes">[ +{{ __('messages.add') }} ]</a></span>
                        </h3>
                        @foreach ($payment_method_types as $key => $payment_method_type)
                            <div class="form-row">

                                <div class="col-md-1 mb-3 align-middle">
                                    @if ($key > 0)
                                    <a href="javascript:void(0);" class="btn btn-dark btn-sm btn-icon waves-effect waves-themed" wire:click="removePaymentMethodTypes('{{ $key }}')">
                                        <i class="fal fa-times"></i>
                                    </a>
                                    @endif
                                </div>

                                <div class="col-md-3 mb-3" wire:ignore.self>
                                    <label class="form-label" for="validationCustom01">Método de pago <span class="text-danger">*</span> </label>
                                    <select class="custom-select form-control" wire:model.defer="payment_method_types.{{ $key }}.method">
                                        @foreach ($cat_payment_method_types as $cat_payment_method_type)
                                            <option value="{{ $cat_payment_method_type->id }}">{{ $cat_payment_method_type->description }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3" wire:ignore.self>
                                    <label class="form-label" for="validationCustom01">Destino <span class="text-danger">*</span> </label>
                                    <select class="custom-select form-control" wire:model.defer="payment_method_types.{{ $key }}.destination">
                                        @foreach ($cat_expense_method_types as $cat_expense_method_type)
                                            <option value="{{ $cat_expense_method_type['id'] }}">{{ $cat_expense_method_type['description'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Referencia <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" wire:model.defer="payment_method_types.{{ $key }}.reference">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label">Monto <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control text-right" wire:model.defer="payment_method_types.{{ $key }}.amount">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-8">
                        <div class="form-group row">
                            <label for="staticEmail" class="col-sm-6 col-form-label text-right"></label>
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-primary btn-block waves-effect waves-themed" wire:loading.attr="disabled" wire:click="validateForm()">
                                    <span wire:loading wire:target="validateForm" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                                    <span>Pagar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </form>
        {{-- modals --}}
        <div class="modal fade" id="exampleModalClientNew" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"  wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.new') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3" wire:ignore.self>
                                <label class="form-label" for="identity_document_type_id">Tipo Doc. Identidad <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control" wire:model.defer="identity_document_type_id">
                                    @foreach ($identity_document_types as $identity_document_type)
                                        <option value="{{ $identity_document_type->id }}">{{ $identity_document_type->description }}</option>
                                    @endforeach
                                </select>
                                @error('identity_document_type_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3" wire:ignore.self>
                                <label class="form-label" for="number_id">{{ __('messages.number') }} <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="number_id" wire:model.defer="number_id">
                                @error('number_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3" wire:ignore.self>
                                <label class="form-label" for="name">{{ __('messages.name') }} <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="name" wire:model.defer="name">
                                @error('name')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3" wire:ignore.self>
                                <label class="form-label" for="last_paternal">{{ __('messages.last_paternal') }} <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="last_paternal" wire:model.defer="last_paternal">
                                @error('last_paternal')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3" wire:ignore.self>
                                <label class="form-label" for="last_maternal">{{ __('messages.last_maternal') }} <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" name="last_maternal" wire:model.defer="last_maternal">
                                @error('last_maternal')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3" wire:ignore.self>
                                <label class="form-label" for="trade_name">{{ __('messages.trade_name') }}</label>
                                <input type="text" class="form-control" name="trade_name" wire:model.defer="trade_name">
                                
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="sex">@lang('messages.sex')</label>
                                <select class="custom-select form-control" wire:model.defer="sex" id="sex" name="sex" required="">
                                    <option>@lang('messages.to_select')</option>
                                    <option value="m">Masculino</option>
                                    <option value="f">Femenino</option>
                                </select>
                                @error('sex')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                        <button type="button" class="btn btn-primary" wire:click="storeClient()">{{ __('messages.save') }}</button>
                    </div>
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
        function selectCustomer(val){
            console.log(val)
            @this.set('customer_id', val);
        }
        function selectProduct(e){
            @this.set('item_id', e.target.value);
            @this.clickAddItem();
        }
        function clearSelect2(){
            $('.basicAutoComplete').autoComplete('set', { value: "{{ $xgenerico->value }}", text: "{{ $xgenerico->text }}" });
            $('#select3-ajax').val(null).empty();
        }
        function clearSelect3(){
            $('#select3-ajax').val(null).empty();
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
            window.open(`../../print/document/`+external_id+`/`+format, '_blank');
        }
        window.addEventListener('response_success_customer_store', event => {
           swalAlert(event.detail.message);
           setSelect2(event.detail.idperson,event.detail.nameperson);
        });
        function setSelect2(id,title){
            $('.basicAutoComplete').autoComplete('set', { value: id, text: title });
            $('#exampleModalClientNew').modal('hide');
            @this.set('customer_id', id);
        }
    </script>
</div>
