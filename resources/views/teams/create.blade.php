<x-app-layout>
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">{{ __('messages.create_new_team') }}</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='fal fa-info-circle'></i> {{ __('messages.create_new_team') }}
            </h1>
        </div>
    </x-slot>
    @livewire('teams.create-team-form')

</x-app-layout>
