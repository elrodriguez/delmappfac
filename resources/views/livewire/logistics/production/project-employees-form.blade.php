<div class="panel-container show">
    <div class="panel-content">
        <div class="panel-tag"><code>PROYECTO</code> {{ $project_description }}</div>
        <form id="formProjectsEmployee" class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="select2-ajax">
                        @lang('messages.employee')
                    </label>
                    <div wire:ignore>
                        <select data-placeholder="@lang('messages.select_state')" name="person_id" wire:model.defer="person_id" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectEmployee(event)"></select>
                    </div>
                    @error('person_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.occupation') }} <span class="text-danger">*</span> </label>
                    <div wire:ignore>
                        <select class="custom-select form-control" id="occupation_id" name="occupation_id" wire:model.defer="occupation_id" onchange="selectOccupation(event)">
                            <option value="">{{ __('messages.to_select') }}</option>
                            @foreach ($occupations as $occupation)
                            <option value="{{ $occupation->id }}">{{ $occupation->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('occupation_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label">{{ __('messages.stage') }} <span class="text-danger">*</span> </label>
                    <div class="input-group">
                        <select class="custom-select form-control" id="stage_id" name="stage_id" wire:model="stage_id">
                            <option value="0">{{ __('messages.all') }}</option>
                            @foreach ($stages as $stage)
                            <option value="{{ $stage->id }}">{{ $stage->description }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button onclick="addEmployee()" type="button" class="btn btn-primary waves-effect waves-themed">{{ __('messages.add') }}</button>
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
            <table class="table table-bordered table-hover">
                <thead class="bg-info-900">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">{{ __('messages.state') }}</th>
                        <th>{{ __('messages.stage') }}</th>
                        <th>{{ __('messages.employee') }}</th>
                        <th>{{ __('messages.occupation') }}</th>
                        <th class="text-center">{{ __('messages.salary') }}</th>
                        <th style="width: 60px" class="text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                @php
                    $total = 0;
                @endphp
                <tbody>
                    @if(count($employees)>0)
                        @foreach ($employees as $key => $employee)
                        <tr>
                            <td class="text-center align-middle">{{ $key + 1 }}</td>
                            <td class="text-center align-middle">
                                @if ($employee->state)
                                <span class="badge badge-primary">{{ __('messages.working') }}</span>
                                @else
                                <span class="badge badge-danger">{{ __('messages.retired') }}</span>
                                @endif
                            </td>
                            <td class="align-middle">{{ $employee->stage_description }}</td>
                            <td class="align-middle">{{ $employee->trade_name }}</td>
                            <td class="align-middle">{{ $employee->occupation_description }}</td>
                            <td class="text-right align-middle">{{ $employee->salary }}</td>
                            <td class="text-center align-middle" style="width: 60px">
                                @if ($project->state == 'pendiente')
                                <button wire:click="deleteEmployee('{{ $employee->id}}')" type="button" class="btn btn-default btn-icon rounded-circle waves-effect waves-themed">
                                    <i class="fal fa-trash-alt"></i>
                                </button>
                                @else
                                <button onclick="modalEditProjectEmployee('{{ $employee->id}}','{{ $employee->state}}','{{ $employee->occupation_id}}','{{ $employee->salary}}','{{ $employee->trade_name }}')" type="button" class="btn btn-default btn-icon rounded-circle waves-effect waves-themed">
                                    <i class="fal fa-pencil-alt"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @php
                            $total = $total + $employee->salary;
                        @endphp
                        @endforeach
                    @else
                    <tr class="odd">
                        <td colspan="7" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                    </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5">{{ __('messages.total') }}</td>
                        <td class="text-right">{{ number_format(ceil($total), 2, '.', '') }}</td>
                        <td class="text-center">
                            @if ($project->state == 'pendiente')
                            <button type="button" class="btn btn-primary btn-block waves-effect waves-themed" wire:loading.attr="disabled" wire:click="approve">
                                <span wire:loading wire:target="approve" wire:loading.class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span wire:loading.remove >{{ __('messages.approve') }}</span>
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
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalEditProjectEmployee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 wire:ignore class="modal-title" id="exampleModalLabelEditProjectEmployee"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                 </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">{{ __('messages.occupation') }} <span class="text-danger">*</span> </label>
                            <div wire:ignore>
                                <select class="custom-select form-control" id="update_occupation_id" name="update_occupation_id" wire:model.defer="update_occupation_id" onchange="selectOccupationUpdate(event)">
                                    <option value="">{{ __('messages.to_select') }}</option>
                                    @foreach ($occupations as $occupation)
                                    <option value="{{ $occupation->id }}">{{ $occupation->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('update_occupation_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.state') }} <span class="text-danger">*</span> </label>
                            <select class="custom-select form-control" id="update_state" name="update_state" wire:model.defer="update_state">
                                <option value="1">{{ __('messages.working') }}</option>
                                <option value="0">{{ __('messages.retired') }}</option>
                            </select>
                            @error('update_state')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('messages.salary') }} <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" name="update_amount" wire:model.defer="update_amount">
                            @error('update_amount')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="update">
                        <span wire:loading wire:target="update" wire:loading.class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        <span >{{ __('messages.to_update') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectEmployee(e){
            @this.set('person_id', e.target.value);
        }
        function selectOccupation(e){
            @this.set('occupation_id', e.target.value);
        }
        function selectOccupationUpdate(e){
            @this.set('update_occupation_id', e.target.value);
        }
        function addEmployee(){
            let stage = @this.get('stage_id');
            if(stage == 0){
                cadena = ' total para todas las Etapas';
            }else{
                cadena = '';
            }
            Swal.fire({
                title: 'Ingrese sueldo'+ cadena,
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.add') }}",
                cancelButtonText: "{{ __('messages.cancel') }}",
                preConfirm: (amount) => {
                    if($.trim(amount) == '') {
                        Swal.showValidationMessage(
                            `El campo es requerido.`
                        )
                    }
                    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
                    if(preg.test(amount) === true){
                        @this.store(amount);
                    }else{
                        Swal.showValidationMessage(
                            `Sólo números o decimales.`
                        )
                    }
                }
            });
        }
        window.addEventListener('response_projects_employees', event => {
           swalAlert(event.detail.title,event.detail.message,event.detail.state);
        });
        function swalAlert(title,msg,state){
            $("#select2-ajax").val("").trigger( "change" );
            $("#occupation_id").val("").trigger( "change" );
            Swal.fire(title, msg, state);
        }
        function modalEditProjectEmployee(id,state,occupation,amount,name){
            @this.set('update_id',id);
            @this.set('update_state',state);
            @this.set('update_occupation_id',occupation);
            @this.set('update_amount',amount);
            $('#exampleModalLabelEditProjectEmployee').text(name);
            $('#update_occupation_id').select2({
                dropdownParent: $("#exampleModalEditProjectEmployee")
            });
            $('#exampleModalEditProjectEmployee').modal('show');
        }
    </script>
</div>
