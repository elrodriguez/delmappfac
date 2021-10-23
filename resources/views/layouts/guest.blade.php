<!DOCTYPE html>
@php
    $company = \App\Models\Master\Company::first();
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>

        <meta name="description" content="Login">
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
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body>
        <!-- DOC: script to save and load page settings -->
        <script>
            /**
                *	This script should be placed right after the body tag for fast execution
                *	Note: the script is written in pure javascript and does not depend on thirdparty library
                **/
            'use strict';

            var classHolder = document.getElementsByTagName("BODY")[0],
                /**
                    * Load from localstorage
                    **/
                themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
                {},
                themeURL = themeSettings.themeURL || '',
                themeOptions = themeSettings.themeOptions || '';
            /**
                * Load theme options
                **/
            if (themeSettings.themeOptions)
            {
                classHolder.className = themeSettings.themeOptions;
                console.log("%c✔ Theme settings loaded", "color: #148f32");
            }
            else
            {
                console.log("%c✔ Heads up! Theme settings is empty or does not exist, loading default settings...", "color: #ed1c24");
            }
            if (themeSettings.themeURL && !document.getElementById('mytheme'))
            {
                var cssfile = document.createElement('link');
                cssfile.id = 'mytheme';
                cssfile.rel = 'stylesheet';
                cssfile.href = themeURL;
                document.getElementsByTagName('head')[0].appendChild(cssfile);

            }
            else if (themeSettings.themeURL && document.getElementById('mytheme'))
            {
                document.getElementById('mytheme').href = themeSettings.themeURL;
            }
            /**
                * Save to localstorage
                **/
            var saveSettings = function()
            {
                themeSettings.themeOptions = String(classHolder.className).split(/[^\w-]+/).filter(function(item)
                {
                    return /^(nav|header|footer|mod|display)-/i.test(item);
                }).join(' ');
                if (document.getElementById('mytheme'))
                {
                    themeSettings.themeURL = document.getElementById('mytheme').getAttribute("href");
                };
                localStorage.setItem('themeSettings', JSON.stringify(themeSettings));
            }
            /**
                * Reset settings
                **/
            var resetSettings = function()
            {
                localStorage.setItem("themeSettings", "");
            }

        </script>
        <div class="page-wrapper auth">
            <div class="page-inner bg-brand-gradient">
                <div class="page-content-wrapper bg-transparent m-0">
                    <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                        <div class="d-flex align-items-center container p-0">
                            <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9 border-0">
                                <a href="{{ route('welcome') }}" class="page-logo-link press-scale-down d-flex align-items-center">
                                    @if(file_exists(public_path('storage/'.$company->logo)))
                                    <img src="{{ url('storage/'.$company->logo) }}" alt="{{ config('app.name', 'Laravel') }}" aria-roledescription="logo">
                                    @else
                                    <img src="{{ url('theme/img/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" aria-roledescription="logo">
                                    @endif
                                    <span class="page-logo-text mr-1">{{ config('app.name', 'Laravel') }}</span>
                                </a>
                            </div>
                            {{ $header }}
                        </div>
                    </div>
                    <div class="flex-1" style="background: url({{ asset('theme/img/svg/pattern-1.svg') }}) no-repeat center bottom fixed; background-size: cover;">
                        <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                            {{ $slot }}
                        </div>
                        <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                            @include('layouts.footer')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BEGIN Color profile -->
        <!-- this area is hidden and will not be seen on screens or screen readers -->
        <!-- we use this only for CSS color refernce for JS stuff -->
        <p id="js-color-profile" class="d-none">
            <span class="color-primary-50"></span>
            <span class="color-primary-100"></span>
            <span class="color-primary-200"></span>
            <span class="color-primary-300"></span>
            <span class="color-primary-400"></span>
            <span class="color-primary-500"></span>
            <span class="color-primary-600"></span>
            <span class="color-primary-700"></span>
            <span class="color-primary-800"></span>
            <span class="color-primary-900"></span>
            <span class="color-info-50"></span>
            <span class="color-info-100"></span>
            <span class="color-info-200"></span>
            <span class="color-info-300"></span>
            <span class="color-info-400"></span>
            <span class="color-info-500"></span>
            <span class="color-info-600"></span>
            <span class="color-info-700"></span>
            <span class="color-info-800"></span>
            <span class="color-info-900"></span>
            <span class="color-danger-50"></span>
            <span class="color-danger-100"></span>
            <span class="color-danger-200"></span>
            <span class="color-danger-300"></span>
            <span class="color-danger-400"></span>
            <span class="color-danger-500"></span>
            <span class="color-danger-600"></span>
            <span class="color-danger-700"></span>
            <span class="color-danger-800"></span>
            <span class="color-danger-900"></span>
            <span class="color-warning-50"></span>
            <span class="color-warning-100"></span>
            <span class="color-warning-200"></span>
            <span class="color-warning-300"></span>
            <span class="color-warning-400"></span>
            <span class="color-warning-500"></span>
            <span class="color-warning-600"></span>
            <span class="color-warning-700"></span>
            <span class="color-warning-800"></span>
            <span class="color-warning-900"></span>
            <span class="color-success-50"></span>
            <span class="color-success-100"></span>
            <span class="color-success-200"></span>
            <span class="color-success-300"></span>
            <span class="color-success-400"></span>
            <span class="color-success-500"></span>
            <span class="color-success-600"></span>
            <span class="color-success-700"></span>
            <span class="color-success-800"></span>
            <span class="color-success-900"></span>
            <span class="color-fusion-50"></span>
            <span class="color-fusion-100"></span>
            <span class="color-fusion-200"></span>
            <span class="color-fusion-300"></span>
            <span class="color-fusion-400"></span>
            <span class="color-fusion-500"></span>
            <span class="color-fusion-600"></span>
            <span class="color-fusion-700"></span>
            <span class="color-fusion-800"></span>
            <span class="color-fusion-900"></span>
        </p>
        <!-- END Color profile -->
        <!-- base vendor bundle:
                DOC: if you remove pace.js from core please note on Internet Explorer some CSS animations may execute before a page is fully loaded, resulting 'jump' animations
                        + pace.js (recommended)
                        + jquery.js (core)
                        + jquery-ui-cust.js (core)
                        + popper.js (core)
                        + bootstrap.js (core)
                        + slimscroll.js (extension)
                        + app.navigation.js (core)
                        + ba-throttle-debounce.js (core)
                        + waves.js (extension)
                        + smartpanels.js (extension)
                        + src/../jquery-snippets.js (core) -->
        <script src="{{ url('theme/js/vendors.bundle.js') }}"></script>
        <script src="{{ url('theme/js/app.bundle.js') }}"></script>
    </body>
</html>
