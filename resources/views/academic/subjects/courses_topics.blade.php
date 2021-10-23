<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <style>
        .video-responsive {
            position: relative;
            padding-bottom: 56.25%; /* 16/9 ratio */
            padding-top: 30px; /* IE6 workaround*/
            height: 0;
            overflow: hidden;
        }

        .video-responsive iframe,
        .video-responsive object,
        .video-responsive embed {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.subjects')</li>
            <li class="breadcrumb-item"><a href="{{ route('subjects_courses_teacher') }}">@lang('messages.courses')</a></li>
            <li class="breadcrumb-item active">@lang('messages.themes_course')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-ballot"></i> @lang('messages.themes_course')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            @livewire('academic.subjects.courses-topics-content',['course_id'=>$id,'teacher_course_id'=>$ct])
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/dependency/moment/moment.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/inputmask/inputmask.bundle.js') }}"></script>
    <script defer>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('.xeditabletitle').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return "{{ __('messages.this_field_is_required') }}";
                    }
                },
                url: "{{ route('subjects_courses_topics_update') }}",
                success: function(data, config) {
                    console.log(data)
                },
                error: function(errors) {
                    console.log(errors)
                }
            });
        });
        function ondeleteTopic(id){
            Swal.fire({
                title: "{{ __('messages.are_you_sure') }}",
                text: "{{ __('messages.You_won_t_be_able_to_reverse_this') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.delete') }}",
                cancelButtonText: "{{ __('messages.cancel') }}"
            }).then(function(result){
                if (result.value)
                {
                    $.get("{{ asset('academic/subjects/courses/topics/delete/') }}/"+id, function(data) {
                        if(data.success == true){
                            Swal.fire("{{ __('messages.removed') }}", "{{ __('messages.was_successfully_removed') }}", "success");
                            location.reload();
                        }
                    }).fail(function( data ) {
                        Swal.fire("{{ __('messages.error') }}","{{ __('messages.msg_access_permission') }}", "error");
                    });
                }
            });
        }
        function ondeleteClasss(id){
            Swal.fire({
                title: "{{ __('messages.are_you_sure') }}",
                text: "{{ __('messages.You_won_t_be_able_to_reverse_this') }}",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('messages.delete') }}",
                cancelButtonText: "{{ __('messages.cancel') }}"
            }).then(function(result){
                if (result.value)
                {
                    $.get("{{ asset('academic/subjects/courses/topics/class/delete/') }}/"+id, function(data) {
                        if(data.success == true){
                            Swal.fire("{{ __('messages.removed') }}", "{{ __('messages.was_successfully_removed') }}", "success");
                            location.reload();
                        }
                    }).fail(function( data ) {
                        Swal.fire("{{ __('messages.error') }}","{{ __('messages.msg_access_permission') }}", "error");
                    });
                }
            });
        }
    </script>
    @endsection
</x-app-layout>
