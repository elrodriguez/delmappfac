<!DOCTYPE html>
@php
    $company = \App\Models\Master\Company::first();
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="description" content="Introduction">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
        <!-- Call App Mode on ios devices -->
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no">
        <!-- base css -->
        <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="{{ url('theme/css/vendors.bundle.css') }}">
        <link id="appbundle" rel="stylesheet" media="screen, print" href="{{ url('theme/css/app.bundle.css') }}">
        <link id="mytheme" rel="stylesheet" media="screen, print" href="#">
        <link id="myskin" rel="stylesheet" media="screen, print" href="{{ url('theme/css/skins/skin-master.css') }}">
        <!-- Place favicon.ico in the root directory -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ url('theme/img/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ url('theme/img/favicon/favicon-32x32.png') }}">
        <link rel="mask-icon" href="{{ url('theme/img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
        <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-brands.css') }}">
        <link rel="stylesheet" media="screen, print" href="{{ url('css/style.css') }}">
        <style type="text/css">
            /* FONDO VIDEO */
            video { 
   
                min-width: 100%;
                min-height: 100%;
                width: auto;
                height: auto;
                
                position: fixed;    
                top: 50%;
                left: 50%;
                transform: translateX(-50%) translateY(-50%); 
                    
                z-index: -1;
                    
                background-size: cover;
                
            }
        </style>
    </head>
    <body class="mod-bg-1 mod-nav-link">

        <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
            <div class="d-flex align-items-center container p-0">
                <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                    <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                        @if(file_exists(public_path('storage/'.$company->logo)))
                        <img src="{{ url('storage/'.$company->logo) }}" alt="{{ config('app.name', 'Laravel') }}" aria-roledescription="logo">
                        @else
                        <img src="{{ url('theme/img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" aria-roledescription="logo">
                        @endif
                        <span class="page-logo-text mr-1">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>
                <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                    ¿Ya eres usuario?
                </span>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-link text-white ml-auto ml-sm-0 mr-2">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-link text-white ml-auto ml-sm-0 mr-2">
                            Login
                        </a>
                        {{-- @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-link text-white ml-auto ml-sm-0">Register</a>
                        @endif --}}
                    @endauth
                @endif
            </div>
        </div>
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card p-4 rounded-plus bg-info-900">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-analytics"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">Reportes</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card p-4 rounded-plus bg-warning-700">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-boxes"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">Inventario</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card p-4 rounded-plus bg-danger-900">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-dolly-flatbed-alt"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">Compras</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card p-4 rounded-plus bg-success-700">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-industry-alt"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">Producción</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card p-4 rounded-plus bg-info-400">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-donate"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">Ventas</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card p-4 rounded-plus bg-primary-900">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-user-hard-hat"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">Empleados</h5>
                        </div>
                    </div>
                </div> 
                <div class="col-md-3 mt-4">
                    <div class="card p-4 rounded-plus bg-fusion-400">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">b-learning</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mt-4">
                    <div class="card p-4 rounded-plus bg-warning-600">
                        <div class="rounded-top text-white w-100">
                            <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x">
                                <i class="fal fa-user-headset"></i>
                            </div>
                        </div>
                        <div class="card-body text-center text-white">
                            <h5 class="card-title">{{ __('messages.help_desk')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <video class="video" poster="{{ asset('theme/img/backgrounds/clouds.png') }}" id="bgvid" playsinline autoplay muted loop>
            <source src="{{ asset('theme/media/video/auth-bg.mp4') }}" type="video/mp4">
        </video>
    </body>
</html>
