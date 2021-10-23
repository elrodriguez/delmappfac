<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.subjects')</li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_teacher') }}">@lang('messages.courses')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_themes',[$course,$topic]) }}">@lang('messages.themes_course')</a></li>
            <li class="breadcrumb-item active">@lang('messages.information')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-ruler-triangle"></i> @lang('messages.activity')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.activity-edit-form',['course'=>$course,'topic'=>$topic,'activity'=>$activity])
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/ckeditor.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/config-simple.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            CKEDITOR.replace('editor',{
                    removeButtons:'Source,Save,ExportPdf,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Find,SelectAll,Replace,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,BidiLtr,BidiRtl,Language,Anchor,Flash,HorizontalRule,SpecialChar,PageBreak,Iframe,Maximize,About,ShowBlocks',
                    filebrowserBrowseUrl: "{{ route('subjects_courses_upload_ckfinder') }}",
                    filebrowserWindowWidth: '1000',
                    filebrowserWindowHeight: '700',
                    height:'500px'
            });
        });
    </script>
    @endsection
</x-app-layout>
