<div>
    <div class="card mb-g">
        <div class="card-body pb-0 px-4" wire:ignore>
            <div class="d-flex flex-row pb-3 pt-2  border-top-0 border-left-0 border-right-0">
                <div class="d-inline-block align-middle status status-success mr-3">
                    @if($activity->profile_photo_path)
                    <span class="profile-image rounded-circle d-block" style="background-image:url('{{ asset('storage/'.$activity->profile_photo_path) }}'); background-size: cover;"></span>
                    @else
                    <span class="profile-image rounded-circle d-block" style="background-image:url('{{ ui_avatars_url($activity->name,60,'none',false) }}'); background-size: cover;"></span>
                    @endif
                </div>
                <h5 class="mb-0 flex-1 text-dark fw-500">
                    {{ $activity->name }}
                    <small class="m-0 l-h-n">
                        {{ $activity->email }}
                    </small>
                </h5>
                <span class="text-muted fs-xs opacity-70">
                    {{ \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}
                </span>
            </div>
            <div class="pb-3 pt-2 border-top-0 border-left-0 border-right-0 text-muted">
                {!! htmlspecialchars_decode($activity->body, ENT_QUOTES) !!}
            </div>
        </div>
    </div>
    <div id="panel-1" class="panel">
        <div class="panel-hdr">
            <h2>
                {{ $activity->description }}
            </h2>
            <div class="panel-toolbar">
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
            </div>
        </div>
        <div class="panel-container show">
            <div class="panel-content">
                @php
                    $date_now = strtotime(date('Y-m-d'));
                    $date_time_now = strtotime(date('Y-m-d H:i:s'));
                @endphp
                @if(strtotime($activity->date_start)<=$date_now && strtotime($activity->date_end) >= $date_now)

                    <div class="form-group">
                        <label class="form-label" for="simpleinput">{{ __('messages.description') }}</label>
                        <input type="text" id="simpleinput" class="form-control" name="description" wire:model.defer="description" {{ ($activity_homework?'disabled':'') }}>
                    </div>
                    @if($activity_homework)
                        @if($activity_homework->state == 'R')
                            <div>
                                <form method="POST" action="{{ route('academic_subjects_student_homework_store') }}" class="dropzone needsclick" style="min-height: 7rem;" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{ $activity_id }}" name="activity_id">
                                    <input type="hidden" value="{{ $cu }}" name="course_id">
                                    <input type="hidden" value="{{ $activity_homework_id }}" name="activity_homework">
                                    <div class="dz-message needsclick">
                                        <i class="fal fa-cloud-upload text-muted mb-3"></i> <br>
                                        <span class="text-uppercase">{{ __('messages.drop_files_here_or_click_to_upload') }}</span>
                                        <br>
                                        <span class="fs-sm text-muted">{{ __('messages.the_selected_files_are_pdf') }}</span>
                                    </div>
                                </form>
                                <button wire:click="delete" type="button" class="btn btn-danger waves-effect waves-themed mt-2">{{ __('messages.delete') }}</button>
                                <button wire:click="finish" type="button" class="btn btn-success waves-effect waves-themed ml-2 mt-2">Guardar y Terminar</button>
                                <script src="{{ url('theme/js/formplugins/dropzone/dropzone.js') }}" defer></script>
                            </div>
                        @else
                            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                                <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                    <div class="toast-header">
                                        <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                        <strong class="mr-auto">Tarea enviada</strong>
                                        <small>{{ \Carbon\Carbon::parse($activity_homework->created_at)->diffForHumans()  }}</small>
                                    </div>
                                    <div class="toast-body text-center">
                                        La tarea fue enviada correctamente
                                        <a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}" class="btn btn-primary mt-2"><i class="fal fa-long-arrow-left mr-2"></i>Volver al curso</a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <button wire:click="store" type="button" class="btn btn-primary waves-effect waves-themed">{{ __('messages.save') }}</button>
                    @endif
                @else
                    @if($activity->points)
                        <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                <div class="toast-header">
                                    <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                    <strong class="mr-auto">Tiempo terminado</strong>
                                    <small>{{ \Carbon\Carbon::parse($activity->date_end)->diffForHumans()  }}</small>
                                </div>
                                <div class="toast-body text-center">
                                    <span>Estubo disponible desde {{ \Carbon\Carbon::parse($activity->date_start)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($activity->date_end)->format('d/m/Y') }}</span>
                                    <p>Su nota es: {{ $activity->points }}</p>
                                    <a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}" class="btn btn-primary mt-2"><i class="fal fa-long-arrow-left mr-2"></i>Volver al curso</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center height-lg pattern-1">
                            <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" data-toggle="toast">
                                <div class="toast-header">
                                    <img src="{{ asset('theme/img/logo.png') }}" alt="brand-logo" height="16" class="mr-2">
                                    <strong class="mr-auto">Tiempo terminado</strong>
                                    <small>{{ \Carbon\Carbon::parse($activity->date_end)->diffForHumans()  }}</small>
                                </div>
                                <div class="toast-body text-center">
                                    <span>Estubo disponible desde {{ \Carbon\Carbon::parse($activity->date_start)->format('d/m/Y') }} hasta {{ \Carbon\Carbon::parse($activity->date_end)->format('d/m/Y') }}</span>
                                    <p>Ya no puede enviar tarea</p>
                                    <a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}" class="btn btn-primary mt-2"><i class="fal fa-long-arrow-left mr-2"></i>Volver al curso</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
