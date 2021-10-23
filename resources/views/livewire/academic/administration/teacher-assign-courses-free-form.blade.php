<div class="panel-container show">
    <form  class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="level_id">@lang('messages.level') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="level_id" name="level_id" required="" wire:model.defer="level_id" wire:change="loadYear">
                        <option>{{ __('messages.to_select') }}</option>
                        @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->description }}</option>
                        @endforeach
                    </select>
                    @error('level_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label" for="year_id">@lang('messages.category') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="year_id" name="year_id" required="" wire:model.defer="year_id" wire:change="listCourses">
                        <option>{{ __('messages.to_select') }}</option>
                        @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->description }}</option>
                        @endforeach
                    </select>
                    @error('year_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label" for="course_id">@lang('messages.courses') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control"  name="course_id" required="" wire:model.defer="course_id">
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
            <div class="form-row">
                <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.add')</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered m-0" >
                    <thead class="bg-info-900">
                        <tr>
                            <th class="text-center">#</th>
                            <th>{{ __('messages.level') }}</th>
                            <th class="text-center">{{ __('messages.category') }}</th>
                            <th>{{ __('messages.course') }}</th>
                            <th class="text-center">{{ __('messages.creation_date') }}</th>
                            <th class="text-center">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($assignments)>0)
                            @foreach ($assignments as $key => $assignment)
                            <tr>
                                <th scope="row" class="text-center">{{ $key + 1 }}</th>
                                <td>{{ $assignment->academic_level_description }}</td>
                                <td class="text-center">{{ $assignment->academic_year_description }}</td>
                                <td>{{ $assignment->course_description }}</td>
                                <td class="text-center">{{ $assignment->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-default btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="removeAssignment('{{ $assignment->id }}')" type="button">
                                        <i class="fal fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @else
                        <tr class="odd">
                            <td colspan="7" class="dataTables_empty text-center" valign="top">{{ __('messages.no_data_available_in_the_table') }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('academic_teachers') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
        </div>
    </form>
    <script>
        window.addEventListener('response_success_courses', event => {
            swalAlertSuccess(event.detail.message);
        });
        function swalAlertSuccess(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "info");
        }
    </script>
</div>
