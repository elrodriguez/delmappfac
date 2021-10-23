<div class="panel-container show">
    <div class="panel-content d-flex flex-row align-items-center">
        <div style="width: 50%" class="mr-2" wire:ignore>
        <select data-placeholder="@lang('messages.select_state')" name="representative_id" class="js-data-example-ajax form-control" id="select2-ajax"  onchange="selectPerson(event)"></select>
        </div>
        <button wire:click="addRepresentation()" type="button" class="btn btn-primary waves-effect waves-themed">{{ __('messages.add') }}</button>
        <button type="button" class="btn btn-link ml-auto waves-effect waves-themed" data-toggle="modal" data-target="#staticBackdrop">{{ __('messages.new') }}</button>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped w-100 dataTable dtr-inline collapsed">
                <thead class="bg-info-900">
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">DNI</th>
                        <th>{{ __('messages.name') }}</th>
                        <th>{{ __('messages.address') }}</th>
                        <th class="text-center">{{ __('messages.telephone') }}</th>
                        <th class="text-center">{{ __('messages.birth_date') }}</th>
                        <th class="text-center">{{ __('messages.age') }}</th>
                        <th class="text-center">{{ __('messages.relationship') }}</th>
                        <th class="text-center">¿{{ __('messages.lives') }}?</th>
                        <th class="text-center">{{ __('messages.live_with_the_student') }}</th>
                        <th class="text-center">{{ __('messages.state') }}</th>
                        <th class="text-center" width="80px">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($representatives)>0)
                        @foreach ($representatives as $key => $representative)
                        <tr>
                            <th scope="row" class="text-center align-middle">{{ $key + 1 }}</th>
                            <td class="text-center align-middle">{{ $representative['number'] }}</td>
                            <td class="align-middle">{{ $representative['trade_name'] }}</td>
                            <td class="align-middle">{{ $representative['address'] }}</td>
                            <td class="text-center align-middle">{{ $representative['telephone'] }}</td>
                            <td class="text-center align-middle">{{ $representative['birth_date'] }}</td>
                            <td class="text-center align-middle">{{ $representative['age'] }}</td>
                            <td class="text-center align-middle">
                                <select class="custom-select form-control" name="representatives[{{ $key }}].relationship" wire:model="representatives.{{ $key }}.relationship">
                                    <option>{{ __('messages.to_select') }}</option>
                                    <option value="mama">Mamá</option>
                                    <option value="papa">Papá</option>
                                    <option value="hermano">Hermano</option>
                                    <option value="hermana">Hermana</option>
                                    <option value="tio">Tio</option>
                                    <option value="tia">Tia</option>
                                    <option value="primo">Primo</option>
                                    <option value="prima">Prima</option>
                                    <option value="abuela">Abuela</option>
                                    <option value="abuelo">Abuelo</option>
                                    <option value="amigo">Amigo(a) de la familia</option>
                                </select>
                                @error('representatives.'.$key.'.relationship')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </td>
                            <td class="align-middle">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input wire:model="representatives.{{ $key }}.lives" value="1" type="radio" class="custom-control-input" id="lives{{ $key }}-si" name="representatives[{{ $key }}].lives">
                                    <label class="custom-control-label" for="lives{{ $key }}-si">si</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input wire:model="representatives.{{ $key }}.lives" value="0" type="radio" class="custom-control-input" id="lives{{ $key }}-no" name="representatives[{{ $key }}].lives">
                                    <label class="custom-control-label" for="lives{{ $key }}-no">no</label>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="custom-control custom-checkbox">
                                    <input wire:model="representatives.{{ $key }}.live_with_the_student" value="1" type="checkbox" class="custom-control-input" id="live_with_the_student{{ $key }}" name="representatives[{{ $key }}].live_with_the_student">
                                    <label class="custom-control-label" for="live_with_the_student{{ $key }}">si</label>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="custom-control custom-checkbox">
                                    <input wire:model="representatives.{{ $key }}.state" value="1" type="checkbox" class="custom-control-input" id="state{{ $key }}" name="representatives[{{ $key }}].state">
                                    <label class="custom-control-label" for="state{{ $key }}">Activo</label>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <button class="btn btn-primary btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="updateRepresentation('{{ $key }}')" type="button">
                                    <i class="fal fa-check"></i>
                                </button>
                                <button class="btn btn-default btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="removeAssignment('{{ $representative['id'] }}')" type="button">
                                    <i class="fal fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @else
                    <tr class="odd">
                        <td colspan="12" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
        <a href="{{ route('academic_students') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>Atras</a>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ __('messages.new') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="validationCustom01">Tipo Doc. Identidad <span class="text-danger">*</span> </label>
                                <select class="custom-select form-control" id="identity_document_type_id" name="identity_document_type_id" required="" wire:model.defer="identity_document_type_id">
                                    <option>@lang('messages.to_select')</option>
                                    @foreach ($identity_document_types as $identity_document_type)
                                        <option value="{{ $identity_document_type->id }}">{{ $identity_document_type->description }}</option>
                                    @endforeach
                                </select>
                                @error('identity_document_type_id')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="number">@lang('messages.number')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="number" id="number" name="number" required="">
                                @error('number')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="marital_state">@lang('messages.state')</label>
                                <select class="custom-select form-control" wire:model="marital_state" id="marital_state" name="marital_state" required="">
                                    <option>@lang('messages.to_select')</option>
                                    <option value="soltero">Soltero</option>
                                    <option value="casado">Casado</option>
                                    <option value="divorciado">Divorciado</option>
                                    <option value="conviviente">Conviviente</option>
                                </select>
                                @error('marital_state')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="birth_date">@lang('messages.birth_date')<span class="text-danger">*</span></label>
                                <div class="input-group" wire:ignore>
                                    <input required="" type="text" class="form-control" wire:model="birth_date" name="birth_date" id="datepicker-7" onchange="this.dispatchEvent(new InputEvent('input'))">
                                    <div class="input-group-append">
                                        <span class="input-group-text fs-xl">
                                            <i class="fal fa-calendar-alt"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('birth_date')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="name">{{ __('messages.name') }} <span class="text-danger">*</span> </label>
                                <input type="text" class="form-control" wire:model="name" id="name" name="name" required="">
                                @error('name')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="last_paternal">@lang('messages.last_paternal')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="last_paternal" id="last_paternal" name="last_paternal" required="">
                                @error('last_paternal')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="last_maternal">@lang('messages.last_maternal')<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" wire:model="last_maternal" id="last_maternal" name="last_maternal" required="">
                                @error('last_maternal')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label" for="email">@lang('messages.email')</label>
                                <input type="text" class="form-control" wire:model="email" id="email" name="email">
                                @error('email')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-3" wire:ignore>
                                <label class="form-label" for="country_id">@lang('messages.country_of_origin')</label>
                                <select class="custom-select form-control" id="country_id" name="country_id"  wire:model="country_id">
                                    <option value>@lang('messages.to_select')</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->description }}</option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8 mb-3" wire:ignore >
                                <label class="form-label" for="ubigeo">Ubigeo </label>
                                <select id="ubigeo" name="ubigeo" class="form-control" data="{{ $ubigeos }}" data-change="selectubigeo">
                                </select>
                                @error('ubigeo')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="address">@lang('messages.address')</label>
                                <textarea class="form-control" id="address" name="address" required="" wire:model.defer="address"></textarea>
                                @error('address')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="sex">@lang('messages.sex')</label>
                                <select class="custom-select form-control" wire:model="sex" id="sex" name="sex" required="">
                                    <option>@lang('messages.to_select')</option>
                                    <option value="m">Masculino</option>
                                    <option value="f">Femenino</option>
                                </select>
                                @error('sex')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label" for="telephone">@lang('messages.telephone')</label>
                                <input type="text" class="form-control" wire:model="telephone" id="telephone" name="telephone">
                                @error('telephone')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="place_birth">@lang('messages.place_birth')</label>
                                <input type="text" class="form-control" wire:model="place_birth" id="place_birth" name="place_birth">
                                @error('place_birth')
                                    <div class="invalid-feedback-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="store()">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function selectPerson(e){
            @this.set('representative_id', e.target.value);
        }
        function selectubigeo(e){
            @this.set('ubigeo', e);
        }
        window.addEventListener('response_student_store', event => {
           swalAlert(event.detail.message);
        });
        window.addEventListener('response_student_representation_update', event => {
            swalAlertUpdate(event.detail.message);
        });
        window.addEventListener('response_student_representation_add', event => {
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function swalAlertUpdate(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
    </script>
</div>

