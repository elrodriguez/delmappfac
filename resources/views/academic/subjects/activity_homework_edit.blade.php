<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.subjects')</li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_teacher') }}">@lang('messages.courses')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_themes',[$course,$topic]) }}">@lang('messages.themes_course')</a></li>
            <li class="breadcrumb-item active">@lang('messages.homework')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-comment-alt-smile"></i> @lang('messages.homework')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.activity-homework-edit',['course'=>$course,'topic'=>$topic,'activity'=>$activity])
            @livewire('academic.subjects.activity-homework-list',['course'=>$course,'topic'=>$topic,'activity'=>$activity])
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/ckeditor.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/ckeditor/config-simple.js') }}" defer></script>
    <script src="{{ url('theme/js/dependency/moment/moment.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            $('#datepicker-7').daterangepicker({
                locale:{
                    format: 'DD/MM/YYYY'
                },
                opens: 'left'
            }, function(start, end, label){
                datesSelects(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
            });

            CKEDITOR.replace('editor',{
                    //removeButtons: 'Source,Save,NewPage,ExportPdf,Preview,Print,Templates,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Strike,Subscript,Superscript,CopyFormatting,RemoveFormat,Outdent,Indent,Blockquote,CreateDiv,BidiLtr,BidiRtl,Language,Anchor,Unlink,Flash,HorizontalRule,PageBreak,Iframe,Maximize,ShowBlocks,About',
                    filebrowserBrowseUrl: "{{ route('subjects_courses_upload_ckfinder') }}",
                    filebrowserWindowWidth: '1000',
                    filebrowserWindowHeight: '700',
                    extraPlugins: 'youtube,video',
                    height:'400px'
            });
            xhomeworkedit();
        });
        function xhomeworkedit(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('.homeworkedit').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return "{{ __('messages.this_field_is_required') }}";
                    }

                    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
                    if(preg.test(value) === false){
                        return 'Este campo no es valido';
                    }
                },
                url: "{{ route('subjects_courses_topics_homework_points_update') }}",
                success: function(data, config) {

                },
                error: function(errors) {
                    console.log(errors)
                }
            });
        }
    </script>
    @endsection
</x-app-layout>
