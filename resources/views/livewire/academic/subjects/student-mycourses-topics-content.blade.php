<div>
    <div class="alert alert-primary alert-dismissible d-flex flex-row align-items-center">
        <a href="{{ route('subjects_student_my_courses') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
    </div>
    @if(count($course_topics)>0)
        @php
            $total = count($course_topics);
            $c = 1;
        @endphp
        @foreach ($course_topics as $key => $course_topic)
            <div id="panel-{{ $course_topic['id'] }}" class="panel">
                <div class="panel-hdr">
                    <h2><span class="fw-300 mr-3">Numero: <i>{{ $course_topic['number'] }}</i></span>{{ $course_topic['title'] }}</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        @if($course_topic['topic_classes'])
                        @foreach ($course_topic['topic_classes'] as $ct => $topic_classe)
                        <div class="card mb-g border shadow-0">
                            <div class="card-header">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <span class="h6 font-weight-bold text-uppercase">{{ $topic_classe->title }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if ($topic_classe->class_activities)
                                    <ul class="list-group list-group-flush">
                                    @foreach (json_decode($topic_classe->class_activities) as $class_activitie)
                                        <li class="list-group-item">
                                        @switch($class_activitie->academic_type_activitie_id)
                                            @case(1)
                                                <h3 class="mb-g">{{ $class_activitie->description }}</h3>
                                                <div>{!! htmlspecialchars_decode($class_activitie->body, ENT_QUOTES) !!}</div>
                                                @break
                                            @case(2)
                                                <p class="fs-lg">
                                                    <a href="{{ route('subjects_student_mycourse_themes_forum',[$course_id,$cadastre_id,myencrypt($class_activitie->id.'*'.auth()->user()->id)]) }}" class="fw-500 fs-xl"><i class="fal fa-comment-lines"></i> {{ $class_activitie->description }}</a>
                                                </p>
                                                @break
                                            @case(3)
                                                <p class="fs-lg">
                                                    <a href="{{ route('subjects_student_mycourse_themes_exam',[$course_id,$cadastre_id,myencrypt($class_activitie->id.'*'.auth()->user()->id)]) }}" class="fw-500 fs-xl"><i class="fal fa-clipboard-list-check"></i> {{ $class_activitie->description }}</a>
                                                </p>
                                                @break
                                            @case(4)
                                                <p class="fs-lg">
                                                    <a href="{{ route('subjects_student_mycourse_themes_question',[$course_id,$cadastre_id,myencrypt($class_activitie->id.'*'.auth()->user()->id)]) }}" class="fw-500 fs-xl"><i class="fal fa-comment-alt-smile"></i> {{ $class_activitie->description }}</a>
                                                </p>
                                                @break
                                            @case(5)
                                                <p class="fs-lg">
                                                    <a href="{{ route('subjects_student_mycourse_themes_homework',[$course_id,$cadastre_id,myencrypt($class_activitie->id.'*'.auth()->user()->id)]) }}" class="fw-500 fs-xl"><i class="fal fa-drafting-compass"></i> {{ $class_activitie->description }}</a>
                                                </p>
                                                @break
                                            @default
                                        @endswitch
                                        </li>
                                    @endforeach
                                    </ul>
                                @else
                                <div class="alert alert-info m-5 text-center" role="alert">
                                    <strong>¡</strong> {{ __('messages.there_are_no_activities') }} <strong>!</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @php
                $c++;
            @endphp
        @endforeach
    @endif
    <script>

    </script>
</div>
