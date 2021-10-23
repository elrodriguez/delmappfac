<div>
    <form class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self>
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="button-addon2">{{ __('messages.document') }} <span class="text-danger">*</span></label>
                    <div class="input-group input-group-multi-transition">
                        <input type="text" name="docmuent_serie" wire:model.defer="docmuent_serie" class="form-control" placeholder="{{ __('messages.serie') }}" aria-label="{{ __('messages.serie') }}">
                        <input type="text" name="docmuent_number" wire:model.defer="docmuent_number" class="form-control" placeholder="{{ __('messages.number') }}" aria-label="{{ __('messages.number') }}">
                        <div class="input-group-append">
                            <button wire:click="searchDocument()" class="btn btn-outline-default waves-effect waves-themed" type="button">
                                <span wire:loading wire:target="searchDocument" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-search" class="fal fa-search" role="status" aria-hidden="true"></span>
                            </button>
                            @if($btn_see)
                            <button onclick="printPDF('a4','{{ $external_id }}')" class="btn btn-outline-default waves-effect waves-themed" type="button"><i class="fal fa-file-search"></i></button>
                            @endif
                        </div>
                    </div>
                    <input type="hidden" name="docmuent_id" wire:model="docmuent_id">
                    @error('docmuent_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="button-addon2">{{ __('messages.student') }} <span class="text-danger">*</span></label>
                    <div class="input-group input-group-multi-transition">
                        <input type="text" name="number_search" wire:model.defer="number_search" class="form-control" placeholder="{{ __('messages.search_by_dni') }}" aria-label="{{ __('messages.search_by_dni') }}">
                        <input type="text" name="student_name" wire:model.defer="student_name" class="form-control" placeholder="{{ __('messages.name') }}" aria-label="{{ __('messages.name') }}" disabled>
                        <div class="input-group-append">
                            <button wire:click="searchStudent()" class="btn btn-outline-default waves-effect waves-themed" type="button">
                                <span wire:loading wire:target="searchStudent" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-search" class="fal fa-search" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name="student_id" wire:model="student_id">
                    @error('student_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label class="form-label">nivel <span class="text-danger">*</span></label>
                        <select class="custom-select form-control" wire:change="loadYears" wire:model.defer="level_id">
                            <option>{{ __('messages.to_select') }}</option>
                            @foreach ($levels as $level)
                            <option value="{{ $level->id }}">{{ $level->description }}</option>
                            @endforeach
                        </select>
                        @error('level_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.category') }} <span class="text-danger">*</span></label>
                        <select wire:change="loadCourses" class="custom-select form-control" wire:model.defer="year_id">
                            <option>{{ __('messages.to_select') }}</option>
                            @foreach ($years as $year)
                            <option value="{{ $year->id }}">{{ $year->description }}</option>
                            @endforeach
                        </select>
                        @error('year_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.course') }} <span class="text-danger">*</span></label>
                        <select class="custom-select form-control" id="course_id"  wire:model.defer="course_id">
                            <option>{{ __('messages.to_select') }}</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->description }}</option>
                            @endforeach
                        </select>
                        @error('course_id')
                        <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="package_id">@lang('messages.commitments') <span class="text-danger">*</span> </label>
                    <select wire:model="package_id" name="package_id" id="package_id" class="custom-select form-control">
                        <option>{{ __('messages.to_select') }}</option>
                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->description }}</option>
                        @endforeach
                    </select>
                    @error('package_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="date_register">@lang('messages.enrollment_date') <span class="text-danger">*</span> </label>
                    <div class="input-group" wire:ignore.self>
                        <input type="text" class="form-control date_register" wire:model.defer="date_register" onchange="this.dispatchEvent(new InputEvent('input'))">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-alt"></i>
                            </span>
                        </div>
                    </div>
                    @error('date_register')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="date_register">@lang('messages.representative') <span class="text-danger">*</span> </label>
                    <input type="text" class="form-control" name="representative_name" id="representative_name" disabled wire:model="representative_name">
                    <input type="hidden" class="form-control" wire:model.defer="representative_id" name="representative_id" id="representative_id">
                    @error('representative_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3">
                    <label class="form-label" for="date_register">@lang('messages.observation') </label>
                    <textarea class="form-control" wire:model.defer="observation"></textarea>
                </div>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="state" id="validationTooltipAgreement" value="1" wire:model="state">
                <label class="custom-control-label" for="validationTooltipAgreement">{{ __('messages.state') }}</label>
            </div>
            <button type="button" class="btn btn-primary ml-auto waves-effect waves-themed" wire:loading.attr="disabled" wire:click="store">
                <span wire:loading wire:target="store" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                <span>{{ __('messages.save') }}</span>
            </button>
        </div>
    </form>
    <script>
        window.addEventListener('response_cadastre_store', event => {
            swalAlert("{{ __('messages.congratulations') }}",event.detail.message);
        });
        window.addEventListener('response_fail_search_student', event => {
            swalAlert('',event.detail.message);
        });
        window.addEventListener('response_fail_search_document', event => {
            swalAlert('',event.detail.message);
        });
        function swalAlert(title,msg){
            Swal.fire(title, msg, "info");
        }
        function printPDF(format,external_id){
            window.open(`../../print/document/`+external_id+`/`+format, '_blank');
        }
    </script>
</div>
