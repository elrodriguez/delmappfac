<div>
    <div id="panel-4" class="panel panel-sortable" role="widget" data-panel-attstyle="">
        <div class="panel-hdr  " role="heading">
            <h2 class="ui-sortable-handle">
                {{ __('messages.list') }} <span class="fw-300"><i>{{ __('messages.students') }}</i></span>
            </h2>
            <div class="panel-toolbar">
                <select class="custom-select custom-select-sm" id="course_topic_id" name="course_topic_id" wire:model="course_topic_id">
                    <option selected="" value="">{{ __('messages.to_select') }}</option>
                    @foreach ($course_topics as $course_topic)
                        <option value="{{ $course_topic->id }}">{{ $course_topic->title }}</option>
                    @endforeach
                </select>
                @error('course_topic_id') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
            </div>
            <div class="panel-saving mr-2" style="display: none;">
                <i class="fal fa-spinner-third fa-spin-4x fs-xl"></i>
            </div>
            <div class="panel-toolbar" role="menu">
                <a href="#" class="btn btn-panel hover-effect-dot js-panel-collapse waves-effect waves-themed" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></a>
                <a href="#" class="btn btn-panel hover-effect-dot js-panel-fullscreen waves-effect waves-themed" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></a>
                <a href="#" class="btn btn-panel hover-effect-dot js-panel-close waves-effect waves-themed" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></a>
            </div>
        </div>
        <div class="panel-container show" role="content">
            <div class="loader">
                <i class="fal fa-spinner-third fa-spin-4x fs-xxl"></i>
            </div>
            <div class="panel-content p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered m-0">
                        <thead class="">
                            <tr>
                                <th rowspan="2" class="text-center align-middle" style="width: 40px">#</th>
                                <th rowspan="2" class="text-center align-middle" style="width: 50px">Foto</th>
                                <th rowspan="2" class="text-center align-middle">{{ __('messages.name') }}</th>
                                <th colspan="2" class="text-center">C01</th>
                                <th colspan="2" class="text-center">C02</th>
                                <th colspan="2" class="text-center">C03</th>
                                <th colspan="2" class="text-center">C04</th>
                            </tr>
                            <tr>
                                <th class="text-center align-middle">NL</th>
                                <th class="text-center align-middle">Conclusión descriptiva</th>
                                <th class="text-center align-middle">NL</th>
                                <th class="text-center align-middle">Conclusión descriptiva</th>
                                <th class="text-center align-middle">NL</th>
                                <th class="text-center align-middle">Conclusión descriptiva</th>
                                <th class="text-center align-middle">NL</th>
                                <th class="text-center align-middle">Conclusión descriptiva</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($students)>0)
                                @foreach ($students as $c => $student)
                                <tr>
                                    <td class="text-center align-middle" style="width: 40px">{{ $c + 1 }}</td>
                                    <td class="text-center align-middle" style="width: 50px">
                                        @if ($student->profile_photo_path)
                                        <img src="{{ asset('storage/'.$student->profile_photo_path) }}" style="width: 40px" class="rounded" alt="{{ $student->trade_name }}">
                                        @else
                                        <img src="{{ ui_avatars_url($student->trade_name,40,'none',false) }}" class="rounded" alt="{{ $student->trade_name }}">
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $student->trade_name }}</td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle"></td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
