<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/css/bootstrap-editable.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.subjects')</li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_teacher') }}">@lang('messages.courses')</a></li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_themes',[$course,$topic]) }}">@lang('messages.themes_course')</a></li>
            <li class="breadcrumb-item active">Corregir exámenes</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-clipboard-list-check"></i> Corregir exámenes
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.activity-test-correct-student',['course'=>$course,'topic'=>$topic,'activity'=>$activity])
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
    <script defer>
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $('.testnoteedit').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return "{{ __('messages.this_field_is_required') }}";
                    }
                },
                url: "{{ route('subjects_courses_topics_test_update_student') }}",
                success: function(data, config) {
                    studentListReload();
                },
                error: function(errors) {
                    console.log(errors)
                }
            });
        });
        function activeEditPoint(){
            $.fn.editable.defaults.mode = 'inline';
            $('.testanswernoteedit').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return "{{ __('messages.this_field_is_required') }}";
                    }
                },
                url: "{{ route('subjects_courses_topics_test_enswer_update_student') }}",
                success: function(data, config) {
                    studentListReload();
                },
                error: function(errors) {
                    console.log(errors)
                }
            });
        }
    </script>
    @endsection
</x-app-layout>
