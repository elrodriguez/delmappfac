<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>{{ __('messages.list') }}</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content p-0">
                <div class="card mb-g border-0 shadow-0">
                    <div class="card-header p-0">
                        <div class="row no-gutters row-grid align-items-stretch">
                            <div class="col-12 col-md">
                                <div class="text-uppercase text-muted py-2 px-3">{{ __('messages.description') }}</div>
                            </div>
                            <div class="col-sm-6 col-md-1 col-xl-1 hidden-md-down">
                                <div class="text-uppercase text-muted py-2 px-3">Nota</div>
                            </div>
                            <div class="col-sm-6 col-md-3 col-xl-1 hidden-md-down">
                                <div class="text-uppercase text-muted py-2 px-3">Ver Examen</div>
                            </div>
                            <div class="col-sm-6 col-md-3 hidden-md-down">
                                <div class="text-uppercase text-muted py-2 px-3">{{ __('messages.student') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="row no-gutters row-grid">
                            @foreach ($students as $student)
                            <div class="col-12">
                                <div class="row no-gutters row-grid align-items-stretch">
                                    <div class="col-md">
                                        <div class="p-3">
                                            @if($student->id)
                                                <p>{{ $student->description }}</p>
                                                @switch($student->state)
                                                    @case('aprobado')
                                                        <span class="badge badge-info">Aprobado</span>
                                                        @break
                                                    @case('desaprobado')
                                                        <span class="badge badge-success">Desaprobado</span>
                                                        @break
                                                    @case('ausente')
                                                        <span class="badge badge-primary">Ausente</span>
                                                        @break
                                                @endswitch
                                            @else
                                            <p>Un no responde</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-1 hidden-md-down align-middle">
                                        @if($student->id)
                                            @if($student->state != 'ausente')
                                                <div class="p-3 p-md-3 text-center" wire:ignore>
                                                    <a href="#" class="testnoteedit" id="testnoteedit{{ $student->id }}" data-type="text" data-pk="{{ $student->id }}" data-title="Calificación">{{ $student->score }}</a>
                                                </div>
                                            @else
                                                <div class="p-3 p-md-3 text-center" wire:ignore>
                                                    <span class="text-danger">{{ $student->score }}</span>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-6 col-md-3 col-xl-1 hidden-md-down">
                                        @if($student->id)
                                            @if($student->state != 'ausente')
                                                <div class="p-3 p-md-3">
                                                    <button onclick="openModalExamen('{{ $student->trade_name }}','{{ $student->person_id }}','{{ $student->activity_id }}')" type="button" class="btn btn-primary btn-pills waves-effect waves-themed">Ver</button>
                                                </div>
                                            @endif
                                        @elseif($student->state == 'ausente')

                                        @else
                                            <div class="p-3 p-md-3">
                                                <button wire:click="examenFail('{{ $student->activity_id }}','{{ $student->person_id }}')" type="button" class="btn btn-danger btn-pills waves-effect waves-themed">Marcar como falta</button>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-6 col-md-3 hidden-md-down">
                                        <div class="p-3 p-md-3">
                                            <div class="d-flex align-items-center">
                                                <div class="d-inline-block align-middle status status-success status-sm mr-2">
                                                    @if($student->avatar)
                                                    <span class="profile-image-md rounded-circle d-block" style="background-image:url('{{ asset('storage/'.$student->avatar) }}'); background-size: cover;"></span>
                                                    @else
                                                    <span class="profile-image-md rounded-circle d-block" style="background-image:url('{{ ui_avatars_url($student->trade_name,32,'none',false) }}'); background-size: cover;"></span>
                                                    @endif
                                                </div>
                                                <div class="flex-1 min-width-0">
                                                    <a href="javascript:void(0)" class="d-block text-truncate">{{ $student->trade_name }}</a>
                                                    <div class="text-muted small text-truncate">
                                                        @if($student->created_at)
                                                        {{ \Carbon\Carbon::parse($student->created_at)->diffForHumans() }}
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('subjects_courses_themes',[$course,$topic]) }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="exampleModalExamenVer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $student_names }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <ul class="list-unstyled">
                    @php
                        $question_id = null;
                    @endphp
                    @foreach ($exam as $question)
                        @if($question_id != $question->id)
                        <li class="border p-2 mb-2">
                            {!! $question->question_text !!}
                            <ul>
                                @foreach ($exam as $answer)
                                    @if($answer->id == $question->id)
                                        <li wire:ignore>
                                            @switch($answer->question_type)
                                                @case('radio')
                                                    {{ $answer->exam_answer_text }}
                                                    <span class="badge badge-success">{{ $answer->point }}</span>
                                                    @break
                                                @case('checkbox')
                                                    {{ $answer->exam_answer_text }}
                                                    <span class="badge badge-success">{{ $answer->point }}</span>
                                                    @break
                                                @case('text')
                                                    @if($answer->answer_text)
                                                        {{ $answer->answer_text }}
                                                        <br>
                                                        <a href="#" class="testanswernoteedit" id="testanswernoteedit{{ $answer->answer_id }}" data-type="text" data-pk="{{ $answer->answer_id }}" data-title="Calificación">{{ $answer->point }}</a>
                                                        <i class="fal fa-pencil-alt ml-3" onclick="activeEditPoint()" style="cursor: pointer"></i>
                                                    @else
                                                        No respondio
                                                    @endif
                                                    @break
                                                @case('file')
                                                    @if($answer->answer_text)
                                                        {{ $answer->answer_text }}
                                                        <br>
                                                        <a href="#" class="testanswernoteedit" id="testanswernoteedit{{ $answer->answer_id }}" data-type="text" data-pk="{{ $answer->answer_id }}" data-title="Calificación">{{ $answer->point }}</a>
                                                        <i class="fal fa-pencil-alt ml-3" onclick="activeEditPoint()" style="cursor: pointer"></i>
                                                        @else
                                                        No respondio
                                                    @endif
                                                    @break
                                            @endswitch
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        @php
                            $question_id = $question->id;
                        @endphp
                    @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModalExamen(name,person_id,activity_id){
            @this.examenShow(person_id,activity_id);
            @this.set('student_names',name);
            $('#exampleModalExamenVer').modal('show');
        }
        function studentListReload(){
            @this.studentList();
        }
    </script>
</div>
