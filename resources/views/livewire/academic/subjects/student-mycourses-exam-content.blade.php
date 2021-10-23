<div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                {{ $exam->description }} <span class="fw-300"><i>{{ $exam->duration }}</i></span>
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">

                @if($exam->date_start && $exam->date_end)
                    @php
                        $date_now = strtotime(date('Y-m-d'));
                        $date_time_now = strtotime(date('Y-m-d H:i:s'));
                    @endphp
                    @if(strtotime($exam->date_start)<=$date_now && strtotime($exam->date_end) >= $date_now)

                        @if($student_test)

                            @if(strtotime($start)>=$date_time_now)
                                @if($student_test->state == null)
                                    <div class="panel-tag">
                                        {{ $start }}
                                    </div>
                                    @foreach ($questions as $key => $question)
                                        <div class="p-3 border bg-light mb-3">
                                            {!! $question['question_text'] !!}
                                            @switch($question['question_type'])
                                                @case('radio')
                                                    <div class="demo">
                                                        @foreach ($question['answers'] as $answer)
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" class="custom-control-input" id="r{{ $answer['id'] }}" name="questions[{{ $key }}].replied" wire:model.defer="questions.{{ $key }}.replied" value="{{ $answer['id'] }}">
                                                                <label class="custom-control-label" for="r{{ $answer['id'] }}">{{ $answer['answer_text'] }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @break
                                                @case('checkbox')
                                                    @foreach ($question['answers'] as $answer)
                                                        <div class="custom-control custom-checkbox mb-3">
                                                            <input type="checkbox" class="custom-control-input" id="c{{ $answer['id'] }}" name="questions[{{ $key }}].replied" wire:model.defer="questions.{{ $key }}.replied" value="{{ $answer['id'] }}">
                                                            <label class="custom-control-label" for="c{{ $answer['id'] }}">{{ $answer['answer_text'] }}</label>
                                                        </div>
                                                    @endforeach
                                                    <footer class="blockquote-footer">Una respuesta incorrecta <cite title="Source Title">le disminuye puntos</cite></footer>
                                                    @break
                                                @case('text')
                                                    <div class="form-group">
                                                        <label class="form-label" for="example-textarea">Responder</label>
                                                        <textarea class="form-control" id="example-textarea" rows="5" name="questions[{{ $key }}].replied" wire:model.defer="questions.{{ $key }}.replied"></textarea>
                                                    </div>
                                                    <footer class="blockquote-footer">El docente tiene que revisar esta <cite title="Source Title">respuesta</cite></footer>
                                                    @break
                                                @case('file')
                                                    <div class="form-group">
                                                        <label class="form-label" for="example-textarea">Subir Archivo</label>
                                                        <input type="file" name="questions[{{ $key }}].replied" wire:model.defer="questions.{{ $key }}.replied">
                                                    </div>
                                                    <footer class="blockquote-footer">El docente tiene que revisar esta <cite title="Source Title">respuesta</cite></footer>
                                                    @break
                                                @default

                                            @endswitch
                                        </div>
                                    @endforeach
                                    <button wire:click="storeExamStudent" wire:loading.attr="disabled" type="button" class="btn btn-primary waves-effect waves-themed">
                                        <span wire:loading wire:target="storeExamStudent" wire:loading.class="spinner-border spinner-border-sm" wire:loading.class.remove="fal fa-check" class="fal fa-check mr-2" role="status" aria-hidden="true"></span>
                                        <span>Guardar y Terminar</span>
                                    </button>
                                @else
                                    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                                        <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                            <div class="toast-header">
                                                <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                                <strong class="mr-auto">Examen Terminado</strong>
                                            </div>
                                            <div class="toast-body text-center">
                                                Su puntuación es de: {{ $total }}
                                                <p>Cuando el docente corrija las preguntas para responder puede que suba su puntuación</p>
                                                <a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}" class="btn btn-primary mt-2"><i class="fal fa-long-arrow-left mr-2"></i>Volver al curso</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else

                                <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                                    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                        <div class="toast-header">
                                            <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                            <strong class="mr-auto">Tiempo terminado</strong>
                                            <small>{{ \Carbon\Carbon::parse($start)->diffForHumans()  }}</small>
                                        </div>
                                        <div class="toast-body text-center">
                                            Ya no puede continuar con el examen
                                            <a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}" class="btn btn-primary mt-2"><i class="fal fa-long-arrow-left mr-2"></i>Volver al curso</a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @else
                            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                                <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                    <div class="toast-header">
                                        <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                        <strong class="mr-auto">Confirmar</strong>
                                    </div>
                                    <div class="toast-body text-center">
                                        ¿Esta seguro de comenzar el examen?
                                        <button wire:click="startExamStudent" wire:loading.attr="disabled" class="btn btn-primary mt-2">Continuar<i class="fal fa-long-arrow-right ml-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        @if($exam->score)
                        <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                <div class="toast-header">
                                    <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                    <strong class="mr-auto">Tiempo terminado</strong>
                                    <small>{{ \Carbon\Carbon::parse($exam->date_end)->diffForHumans()  }}</small>
                                </div>
                                <div class="toast-body text-center">
                                    <span>Estubo disponible desde {{ \Carbon\Carbon::parse($exam->date_start)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($exam->date_end)->format('d/m/Y') }}</span>
                                    <p>Su nota es: {{ $exam->score }}</p>
                                    <a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}" class="btn btn-primary mt-2"><i class="fal fa-long-arrow-left mr-2"></i>Volver al curso</a>
                                </div>
                            </div>
                        </div>
                        @else
                        <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                <div class="toast-header">
                                    <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                    <strong class="mr-auto">Comienza</strong>
                                    <small>{{ \Carbon\Carbon::parse($exam->date_start)->diffForHumans()  }}</small>
                                </div>
                                <div class="toast-body text-center">
                                    <span>Estara disponible desde {{ \Carbon\Carbon::parse($exam->date_start)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($exam->date_end)->format('d/m/Y') }}</span>
                                    <p>Aún no puede dar el examen</p>
                                    <a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}" class="btn btn-primary mt-2"><i class="fal fa-long-arrow-left mr-2"></i>Volver al curso</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                @else
                    <div class="alert alert-primary" role="alert">
                        <strong>¡Aviso!</strong> El examen aun no esta disponible.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
