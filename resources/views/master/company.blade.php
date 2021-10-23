<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-colorpicker/bootstrap-colorpicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <div class="px-3 px-sm-5 pt-4">
            <h1 class="mb-4">
                <i class='fal fa-user-circle mr-1'></i>@lang('messages.company')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-sm-6 col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.company_data')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    @livewire('master.company-datas')
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.system_environment')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    @livewire('master.company-system-environment')
                </div>
            </div>
            <div id="panel-4" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.zoom_credentials')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">

                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
        <script src="{{ url('theme/js/formplugins/bootstrap-colorpicker/bootstrap-colorpicker.js') }}"></script>
        <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
        <script defer>
            $(document).ready(function(){
                $('#cp5b').colorpicker().on('colorpickerChange', function(event) {
                    changeColor(event.color.toString())
                });
            });
        </script>
    @endsection
</x-app-layout>
