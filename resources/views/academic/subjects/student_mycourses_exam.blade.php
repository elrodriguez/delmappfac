<x-app-layout>
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.subjects')</li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_student_my_courses') }}">@lang('messages.courses')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_student_mycourse_themes',[$cu,$mt]) }}">@lang('messages.themes_course')</a></li>
            <li class="breadcrumb-item active">@lang('messages.test')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-clipboard-list-check"></i> @lang('messages.test')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.student-mycourses-exam-content', ['cu'=>$cu,'mt'=>$mt,'code'=>$code])
        </div>
    </div>
</x-app-layout>
