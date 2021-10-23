<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.subjects')</li>
            <li class="breadcrumb-item active">@lang('messages.courses')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-book"></i> @lang('messages.courses')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.courses-teacher-list')
            @livewire('academic.subjects.courses-teacher-list-free')
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script defer>
        $(document).ready(function(){
            //$('#course_id').select2();
        });
    </script>
    @endsection
</x-app-layout>
