<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.subjects')</li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_student_my_courses') }}">@lang('messages.courses')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}">@lang('messages.themes_course')</a></li>
            <li class="breadcrumb-item active">@lang('messages.questions_and_answers')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-comment-alt-smile"></i> @lang('messages.questions_and_answers')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.student-mycourses-question-answer',['cu'=>$cu,'mt'=>$mt,'code'=>$code])
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/ckeditor.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/config-simple.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){

        });
    </script>
    @endsection
</x-app-layout>
