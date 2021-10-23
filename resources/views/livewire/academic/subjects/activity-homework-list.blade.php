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
                                <div class="text-uppercase text-muted py-2 px-3">{{ __('messages.files') }}</div>
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
                                            @if($student->description)
                                                <p>{{ $student->description }}</p>
                                                @switch($student->state)
                                                    @case('R')
                                                        <span class="badge badge-info">Registrado</span>
                                                        @break
                                                    @case('T')
                                                        <span class="badge badge-success">Terminado</span>
                                                        @break
                                                    @case('C')
                                                        <span class="badge badge-primary">Calificado</span>
                                                        @break
                                                @endswitch
                                            @else
                                            <p>Un no responde</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-1 hidden-md-down align-middle">
                                        <div class="p-3 p-md-3 text-center" wire:ignore>
                                            @if($student->description)
                                            <a href="#" class="homeworkedit" id="homework{{ $student->id }}" data-type="text" data-pk="{{ $student->id }}" data-title="Calificación">{{ $student->points }}</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3 col-xl-1 hidden-md-down">
                                        @if($student->description)
                                        <div class="p-3 p-md-3">
                                            @foreach (json_decode($student->files) as $file)
                                                <a href="{{ asset('storage/'.$file->url) }}" target="_blank" class="d-block text-muted">72 <i>{{ $file->name }}</i></a>
                                            @endforeach
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
        </div>
    </div>
    <script>

    </script>
</div>
