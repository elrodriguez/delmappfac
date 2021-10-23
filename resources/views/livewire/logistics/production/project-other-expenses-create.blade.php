<div>
    <div class="panel-container show">
            <div class="panel-content">
                <div class="panel-tag"><code>PROYECTO</code> {{ $project_description }}</div>
            </div>
            <div class="panel-content">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="select2-ajax">
                            Tipo comprobante <span class="text-danger">*</span>
                        </label>
                        <select class="custom-select form-control" name="expense_type_id" id="expense_type_id" wire:model.defer="expense_type_id">
                            <option value>{{ __('messages.to_select') }}</option>
                            @foreach ($expense_types as $expense_type)
                                <option value="{{ $expense_type->id }}" >{{ $expense_type->description }}</option>
                            @endforeach
                        </select>
                        @error('expense_type_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="select2-ajax">
                            Motivo <span class="text-danger">*</span>
                        </label>
                        <select class="custom-select form-control" name="expense_reason_id" id="expense_reason_id" wire:model.defer="expense_reason_id">
                            <option value>{{ __('messages.to_select') }}</option>
                            @foreach ($expense_reasons as $expense_reason)
                                <option value="{{ $expense_reason->id }}" >{{ $expense_reason->description }}</option>
                            @endforeach
                        </select>
                        @error('expense_reason_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">{{ __('messages.number') }} <span class="text-danger">*</span></label>
                        <input class="form-control" id="number" name="number" wire:model.defer="number">
                        @error('number')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2 mb-3">
                        <div class="table-responsive" wire:ignore.self>
                            <label class="form-label">{{ __('messages.f_issuance') }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control " name="date_of_issue" wire:model="date_of_issue" onchange="this.dispatchEvent(new InputEvent('input'))" id="datepicker-1">
                                <div class="input-group-append">
                                    <span class="input-group-text fs-xl">
                                        <i class="fal fa-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            @error('date_of_issue')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="select2-ajax">
                            @lang('messages.supplier')
                        </label>
                        <div wire:ignore>
                            <select data-placeholder="@lang('messages.select_state')" name="supplier_id" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectSupplier(event)"></select>
                        </div>
                        @error('supplier_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                <h3>
                    <ins>Pagos</ins>
                    <button class="btn btn-link" wire:click="addPayment">[+ Agregar]</button>
                </h3>
                @foreach ($expense_payments as $k => $expense_payment)
                    <div class="form-row">
                        <div class="col-md-3 mb-3" wire:ignore.self>
                            <label class="form-label">Método de gasto <span class="text-danger">*</span></label>
                            <select class="custom-select form-control" name="expense_payments[{{ $k }}].expense_method_type_id" wire:model.defer="expense_payments.{{ $k }}.expense_method_type_id">
                                @foreach ($expense_method_types as $expense_method_type)
                                    <option onclick="selectExpenseMethodTypes('{{ $expense_method_type->has_card }}','{{ $k }}','{{ $expense_method_type->card_brand_id }}')" value="{{ $expense_method_type->id }}" >{{ $expense_method_type->description }}</option>
                                @endforeach
                            </select>
                            @error('expense_payments.{{ $k }}.expense_method_type_id')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3" wire:ignore.self>
                            <label class="form-label">Salio de <span class="text-danger">*</span></label>
                            <select {{ ($expense_payment['has_card']==1?'':'disabled') }} class="custom-select form-control" id="bank_account_id{{ $k }}" name="expense_payments[{{ $k }}].bank_account_id" wire:model.defer="expense_payments.{{ $k }}.bank_account_id">
                                <option value="0" id="bank_account_id{{ $k }}text">....</option>
                                @foreach ($bank_accounts as $bank_account)
                                    <option value="{{ $bank_account->id }}">{{ $bank_account->description }} - {{ $bank_account->number }}</option>
                                @endforeach
                            </select>
                            @error('expense_payments.{{ $k }}.bank_account_id')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Referencia <span class="text-danger">*</span></label>
                            <input class="form-control" name="expense_payments[{{ $k }}].reference" wire:model="expense_payments.{{ $k }}.reference">
                            @error('expense_payments.{{ $k }}.reference')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">Monto <span class="text-danger">*</span></label>
                            <input class="form-control" name="expense_payments[{{ $k }}].payment" wire:model="expense_payments.{{ $k }}.payment">
                            @error('expense_payments.{{ $k }}.payment')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-1 mb-3 align-middle">
                            @if ($k > 0)
                                <button wire:click="removePayment('{{ $k }}')" class="btn btn-danger btn-icon waves-effect waves-themed">
                                    <i class="fal fa-trash-alt"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                <div class="d-flex flex-row-reverse">
                    <div class="p-2">
                        <button onclick="openModalDetails()" type="button" class="btn btn-lg btn-primary waves-effect waves-themed mb-3">Agregar Detalle</button>
                    </div>
                  </div>

                @if (count($box_items)>0)
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="table-responsive">
                                <table class="table m-0 table-bordered table-sm table-striped">
                                    <thead class="bg-info-900">
                                    <tr>
                                        <th style="width: 10%" class="text-center"></th>
                                        <th style="width: 70%">{{ __('messages.description') }}</th>
                                        <th style="width: 20%" class="text-center">{{ __('messages.amount') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($box_items as $key => $box_item)
                                        <tr>
                                            <td class="align-middle text-center" width="10%">
                                                <button class="btn btn-default btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="removeDetail({{ $key }})" type="button">
                                                    <i class="fal fa-trash-alt"></i>
                                                </button>
                                            </td>
                                            <td width="70%" class="align-middle">{{ $box_item['description'] }}</td>
                                            <td width="20%" class="align-middle text-right pr-3">{{ number_format($box_item['total'], 2, '.', '') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 offset-md-8">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-6 col-form-label text-right">Total a pagar</label>
                                <div class="col-sm-6">
                                <input type="text" readonly class="form-control text-right" wire:model.defer="total">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('logistics_production_projects_other_expenses',$project_id) }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
                @if (count($box_items)>0)
                    <button class="btn btn-primary ml-auto waves-effect waves-themed" type="button" wire:loading.attr="disabled" wire:click="store">
                        <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-1" role="status" aria-hidden="true"></span>
                        <span >{{ __('messages.save') }}</span>
                    </button>
                @endif
            </div>

        <script>
            function selectSupplier(e){
                @this.set('supplier_id', e.target.value);
            }
            window.addEventListener('response_success_expenses_store', event => {
                let msg = event.detail.message;
                let tit = event.detail.title;
                let ico = event.detail.icon;

                swalAlert(msg,tit,ico);
            });
            function swalAlert(msg,tit,ico){
                Swal.fire(tit, msg, ico);
                if(ico == 'success'){
                    $("#select2-ajax").val('').trigger('change');
                }
            }
            function selectExpenseMethodTypes(card,index,card_brand_id){
                let bank_account_id = document.getElementById('bank_account_id'+index);
                let optionText = document.getElementById('bank_account_id'+index+"text");
                let expense_payment_has_card = "expense_payments."+index+".has_card";
                let expense_payment_card_brand_id = "expense_payments."+index+".card_brand_id";
                @this.set(expense_payment_has_card,card);
                @this.set(expense_payment_card_brand_id,card_brand_id);
                if(card == 1){
                    bank_account_id.disabled = false;
                }else{
                    bank_account_id.disabled = true;
                    bank_account_id.value = 0;
                }
            }
            function openModalDetails(){
                $('#exampleModaldetails').modal('show');
            }
        </script>
    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModaldetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ __('messages.description') }}</label>
                        <textarea wire:model.defer="description" name="description" id="description" class="form-control" rows="2"></textarea>
                        @error('description')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="">{{ __('messages.amount') }}</label>
                        <input wire:model.defer="amount" name="amount" id="amount" type="text" class="form-control">
                        @error('amount')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button wire:click="addDetails" type="button" class="btn btn-primary">{{ __('messages.add') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
