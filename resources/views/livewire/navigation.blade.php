<header class="page-header" role="banner">
    <!-- we need this logo when user switches to nav-function-top -->
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{ url('theme/img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" aria-roledescription="logo">
            <span class="page-logo-text mr-1">{{ config('app.name', 'Laravel') }}</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- DOC: nav menu layout change shortcut -->
    <div class="hidden-md-down dropdown-icon-menu position-relative">
        <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
            <i class="ni ni-menu"></i>
        </a>
        <ul>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation">
                    <i class="ni ni-minify-nav"></i>
                </a>
            </li>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Lock Navigation">
                    <i class="ni ni-lock-nav"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- DOC: mobile button appears during mobile width -->
    <div class="hidden-lg-up">
        <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
            <i class="ni ni-menu"></i>
        </a>
    </div>
    <div class="ml-auto d-flex">
        <!-- activate app search icon (mobile) -->
        <div class="hidden-sm-up">
            <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on" data-focus="search-field" title="Search">
                <i class="fal fa-search"></i>
            </a>
        </div>
        <!-- app settings -->
        <div class="hidden-md-down">
            <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-settings">
                <i class="fal fa-cog"></i>
            </a>
        </div>
        <!-- app shortcuts -->
        <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="My Apps">
                <i class="fal fa-cube"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-animated w-auto h-auto">
                <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top">
                    <h4 class="m-0 text-center color-white">
                        Atajo rápido
                        <small class="mb-0 opacity-80">Aplicaciones y complementos de usuario</small>
                    </h4>
                </div>
                <div class="custom-scroll h-100">
                    <ul class="app-list">
                        @can('parametros')
                        <li>
                            <a href="{{ route('parameters') }}" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-2 icon-stack-3x color-primary-600"></i>
                                    <i class="base-3 icon-stack-2x color-primary-700"></i>
                                    <i class="ni ni-settings icon-stack-1x text-white fs-lg"></i>
                                </span>
                                <span class="app-list-name">
                                    Parametros
                                </span>
                            </a>
                        </li>
                        @endcan
                        @can('empresa')
                        <li>
                            <a href="{{ route('company') }}" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-2 icon-stack-3x color-primary-400"></i>
                                    <i class="base-10 text-white icon-stack-1x"></i>
                                    <i class="ni md-profile color-primary-800 icon-stack-2x"></i>
                                </span>
                                <span class="app-list-name">
                                    {{ __('messages.business_x') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                        <li>
                            <a href="{{ route('chat_index') }}" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-5 icon-stack-3x color-success-700 opacity-80"></i>
                                    <i class="base-12 icon-stack-2x color-success-700 opacity-30"></i>
                                    <i class="fal fa-comment-alt icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    {{ __('messages.internal_chat') }}
                                </span>
                            </a>
                        </li>
                        @can('proyectos')
                        <li>
                            <a href="{{ route('logistics_production_projects') }}" class="app-list-item hover-white">
                                <span class="icon-stack">
                                    <i class="base-6 icon-stack-3x color-danger-600"></i>
                                    <i class="fal fa-person-dolly icon-stack-1x text-white"></i>
                                </span>
                                <span class="app-list-name">
                                    {{ __('messages.projects') }}
                                </span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
            </div>
        </div>
        <!-- app notification -->
        @livewire('navigation-notification')
        <!-- app user menu -->
        @livewire('app-user-menu')
    </div>
</header>
