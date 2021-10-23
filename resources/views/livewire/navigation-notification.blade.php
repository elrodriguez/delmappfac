<div>
    <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
        <i class="fal fa-bell"></i>
        @if($notifications>0)
        <span class="badge badge-icon">{{ $notifications }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
        <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
            <h4 class="m-0 text-center color-white">
                @if($notifications>0)
                    {{ $notifications }} New
                @endif
                <small class="mb-0 opacity-80">Notificaciones de usuario</small>
            </h4>
        </div>
        <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
            <li class="nav-item">
                <a class="nav-link px-4 fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-messages" data-i18n="drpdwn.messages">Messages</a>
            </li>
        </ul>
        <div class="tab-content tab-notification">
            <div class="tab-pane active p-3 text-center">
                <h5 class="mt-4 pt-4 fw-500">
                    <span class="d-block fa-3x pb-4 text-muted">
                        <i class="ni ni-arrow-up text-gradient opacity-70"></i>
                    </span> Seleccione una pestaña de arriba para activar
                    <small class="mt-3 fs-b fw-400 text-muted">
                        Este mensaje de página en blanco ayuda a proteger su privacidad, o puede mostrar el primer mensaje aquí automáticamente a través de
                        <a href="#">página de configuración</a>
                    </small>
                </h5>
            </div>
            <div class="tab-pane" id="tab-messages" role="tabpanel">
                <div class="custom-scroll h-100">
                    <ul class="notification">
                        @foreach($messages as $message)
                            <li class="unread">
                                <a href="#" class="d-flex align-items-center">
                                    <span class="status mr-2">
                                        @if($message['avatar'])
                                            @php
                                                $avatar = asset('storage/'.$message['avatar']);
                                            @endphp
                                        @else
                                            @php
                                                $avatar = ui_avatars_url($message['name'],50,'none');
                                            @endphp
                                        @endif
                                        <span class="profile-image rounded-circle d-inline-block" style="background-image:url('{{ $avatar }}');background-size: cover;"></span>
                                    </span>
                                    <span class="d-flex flex-column flex-1 ml-1">
                                        <span class="name">{{ $message['name'] }} <span class="badge badge-primary fw-n position-absolute pos-top pos-right mt-1">INBOX</span></span>
                                        <span class="msg-a fs-sm">{{ $message['content'] }}</span>
                                        <span class="fs-nano text-muted mt-1">{{ $message['created_at'] }}</span>
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
        <div class="py-2 px-3 bg-faded d-block rounded-bottom text-right border-faded border-bottom-0 border-right-0 border-left-0">
            <a href="#" class="fs-xs fw-500 ml-auto">@lang('messages.view_all_notifications')</a>
        </div>
    </div>
</div>
