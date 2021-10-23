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
            <li class="breadcrumb-item active">@lang('messages.aca_file')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-file-upload"></i> @lang('messages.aca_file')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-2" class="panel">
                <div class="panel-hdr">	
                    <h2>
                        Subir  <span class="fw-300"><i>@lang('messages.aca_file')</i></span> 
                    </h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel waves-effect waves-themed" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <form id="formFile" action="{{ route('academic_subjects_student_file_dropbox_store') }}" method="POST" enctype="multipart/form-data">
                        <div class="panel-content">
                            @csrf
                            <div class="form-row">
								<div class="col-md-8 mb-3">
									<label class="form-label" for="title">{{ __('messages.aca_video_title') }} <span class="text-danger">*</span> </label>
									<input type="text" name="title" id="title" class="form-control" required value="{{ $activity->description }}">
									@error('title') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
								</div>
                            </div>
                            <div class="form-row">
								<div class="col-md-12 mb-3">
									<label class="form-label" for="file">{{ __('messages.aca_file') }} <span class="text-danger">*</span> </label><br>
									<input type="file" name="file" id="file" ><br>
									@error('file') <span class="invalid-feedback-2">{{ $message }}</span> @enderror
								</div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <div class="custom-control custom-checkbox custom-control-inline">
                                        <input type="checkbox" class="custom-control-input" id="state" name="state" checked value="1">
                                        <label class="custom-control-label" for="state">{{ __('messages.active') }}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                            <a href="{{ route('subjects_courses_themes',[$course,$topic]) }}" type="button" class="btn btn-secondary waves-effect waves-themed"><i class="fal fa-long-arrow-left mr-1"></i>@lang('messages.back')</a>
                            <input type="hidden" name="video_id" value="{{ $activity->id }}">
                            <input type="hidden" name="course_id" value="{{ $course }}">
                            <input type="hidden" name="topic_id" value="{{ $topic }}">
                            <button id="btnUpdateVideo" type="submit" class="btn btn-primary ml-auto waves-effect waves-themed">
                                <span class="fal fa-check mr-2"></span>
                                <span>@lang('messages.to_update')</span>
                            </button>
                            <button style="display: none" id="btnprogressFile" class="btn btn-primary ml-auto waves-effect waves-themed"" type="button" disabled="">
                                <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                {{ __('messages.aca_loading') }}...
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal center Small -->
    <div class="modal fade" id="progressFile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-5 center-block">
                    <div class="d-flex align-items-center">
                        <strong id="labelMsgVideo">{{ __('messages.aca_loading') }}...</strong>
                        <div id="spinnerVideo" class="spinner-grow ml-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
    <script type="text/javascript">
        $(function () {
            $(document).ready(function () {
                var bar = $('.bar');
                var percent = $('.percent');
                $('#formFile').ajaxForm({
                    beforeSend: function () {
                        $('#progressFile').modal('show');
                        $('#labelMsgVideo').html("{{ __('messages.aca_loading') }}...");
                        $('#progressFile').modal({backdrop: 'static', keyboard: false});
                        $("#btnprogressFile").css('display','block');
                        $("#btnUpdateVideo").css('display','none');
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        $('#labelMsgVideo').html("{{ __('messages.aca_loading') }}")
                    },
                    complete: function (xhr) {
                        
                        $("#btnCloseVideo").removeAttr('disabled');
                        $("#btnUpdateVideo").css('display','block');
                        $("#btnprogressFile").css('display','none');
                        Swal.fire({
                            title: "{{ __('messages.congratulations') }}",
                            text: "{{ __('messages.file_has_been_uploaded_successfully') }}",
                            type: "success",
                            showCancelButton: false,
                        }).then(function(result){
                            if (result.value)
                            {
                                $('#progressFile').modal('hide');
                            }
                        });
                    }
                });
            });
        });
    </script>
    @endsection
</x-app-layout>
