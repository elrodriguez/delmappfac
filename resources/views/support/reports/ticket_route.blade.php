<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('css/timeline.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.technical_support')</li>
            <li class="breadcrumb-item">@lang('messages.reports')</li>
            <li class="breadcrumb-item active">@lang('messages.ticket_path')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-chart-network"></i> {{ __('messages.ticket_path') }}
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-12">
            @livewire('support.reports.ticket-timeline')
        </div>
    </div>

    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){

        });
    </script>
    @endsection
</x-app-layout>
