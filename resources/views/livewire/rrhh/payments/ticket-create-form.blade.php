<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label class="form-label" for="select2-ajax">
                            @lang('messages.employee') <span class="text-danger">*</span>
                        </label>
                        <div wire:ignore>
                            <select data-placeholder="@lang('messages.select_state')" name="person_id" wire:model.defer="person_id" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectEmployee(event)"></select>
                        </div>
                        @error('person_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="table-responsive" wire:ignore.self>
                        <label class="form-label">Compromisos</label>
                        <table class="table table-sm bg-info-900 table-bordered m-0 table-scroll">
                            <thead class="bg-info-200">
                                <tr>
                                    <th width="10%" class="text-center">#</th>
                                    <th width="40%">{{ __('messages.description') }}</th>
                                    <th width="20%" class="text-center">{{ __('messages.date') }}</th>
                                    <th width="20%" class="text-center">{{ __('messages.amount') }}</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody class="tbody-width-200">
                                @if (count($employee_concepts)>0)
                                    @foreach($employee_concepts as $key => $employee_concept)
                                        <tr>
                                            <td width="10%" class="align-middle text-center">{{ $key + 1 }}</td>
                                            <td width="40%" class="align-middle">
                                                {{ $employee_concept['description'] }}

                                            </td>
                                            <td width="20%" class="align-middle text-center">{{ \Carbon\Carbon::parse($employee_concept['created_at'])->format('d/m/Y') }}</td>
                                            <td width="20%" class="align-middle text-right">
                                                @if ($employee_concept['operation'] == 0)
                                                    -{{ $employee_concept['amount'] }}
                                                @else
                                                    {{ $employee_concept['amount'] }}
                                                @endif
                                            </td>
                                            <td width="10%" class="align-middle text-center">
                                                <button wire:click="selectConceptItem('{{ $key }}')" type="button" class="btn btn-default btn-xs btn-icon waves-effect waves-themed">
                                                    <i class="fal fa-donate"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <th colspan="5" class="text-center">No tiene compromisos </th>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="table-responsive" wire:ignore.self>
                        <label class="form-label">Proyectos</label>
                        <table class="table table-sm bg-info-900 table-bordered m-0 table-scroll">
                            <thead class="bg-info-200">
                                <tr>
                                    <th width="10%" class="text-center">#</th>
                                    <th width="40%">{{ __('messages.description') }}</th>
                                    <th width="20%" class="text-center">{{ __('messages.date') }}</th>
                                    <th width="20%" class="text-center">{{ __('messages.amount') }}</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody class="tbody-width-200">
                                @if (count($employee_projects)>0)
                                    @foreach($employee_projects as $key => $employee_project)
                                        <tr>
                                            <td width="10%" class="align-middle text-center">{{ $key + 1 }}</td>
                                            <td width="40%" class="align-middle">
                                                <span class="fw-900"><u>{{ $employee_project['pro_name'] }}</u></span>
                                                <p class="m-0">{{ $employee_project['description'] }}</p>
                                            </td>
                                            <td width="20%" class="align-middle text-center">{{ \Carbon\Carbon::parse($employee_project['created_at'])->format('d/m/Y') }}</td>
                                            <td width="20%" class="align-middle text-right">{{ number_format($employee_project['salary'], 2, '.', '') }}</td>
                                            <td width="10%" class="align-middle text-center">
                                                <button wire:click="selectProjectEmployee('{{ $key }}')" type="button" class="btn btn-default btn-xs btn-icon waves-effect waves-themed">
                                                    <i class="fal fa-donate"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <th colspan="5" class="text-center">no participa en proyectos</th>
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
                <div class="col-md-12 mb-3">
                    <div class="table-responsive">
                        <table class="table m-0 table-bordered table-sm table-striped">
                            <thead class="bg-info-900">
                              <tr>
                                <th style="width: 10%" class="text-center"></th>
                                <th style="width: 80%">{{ __('messages.description') }}</th>
                                <th style="width: 10%" class="text-center">{{ __('messages.amount') }}</th>
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
                                        <td width="80%" class="align-middle">{{ $box_item['description'] }}</td>
                                        <td width="10%" class="align-middle text-right">{{ number_format($box_item['total'], 2, '.', '') }}</td>
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
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('rrhh_payments_ticket') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
            <button class="btn btn-primary ml-auto waves-effect waves-themed" type="submit" wire:loading.attr="disabled">
                <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-1" role="status" aria-hidden="true"></span>
                <span >{{ __('messages.save') }}</span>
            </button>
        </div>
    </form>
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
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-center align-items-center mb-g">
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
                    <!--div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center mb-g">
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
                    </div-->
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
        function selectEmployee(e){
            @this.set('person_id', e.target.value);
            @this.searchEmployeeConcepts();
        }
        window.addEventListener('response_success_tecket_employee', event => {
            openModalPrint()
            //swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            $("#select2-ajax").val("").trigger( "change" )
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function openModalPrint(){
            $('#exampleModalprint').modal('show');
        }
        function printPDF(format){
            let external_id = $('#document_external_id').val();
            $("#select2-ajax").val("").trigger( "change" );
            window.open(`../print/expense/`+external_id+`/`+format, '_blank');
        }
    </script>
</div>
