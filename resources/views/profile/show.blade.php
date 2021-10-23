<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">@lang('messages.my_profile')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span></li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='subheader-icon fal fa-plus-circle'></i> @lang('messages.profile')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updateProfileInformation()))
                @livewire('profile.update-profile-information-form')
            @endif

        </div>
        <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
            @livewire('profile.logout-other-browser-sessions-form')
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                @livewire('profile.update-password-form')
            @endif
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    @endsection
</x-app-layout>
