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
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_topic_forum_edit',[$cu,$mt,$code]) }}">@lang('messages.forum')</a></li>
            <li class="breadcrumb-item active">@lang('messages.comment')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-comment-lines"></i> @lang('messages.comment')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.student-mycourses-forum-comment-edit', ['cu'=>$cu,'mt'=>$mt,'code'=>$code,'comment_id' => $comment_id])
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/ckeditor.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/config-simple.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            CKEDITOR.replace('editorcomment',{
                removeButtons:'Source,Save,NewPage,ExportPdf,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Radio,Checkbox,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,NumberedList,BulletedList,Outdent,Indent,Blockquote,CreateDiv,JustifyLeft,JustifyCenter,JustifyRight,JustifyBlock,BidiLtr,BidiRtl,Language,Link,Unlink,Anchor,Flash,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Styles,Format,Font,FontSize,TextColor,BGColor,Maximize,ShowBlocks,About',
                filebrowserBrowseUrl: "{{ route('subjects_courses_upload_ckfinder') }}",
                filebrowserWindowWidth: '1000',
                filebrowserWindowHeight: '700',
                height:'300px'
            });
        });
    </script>
    @endsection
</x-app-layout>
