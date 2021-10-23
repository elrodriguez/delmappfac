<div class="panel-container show">
    <form class="needs-validation {{ ($errors->any()?'was-validated':'') }}" novalidate wire:ignore.self wire:submit.prevent="store()">
        <div class="panel-content">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="level_id">@lang('messages.academic_level') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="level_id" name="level_id" required="" wire:model.defer="level_id">
                        <option>{{ __('messages.to_select') }}</option>
                        @foreach ($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->description }}</option>
                        @endforeach
                    </select>
                    @error('level_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="year_id">@lang('messages.academic_year') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="year_id" name="year_id" required="" wire:model.defer="year_id">
                        <option>{{ __('messages.to_select') }}</option>
                        @foreach ($years as $year)
                        <option value="{{ $year->id }}">{{ $year->description }}</option>
                        @endforeach
                    </select>
                    @error('year_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="section_id">@lang('messages.academic_section') <span class="text-danger">*</span> </label>
                    <select class="custom-select form-control" id="section_id" name="section_id" required="" wire:model.defer="section_id">
                        <option>{{ __('messages.to_select') }}</option>
                        @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->description }}</option>
                        @endforeach
                    </select>
                    @error('section_id')
                    <div class="invalid-feedback-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto waves-effect waves-themed"><i class="fal fa-check mr-1"></i>@lang('messages.add')</button>
                </div>
            </div>
            <table class="table table-bordered m-0">
                <thead class="bg-info-900">
                    <tr>
                        <th class="text-center">#</th>
                        <th>{{ __('messages.academic_level') }}</th>
                        <th class="text-center">{{ __('messages.academic_year') }}</th>
                        <th class="text-center">{{ __('messages.academic_section') }}</th>
                        <th class="text-center">{{ __('messages.creation_date') }}</th>
                        <th class="text-center">{{ __('messages.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($academic_charges)>0)
                        @foreach ($academic_charges as $key => $academic_charge)
                        <tr>
                            <th scope="row" class="text-center">{{ $key + 1 }}</th>
                            <td>{{ $academic_charge->academic_level_description }}</td>
                            <td class="text-center">{{ $academic_charge->academic_year_description }}</td>
                            <td class="text-center">{{ $academic_charge->academic_section_description }}</td>
                            <td class="text-center">{{ $academic_charge->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <button class="btn btn-default btn-sm btn-icon rounded-circle waves-effect waves-themed" wire:click="removeAssignment('{{ $academic_charge->id }}')" type="button">
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
        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
            <a href="{{ route('academic_courses') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
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
