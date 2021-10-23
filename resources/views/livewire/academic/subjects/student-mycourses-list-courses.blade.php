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
                        <div class="col-sm-4 col-xl-3">
                            <a href="{{ route('subjects_student_mycourse_themes',[$course->course_id,$course->cadastre_id]) }}">
                                <div class="p-3 bg-primary-300 rounded overflow-hidden position-relative text-white mb-g">
                                    <div class="">
                                        <h3 class="display-4 d-block l-h-n m-0 fw-500">
                                            {{ $course->description  }}
                                            <small class="m-0 l-h-n">{{ $course->year_description  }}</small>
                                        </h3>
                                        <h5><small class="m-0 l-h-n">DOCENTE: {{ $course->trade_name }}</small></h5>
                                    </div>
                                    <i class="fal fa-book position-absolute pos-right pos-bottom opacity-15 mb-n1 mr-n1" style="font-size:6rem"></i>
                                </div>
                            </a>
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
