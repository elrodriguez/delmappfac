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
            @livewire('academic.subjects.activity-test-questions',['course'=>$course,'topic'=>$topic,'activity'=>$activity])
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ url('theme/js/dependency/moment/moment.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/inputmask/inputmask.bundle.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            $("#duration").inputmask();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $('.xeditabletitleanswer').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return "{{ __('messages.this_field_is_required') }}";
                    }
                },
                url: "{{ route('subjects_courses_topics_test_enswers_update') }}",
                success: function(data, config) {
                    console.log(data)
                },
                error: function(errors) {
                    console.log(errors)
                }
            });
            $('#datepicker-7').daterangepicker({
                locale:{
                    format: 'DD/MM/YYYY'
                },
                opens: 'left'
            }, function(start, end, label){
                datesSelects(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
            });
        });
    </script>
    @endsection
</x-app-layout>
