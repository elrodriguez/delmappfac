<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/summernote/summernote.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.onlineshop')</li>
            <li class="breadcrumb-item">@lang('messages.attention')</li>
            <li class="breadcrumb-item active">@lang('messages.trash')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-envelope"></i> {{ __('messages.trash') }}
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>{{ __('messages.list') }}</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <!-- Page heading removed for composed layout -->
                        <div class="d-flex flex-grow-1 p-0">
                            <!-- left slider -->
                            @livewire('onlineshop.admin.customer-messages-slider')
                            <!-- end left slider -->
                            <!-- inbox container -->
                            @livewire('onlineshop.admin.customer-messages-trash')
                            <!-- end inbox container -->
                            <!-- compose message -->
                            @livewire('onlineshop.admin.customer-messages-compose')
                            <!-- end compose message -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/summernote/summernote.js') }}" defer></script>
    <script defer>
    </script>
    @endsection
</x-app-layout>
