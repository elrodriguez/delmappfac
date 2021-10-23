<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.technical_support')</li>
            <li class="breadcrumb-item">@lang('messages.help_desk')</li>
            <li class="breadcrumb-item active">@lang('messages.ticket')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-receipt"></i> {{ __('messages.ticket') }}
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div class="alert border-danger bg-transparent text-secondary fade show" role="alert">
                <div class="d-flex align-items-center">
                    <div class="flex-1">
                        <span class="h5 color-danger-900">{{ __('messages.list') }}</span>
                    </div>
                    @can('soporte_tecnico_helpdesk_ticket_applicant_nuevo')
                        <a href="{{ route('support_helpdesk_ticket_applicant_create') }}" class="btn btn-outline-danger btn-sm btn-w-m waves-effect waves-themed"><i class="fal fa-plus mr-1"></i>{{ __('messages.new') }} {{ __('messages.ticket') }}</a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            @livewire('support.helpdesk.ticket-applicant-list')
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
