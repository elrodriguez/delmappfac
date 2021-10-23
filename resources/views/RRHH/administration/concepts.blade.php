<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.rrhh')</li>
            <li class="breadcrumb-item">@lang('messages.administration')</li>
            <li class="breadcrumb-item active">@lang('messages.concepts')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-user-hard-hat"></i> @lang('messages.concepts')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.list')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                <div class="panel-container show">
                    <div class="panel-content">
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <td width="50px">{{ __('messages.actions') }}</td>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.percentage') }}</th>
                                    <th>{{ __('messages.operation') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
    <script src="{{ url('theme/js/datagrid/datatables/datatables.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/datagrid/datatables/datatables.export.js') }}" defer></script>
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script defer>
            $(document).ready(function()
            {

                // initialize datatable
                $('#dt-basic-example').dataTable(
                {
                    responsive: true,
                    "language": {
                        "lengthMenu": 'Ver <select  class="form-control custom-select btn-sm mr-1">'+
                        '<option value="5">5</option>'+
                        '<option value="10">10</option>'+
                        '<option value="20">20</option>'+
                        '<option value="30">30</option>'+
                        '<option value="40">40</option>'+
                        '<option value="50">50</option>'+
                        '</select>'
                    },
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('rrhh_administration_concepts_list') }}",
                    columns: [
                        {
                            id: "accions",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "text-center",
                            render: function(data){
                                var buttons = `<div class="dropdown">
                                                        <a href="javascript:void(0)" class="btn btn-info rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fal fa-cogs"></i>
                                                        </a>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item" href="`+ data.edit_url +`"><i class="fal fa-edit mr-1"></i>Editar</a>
                                                        </div>
                                                    </div>`;
                                return buttons;
                            }
                        },
                        {
                            className: "align-middle",
                            id: "description",
                            data:'description',
                            name: 'description'
                        },
                        {
                            className: "align-middle",
                            id: "percentage",
                            data:'percentage',
                            name: 'percentage'
                        },
                        {
                            className: "align-middle",
                            id: "operation",
                            data:null,
                            render: function(data){
                                let badge = ``;
                                if(data.operation == 0){
                                    badge = `<span class="badge badge-danger">{{ __("messages.academic_discount") }}</span>`;
                                }else{
                                    badge = `<span class="badge badge-success">{{ __("messages.increase") }}</span>`;
                                }
                                return badge;
                            }
                        }
                    ],
                    dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            text: '<i class="fal fa-plus mr-1"></i>{{ __("messages.new") }}',
                            name: 'nuevo_add',
                            className: 'btn-success btn-sm-er mr-1',
                            action:function(){
                                window.location.href = "{{ route('rrhh_administration_concepts_create') }}";
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fal fa-file-excel mr-1"></i>Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-success btn-sm-er mr-1'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fal fa-print mr-1"></i>Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm-er'
                        }
                    ]
                });
            });

        </script>
    @endsection
</x-app-layout>
