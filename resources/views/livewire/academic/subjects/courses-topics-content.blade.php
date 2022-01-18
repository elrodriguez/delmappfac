<div>
    <div class="alert alert-primary alert-dismissible d-flex flex-row align-items-center">
        <a href="{{ route('subjects_courses_teacher') }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
        <button type="button" class="btn btn-primary waves-effect waves-themed ml-auto" data-toggle="modal" data-target="#exampleModaltheme">{{ __('messages.new_theme') }}</button>
    </div>
    @if(count($course_topics)>0)
        @php
            $total = count($course_topics);
            $c = 1;
        @endphp
        @foreach ($course_topics as $key => $course_topic)
            <div id="panel-{{ $course_topic['id'] }}" class="panel">
                <div class="panel-hdr">
                    <h2><span class="fw-300 mr-3">Numero: <i>{{ $course_topic['number'] }}</i></span><a href="#" class="xeditabletitle text-muted" id="h1{{ $course_topic['id'] }}en" name="h1{{ $course_topic['id'] }}en" data-type="text" data-pk="{{ $course_topic['id'] }}" data-title="{{ __('messages.themes_course_title') }}">{{ $course_topic['title'] }}</a></h2>
                    <div class="panel-toolbar" wire:ignore.self>
                        @if($c > 1)
                        <button wire:click="changenumber('1','{{ $course_topic['id'] }}','{{ $c }}','{{ $key }}')" class="btn btn-sm btn-outline-secondary mr-1 shadow-0 waves-effect waves-themed">
                            <i class="fal fa-arrow-alt-up"></i>
                        </button>
                        @endif
                        @if($total > $c)
                        <button wire:click="changenumber('0','{{ $course_topic['id'] }}','{{ $c }}','{{ $key }}')" class="btn btn-sm btn-outline-secondary mr-1 shadow-0 waves-effect waves-themed">
                            <i class="fal fa-arrow-alt-down"></i>
                        </button>
                        @endif
                        <button onclick="ondeleteTopic('{{ $course_topic['id'] }}')" class="btn btn-sm btn-outline-secondary mr-1 shadow-0 waves-effect waves-themed">
                            <i class="fal fa-trash-alt"></i>
                        </button>
                        <button onclick="openModalClass('{{ $course_topic['id'] }}')" class="btn btn-sm btn-secondary mr-1 shadow-0 waves-effect waves-themed">
                            <i class="fal fa-plus mr-1"></i>{{ __('messages.create_class') }}
                        </button>
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
                                    <div class="col d-flex">
                                        <a href="javascript:void(0);" class="btn btn-sm btn-outline-secondary mr-1 ml-auto shadow-0 waves-effect waves-themed"><i class="fal fa-pencil-alt"></i></a>
                                        <a href="javascript:void(0);" onclick="ondeleteClasss('{{ $topic_classe->id }}')" class="btn btn-sm btn-outline-secondary mr-1 shadow-0 waves-effect waves-themed"><i class="fal fa-trash-alt"></i></a>
                                        <a href="javascript:void(0);" onclick="openModalActivityCreate('{{ $topic_classe->id }}')" class="btn btn-sm btn-secondary mr-1 shadow-0 waves-effect waves-themed">{{ __('messages.create_activity') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if ($topic_classe->class_activities)
                                    <ul class="list-group list-group-flush">
                                    @foreach ($topic_classe->class_activities as $class_activitie)
                                        <li class="list-group-item">
                                        @switch($class_activitie->academic_type_activitie_id)
                                            @case(1)
                                                <h3 class="mb-g">{{ $class_activitie->description }}<a href="{{ route('subjects_courses_topic_activity_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2"><i class="fal fa-pencil-alt"></i></a><a href="javascript:void(0)" wire:click="deleteActivity('{{ $class_activitie->id }}')"><i class="fal fa-trash-alt ml-2"></i></a></h3>
                                                <div>{!! htmlspecialchars_decode($class_activitie->body, ENT_QUOTES) !!}</div>
                                                @break
                                            @case(2)
                                                <p class="fs-lg">
                                                    <a href="javascript:void(0)" class="fw-500 fs-xl"><i class="fal fa-comment-lines"></i> {{ $class_activitie->description }}</a>
                                                    <a href="{{ route('subjects_courses_topic_forum_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2"><i class="fal fa-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)" wire:click="deleteActivity('{{ $class_activitie->id }}')"><i class="fal fa-trash-alt ml-2"></i></a>
                                                </p>
                                                @break
                                            @case(3)
                                                <p class="fs-lg">
                                                    <a href="javascript:void(0)" class="fw-500 fs-xl"><i class="fal fa-clipboard-list-check"></i> {{ $class_activitie->description }}</a>
                                                    <a href="{{ route('subjects_courses_topic_test',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2"><i class="fal fa-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)" wire:click="deleteActivity('{{ $class_activitie->id }}')"><i class="fal fa-trash-alt ml-2"></i></a>
                                                    <a href="{{ route('subjects_courses_activity_test_correct',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2" title="Corregir exámenes"><i class="fal fa-clipboard-user"></i></a>
                                                </p>
                                                @break
                                            @case(4)
                                                <p class="fs-lg">
                                                    <a href="javascript:void(0)" class="fw-500 fs-xl"><i class="fal fa-comment-alt-smile"></i> {{ $class_activitie->description }}</a>
                                                    <a href="{{ route('subjects_courses_topic_question_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2"><i class="fal fa-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)" wire:click="deleteActivity('{{ $class_activitie->id }}')"><i class="fal fa-trash-alt ml-2"></i></a>
                                                </p>
                                                @break
                                            @case(5)
                                                <p class="fs-lg">
                                                    <a href="javascript:void(0)" class="fw-500 fs-xl"><i class="fal fa-drafting-compass"></i> {{ $class_activitie->description }}</a>
                                                    <a href="{{ route('subjects_courses_topic_homework_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2"><i class="fal fa-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)" wire:click="deleteActivity('{{ $class_activitie->id }}')"><i class="fal fa-trash-alt ml-2"></i></a>
                                                </p>
                                                @break
                                            @case(6)
                                                <p class="fs-lg">
                                                    <a href="{{ route('subjects_courses_topic_video_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="fw-500 fs-xl" data-toggle="tooltip" data-placement="right" title="" data-original-title="Agregar o Editar Video"><i class="fal fa-video-plus"></i> {{ $class_activitie->description }}</a>
                                                    <a href="{{ route('subjects_courses_topic_video_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2" data-toggle="tooltip" data-placement="right" title="" data-original-title="Agregar o Editar Video"><i class="fal fa-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)" wire:click="deleteActivity('{{ $class_activitie->id }}')" data-toggle="tooltip" data-placement="right" title="" data-original-title="Eliminar"><i class="fal fa-trash-alt ml-2"></i></a>
                                                </p>
                                                <div class="video-responsive">
                                                    @if($class_activitie->file)
                                                    {!! $class_activitie->file['body']['embed']['html'] !!}
                                                    @endif
                                                </div>
                                                @break
                                            @case(7)
                                                <p class="fs-lg">
                                                    <a href="{{ route('subjects_courses_topic_file_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="fw-500 fs-xl" data-toggle="tooltip" data-placement="right" title="" data-original-title="Agregar o Archivo"><i class="fal fa-file-upload"></i> {{ $class_activitie->description }}</a>
                                                    <a href="{{ route('subjects_courses_topic_file_edit',[$course_topic['course_id'],$teacher_course_id,$class_activitie->id]) }}" class="ml-2" data-toggle="tooltip" data-placement="right" title="" data-original-title="Agregar o Archivo"><i class="fal fa-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)" wire:click="deleteActivity('{{ $class_activitie->id }}')" data-toggle="tooltip" data-placement="right" title="" data-original-title="Eliminar"><i class="fal fa-trash-alt ml-2"></i></a>
                                                </p>
                                                <div id="icon-list" class="row js-list-filter">
                                                    <div class="col-4 col-sm-3 col-md-3 col-lg-2 col-xl-1 d-flex justify-content-center align-items-center mb-g">                                            
                                                        <a href="{{ route('academic_subjects_student_file_dropbox_download',$class_activitie->id) }}" class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100 js-showcase-icon shadow-hover-2" data-toggle="tooltip" data-placement="right" data-original-title="{{ $class_activitie->name_file }}">
                                                            <div class="rounded-top color-fusion-300 w-100 bg-primary-300"> 
                                                                <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x hover-bg"> 
                                                                    @if($class_activitie->extension == 'pdf')
                                                                    <i class="fas fa-file-pdf"></i> 
                                                                    @elseif($class_activitie->extension == 'docx')
                                                                    <i class="fas fa-file-word"></i>
                                                                    @elseif($class_activitie->extension == 'xlsx')
                                                                    <i class="fas fa-file-excel"></i>
                                                                    @elseif($class_activitie->extension == 'pptx')
                                                                    <i class="fas fa-file-powerpoint"></i> 
                                                                    @else
                                                                    <i class="fas fa-file-download"></i> 
                                                                    @endif                                                   
                                                                </div>                                                
                                                            </div>                                                
                                                            <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">                                                    
                                                                <span class="d-block text-truncate text-muted">{{ $class_activitie->name_file }}</span>
                                                            </div>                                            
                                                        </a>                                        
                                                    </div>
                                                </div>
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
    <div wire:ignore.self class="modal fade" id="exampleModaltheme" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.new') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('messages.themes_course_title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="title" wire:model.defer="title">
                        @error('title')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="store()">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModalthemeClass" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.create_class') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ __('messages.themes_course_title') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="class_title" wire:model.defer="class_title">
                        @error('class_title')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group" style="display: none">
                        <label>{{ __('messages.date_start') }} / {{ __('messages.date_end') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Select date" id="datepicker-2">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-row" style="display: none">
                        <div class="col mb-3">
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.time_start') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fal fa-alarm-clock text-align-center"></i></span>
                                    </div>
                                    <input id="time-start" wire:model.defer="class_time_start" name="class_time_start" type="text" data-inputmask="'alias': 'time2'" class="form-control" im-insert="true">
                                    <select wire:model.defer="class_start_type" name="class_start_type" class="custom-select form-control">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                                <span class="help-block">99:99</span>
                            </div>
                        </div>
                        <div class="col mb-3">
                            <div class="form-group">
                                <label class="form-label">{{ __('messages.time_end') }}</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fal fa-alarm-clock text-align-center"></i></span>
                                    </div>
                                    <input id="time-end" wire:model.defer="class_time_end" name="class_time_end" type="text" data-inputmask="'alias': 'time2'" class="form-control" im-insert="true">
                                    <select wire:model.defer="class_end_type" name="class_end_type" class="custom-select form-control">
                                        <option value="AM">AM</option>
                                        <option value="PM">PM</option>
                                    </select>
                                </div>
                                <span class="help-block">99:99</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button wire:click="classStore" type="button" class="btn btn-primary">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModalActivityCreate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >{{ __('messages.create_activity') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" >{{ __('messages.description') }}</label>
                        <input wire:model.defer="activity_title" name="activity_title" type="text" class="form-control">
                        @error('activity_title')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{ __('messages.type') }}</label>
                        <select wire:model.defer="activity_type_id" name="activity_type_id" class="custom-select form-control" id="activity_type">
                            <option value="">{{ __('messages.to_select') }}</option>
                            @foreach ($activity_types as $activity_type)
                            <option value="{{ $activity_type->id }}">{{ $activity_type->description }}</option>
                            @endforeach
                        </select>
                        @error('activity_type_id')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button wire:click="activityStore" type="button" class="btn btn-primary">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModalActivityCreate(class_id){
            @this.set('class_id', class_id);
            $('#exampleModalActivityCreate').modal('show');
        }
        function openModalClass(topic_id){
            @this.set('topic_id', topic_id);
            $("#time-start").inputmask();
            $("#time-end").inputmask();
            $('#datepicker-2').daterangepicker(
                {
                    opens: 'left'
                }, function(start, end, label)
                {
                    @this.set('class_date_start', start.format('YYYY-MM-DD'));
                    @this.set('class_date_end', end.format('YYYY-MM-DD'));
                }
            );
            $('#exampleModalthemeClass').modal('show');
        }
        window.addEventListener('response_course_topic_class_store', event => {
            closeModalClass();
            swalAlert(event.detail.message);
        });
        window.addEventListener('response_course_topic_class_activity_store', event => {
            closeModalActivity();
            swalAlert(event.detail.message);
        });
        window.addEventListener('response_success_delete_topics', event => {
            swalAlertError(event.detail.message);
        });
        window.addEventListener('response_course_topic_store', event => {
            closeModalTopic();
           swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function swalAlertError(msg){
            Swal.fire("{{ __('messages.impossible_continue') }}", msg, "error");
        }
        function closeModalTopic(){
            $('#exampleModaltheme').modal('hide');
        }
        function closeModalClass(){
            $('#exampleModalthemeClass').modal('hide');
        }
        function closeModalActivity(){
            $('#exampleModalActivityCreate').modal('hide');
        }
       
    </script>
</div>
