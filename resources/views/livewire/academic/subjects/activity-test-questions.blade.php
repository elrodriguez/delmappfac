<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>{{ __('messages.edit') }}</h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">{{ __('messages.description') }} <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="description" wire:model="description">
                    </div>
                    <div class="col-4 mb-3" wire:ignore>
                        <label class="form-label">Disponible desde - Hasta <span class="text-danger">*</span></label>
                        <div class="input-group" wire:ignore>
                            <input required="" type="text" class="form-control" value="{{ $dates }}" id="datepicker-7">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-alt"></i>
                                </span>
                            </div>
                        </div>
                        @error('date_start')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-3 mb-3" wire:ignore>
                        <label class="form-label" for="addon-wrapping-right">Duración</label>
                        <div class="input-group flex-nowrap">
                            <input id="duration" wire:model.defer="duration" name="duration" type="text" data-inputmask="'mask': '99:99:99'" onblur="maskValue()" class="form-control" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fal fa-alarm-clock"></i></span>
                            </div>
                        </div>
                        @error('duration')
                            <div class="invalid-feedback-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="card mb-g border shadow-0">
                            <div class="card-header">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <span class="h6 font-weight-bold text-uppercase">{{ __('messages.questions') }}</span>
                                    </div>
                                    <div class="col d-flex">
                                        <a href="{{ route('subjects_courses_topic_test_question',[$course,$topic,$activity,null]) }}" class="btn btn-outline-danger ml-auto btn-sm flex-shrink-0 waves-effect waves-themed">{{ __('messages.new_question') }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-header p-0">
                                <div class="row no-gutters row-grid align-items-stretch">
                                    <div class="col-12 col-md">
                                        <div class="text-uppercase text-muted py-2 px-3">{{ __('messages.description') }}</div>
                                    </div>
                                    <div class="col-sm-8 col-md-4 hidden-md-down">
                                        <div class="text-uppercase text-muted py-2 px-3">{{ __('messages.answers') }}</div>
                                    </div>
                                    <div class="col-sm-4 col-md-3 col-xl-1 hidden-md-down">
                                        <div class="text-uppercase text-muted py-2 px-3">{{ __('messages.points') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="row no-gutters row-grid">
                                    @if(count($questions)>0)
                                        @foreach ($questions as $i => $question)
                                        <div class="col-12">
                                            <div class="row no-gutters row-grid align-items-stretch">
                                                <div class="col-md">
                                                    <div class="p-3">
                                                        <div class="d-flex">
                                                            <span class="icon-stack display-4 mr-3 flex-shrink-0">
                                                                @if($question['question_type'] == 'radio' || $question['question_type'] == 'checkbox')
                                                                    @if($question['question_type'] == 'checkbox')
                                                                    <button onclick="opemModaleAnswers('{{ $question['id'] }}')" data-toggle="tooltip" data-placement="auto" title="" data-original-title="Varias válidas" class="btn btn-success btn-icon rounded-circle waves-effect waves-themed">
                                                                        <i class="fal fa-check-square"></i>
                                                                    </button>
                                                                    @else
                                                                    <button onclick="opemModaleAnswers('{{ $question['id'] }}')" data-toggle="tooltip" data-placement="auto" title="" data-original-title="Una respuesta válida" class="btn btn-success btn-icon rounded-circle waves-effect waves-themed">
                                                                        <i class="fal fa-dot-circle"></i>
                                                                    </button>
                                                                    @endif
                                                                @endif
                                                            </span>
                                                            <div class="d-inline-flex flex-column">
                                                                <div class="fs-lg fw-500 d-block">
                                                                    {!! htmlspecialchars_decode($question['question_text'], ENT_QUOTES) !!}
                                                                </div>
                                                                <div class="d-block text-muted fs-sm">
                                                                    <a href="{{ route('subjects_courses_topic_test_question',[$course,$topic,$activity,$question['id']]) }}"><i class="fal fa-pencil-alt"></i></a>
                                                                    <a class="ml-3" href="javascript:void(0)" wire:click="deleteQuestion('{{ $question['id'] }}')"><i class="fal fa-trash-alt"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-8 col-md-4 hidden-md-down">
                                                    <div class="p-3 p-md-3">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-1 min-width-0">
                                                                @if($question['question_type'] == 'radio' || $question['question_type'] == 'checkbox')
                                                                    @if($question['answers'])
                                                                        @foreach ($question['answers'] as $c => $answer)
                                                                            @if($answer->correct)
                                                                                <i class="fal fa-check-square"></i>
                                                                            @else
                                                                                <i class="fal fa-times-square"></i>
                                                                            @endif
                                                                            <a href="#" class="xeditabletitleanswer" id="answer{{ $c }}" data-type="text" data-pk="{{ $answer->id }}" data-title="{{ __('messages.edit') }}">
                                                                                {{ $answer->answer_text }}
                                                                            </a>
                                                                            <a class="ml-3" href="javascript:void(0)" wire:click="deleteAnswers('{{ $answer->id }}')"><i class="fal fa-trash-alt"></i></a>
                                                                            <br>
                                                                        @endforeach
                                                                    @endif
                                                                @elseif($question['question_type'] == 'text')
                                                                    <textarea disabled placeholder="Respuesta del alumno"></textarea>
                                                                @elseif($question['question_type'] == 'file')
                                                                    <i class="fal fa-cloud-upload"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4 col-md-3 col-xl-1 hidden-md-down">
                                                    <div class="p-3 p-md-3">
                                                        <span class="d-block text-muted">{{ $question['points'] }} <i>Puntos</i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                <a href="{{ route('subjects_courses_themes',[$course,$topic]) }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
                <button type="button" class="btn btn-primary ml-auto waves-effect waves-themed" wire:click="update()">
                    <span wire:loading wire:target="update" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" wire:loading.attr="disabled" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                    <span>@lang('messages.to_update')</span>
                </button>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="exampleModalanswers" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.add_answers') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" >{{ __('messages.answer') }}</label>
                        <textarea class="form-control" name="question_text" wire:model="question_text"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label" >{{ __('messages.its_correct') }}</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="defaultChecked" name="correct" wire:model="correct" value="1">
                            <label class="custom-control-label" for="defaultChecked">{{ __('messages.yes') }}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
                    <button wire:click="answersStore" type="button" class="btn btn-primary">{{ __('messages.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function opemModaleAnswers(id){
            @this.set('class_activity_test_question_id',id);
            $('#exampleModalanswers').modal('show');
        }
        window.addEventListener('response_success_activity', event => {
            swalAlert(event.detail.message);
        });
        window.addEventListener('response_success_activity_test_answer_store', event => {
            $('#exampleModalanswers').modal('hide');
            swalAlert(event.detail.message);
        });
        function swalAlert(msg){
            Swal.fire("{{ __('messages.congratulations') }}", msg, "success");
        }
        function datesSelects(start,end){
            @this.set('date_start', start);
            @this.set('date_end', end);
        }
        function maskValue(){
            let dur = $('#duration').val();
            @this.set('duration',dur);
        }
    </script>
</div>
