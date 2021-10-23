<div>
    @php
        $level = null;
    @endphp
    @foreach ($courses as $item)
        @if ($level != $item->level_id)
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>{{ $item->level_description }}</h2>
                <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                </div>
            </div>
            <div class="panel-container show">
				<div class="panel-content">
                    <div class="row">
					@foreach ($courses as $course)
                        @if($item->level_id = $course->level_id )
                        <div class="col-4 mb-3">
                            <div class="card border m-auto m-lg-0">
                                <div class="card-header bg-info-600">
                                    {{ $course->year_description  }}. "{{ $course->section_description  }}" {{ $course->description  }}
                                </div>
                                <div class="card-body p-0 bg-info-300">
                                    <div class="list-group list-group-flush">
                                        <a href="{{ route('subjects_courses_themes',[$course->id,$course->teacher_course_id]) }}" class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-primary">{{ __('messages.content_course') }}</span>
                                            <span class="badge border border-primary text-primary"><i class="fal fa-arrow-right"></i></span>
                                        </a>
                                        <!--a href="{{ route('subjects_courses_students',[$course->id,$course->teacher_course_id]) }}" class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-primary">{{ __('messages.notes') }}</span>
                                            <span class="badge border border-primary text-primary"><i class="fal fa-arrow-right"></i></span>
                                        </a>
                                        <a href="{{ route('subjects_courses_students',[$course->id,$course->teacher_course_id]) }}" class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="text-primary">{{ __('messages.assistance') }}</span>
                                            <span class="badge border border-primary text-primary"><i class="fal fa-arrow-right"></i></span>
                                        </a-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    </div>
				</div>
			</div>
        </div>
        @endif
        @php
            $level = $item->level_id;
        @endphp
    @endforeach

</div>
