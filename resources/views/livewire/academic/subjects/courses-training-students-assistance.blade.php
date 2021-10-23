<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                {{ __('messages.list') }} <span class="fw-300"><i>{{ __('messages.students') }}</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="courses_id">{{ __('messages.courses') }}</label>
                            <select id="courses_id" class="custom-select form-control" >
                                <option value="">{{ __('messages.to_select') }}</option>
                                @php
                                    $lys='';
                                @endphp
                                @foreach ($courses as $label)
                                    @if($lys != $label['lys'])
                                    <optgroup label="{{ $label['level_description'].' / '.$label['year_description'].($label['section_description']?' / '.$label['section_description']:'') }}">
                                        @foreach ($courses as $item)
                                            @if($label['lys'] == $item['lys'])
                                                <option value="{{ $item['id'] }}" wire:click="getStudentByCourses({{ $item['id'] }})">{{ $item['description'] }}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                    @endif
                                    @php
                                        $lys = $label['lys'];
                                    @endphp
                                @endforeach
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">fecha de asistencia</label>
                            <div class="input-group" wire:ignore>
                                <input type="text" class="form-control" id="datepicker-7" onchange="activeBtn()">
                                <div class="input-group-append">
                                    <span class="input-group-text fs-xl">
                                        <i class="fal fa-calendar-alt"></i>
                                    </span>
                                </div>
                            </div>
                            @error('assistance_date')
                                <div class="invalid-feedback-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12  mb-3 d-flex flex-row align-items-center">
                        <button wire:click="reportAssistance" wire:loading.attr="disabled" type="button" class="btn btn-secondary ml-auto waves-effect waves-themed mr-3"><i class="fal fa-file-search mr-1"></i>{{ __('messages.report') }}</button>
                        <button wire:click="searchStudents" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-themed"><i class="fal fa-search mr-1"></i>{{ __('messages.search') }}</button>
                    </div>
                </div>
            </div>
            <div class="panel-content">
                <div class="card mb-g border shadow-0">
                    <div class="card-header">
                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <span class="h6 font-weight-bold text-uppercase">{{ __('messages.students') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered" id="table-10000">
                            <thead>
                                <tr wire:ignore.self>
                                    <th class="align-middle text-center">#</th>
                                    <th class="align-middle text-center">DNI</th>
                                    <th class="align-middle">Nombre Completo</th>
                                    <th colspan="3" class="align-middle text-center">

                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $key => $student)
                                    <tr>
                                        <th class="align-middle text-center">{{ $key + 1 }}</th>
                                        <th class="align-middle text-center">{{ $student['number'] }}</th>
                                        <th class="align-middle text-left">{{ $student['trade_name'] }}</th>
                                        <td class="align-middle text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input wire:model.defer="students.{{ $key }}.attended" type="checkbox" class="custom-control-input" id="attended{{ $key }}">
                                                <label class="custom-control-label" for="attended{{ $key }}">asistió</label>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="custom-control custom-checkbox">
                                                <input wire:model="students.{{ $key }}.justified" type="checkbox" class="custom-control-input" id="justified{{ $key }}">
                                                <label class="custom-control-label" for="justified{{ $key }}">Justificó</label>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <textarea class="form-control" rows="1" {{ $student['justified']?'':'disabled' }}  wire:model.defer="students.{{ $key }}.observation"></textarea>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(count($students)>0)
                            @if($btnsave)
                            <div class="row">
                                <div class="col-12  mb-3 d-flex flex-row align-items-center">
                                    <button wire:click="saveAssistance" wire:loading.attr="disabled" type="button" class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>{{ __('messages.save') }}</button>
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script defer>
        window.addEventListener('response_assistance_students_store', event => {
            swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function activeBtn(){
            let date = $('#datepicker-7').val();
            @this.set('assistance_date',date);
            @this.inactiveBtnsave()
        }
    </script>
</div>
