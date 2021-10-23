<x-app-layout>
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">@lang('messages.error')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-receipt"></i> {{ __('messages.ticket') }}
            </h1>
        </div>
    </x-slot>
    <div class="h-alt-f d-flex flex-column align-items-center justify-content-center text-center">
        <h1 class="page-error color-fusion-500">
            ERROR <span class="text-gradient"></span>
            <small class="fw-500">
                {{ __('messages.something') }} <u>{{ __('messages.went') }}</u> {{ __('messages.wrong') }}!
            </small>
        </h1>
        <h3 class="fw-500 mb-5">
            {{ __('messages.you_have_experienced_technical_error_we_apologize') }}
        </h3>
        <h4>
            {{ __('messages.'.$msg) }}
        </h4>
    </div>
</x-app-layout>
