<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-colorpicker/bootstrap-colorpicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/summernote/summernote.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.onlineshop')</li>
            <li class="breadcrumb-item">@lang('messages.administration')</li>
            <li class="breadcrumb-item active">@lang('messages.configurations')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-cogs"></i> {{ __('messages.configurations') }}
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-sm-6 col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.web_data')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    @livewire('onlineshop.admin.configurations-form')
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.social_media')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    @livewire('master.company-social-media')
                </div>
            </div>
            <div id="panel-3" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.reply_mail')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    @livewire('onlineshop.admin.configurations-reply-mail')
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
        <script src="{{ url('theme/js/formplugins/bootstrap-colorpicker/bootstrap-colorpicker.js') }}"></script>
        <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
        <script src="{{ url('theme/js/formplugins/summernote/summernote.js') }}"></script>
        <script defer>
            $(document).ready(function(){
                $('#cp5b').colorpicker().on('colorpickerChange', function(event) {
                    changeColor(event.color.toString())
                });
            });
        </script>
    @endsection
</x-app-layout>