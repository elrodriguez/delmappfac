<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    <style>
        .table-scroll > tbody {
            display:block;
            overflow-y:auto;
        }
        .table-scroll > thead {
            display:table;
            width:100%;
            table-layout:fixed;
        }
        .table-scroll > tbody tr {
            display:table;
            width:100%;
            table-layout:fixed;
        }
        .table-scroll > thead {
            width: calc( 100% - 1.4em )
        }
        .table-scroll .tbody-width-200{
            max-height:200px;
        }
        .table-scroll .tbody-width-500{
            max-height:500px;
        }
    </style>
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.enrollment')</li>
            <li class="breadcrumb-item active">@lang('messages.register')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-book"></i> @lang('messages.register')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.new')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <ul class="nav nav-tabs nav-fill m-3" role="tablist">
						<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#tab_justified-1" role="tab" aria-selected="true">{{ __('messages.school') }}</a></li>
						<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tab_justified-2" role="tab" aria-selected="false">{{ __('messages.courses') }}</a></li>
                    </ul>
                    <div class="tab-content">
						<div class="tab-pane fade active show" id="tab_justified-1" role="tabpanel">
                            @livewire('academic.enrollment.enrollment-register-form')
						</div>
						<div class="tab-pane fade" id="tab_justified-2" role="tabpanel">
							@livewire('academic.enrollment.enrollment-register-course')
						</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}" defer></script>
    <script>
        $(document).ready(function(){
            $(".date_register").datepicker({
                format: 'dd/mm/yyyy',
                language:"{{ app()->getLocale() }}",
                autoclose:true
            }).datepicker('setDate','0');
        });
    </script>
    @endsection
</x-app-layout>
