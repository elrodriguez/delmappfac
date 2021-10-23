<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.logistics')</li>
            <li class="breadcrumb-item">@lang('messages.production')</li>
            <li class="breadcrumb-item active">@lang('messages.projects')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-person-dolly"></i> @lang('messages.projects')
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
                                    <td width="50px">Acciones</td>
                                    <th>{{ __('messages.customer') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.responsable_project') }}</th>
                                    <th class="text-center">Fecha Inicio</th>
                                    <th class="text-center">Fecha Fin</th>
                                    <th class="text-center">{{ __('messages.state') }}</th>
                                    <th class="text-center">Gastos</th>
                                    <th class="text-center">Presupuesto</th>
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
                    ajax: "{{ route('logistics_production_projects_list') }}",
                    columns: [
                        {
                            id: "accions",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "align-middle text-center",
                            render: function(data){
                                var buttons = `<div class="dropdown">
                                                        <a href="javascript:void(0)" class="btn btn-info rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fal fa-cogs"></i>
                                                        </a>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item" href="`+ data.edit_url +`"><i class="fal fa-edit mr-1"></i>Editar</a>
                                                            <a class="dropdown-item" href="`+ data.stages_url +`"><i class="fal fa-abacus mr-1"></i>{{ __('messages.stages') }}</a>
                                                            <a class="dropdown-item" href="`+ data.materials_url +`"><i class="fal fa-boxes mr-1"></i>{{ __('messages.materials') }}</a>
                                                            <a class="dropdown-item" href="`+ data.employees_url +`"><i class="fal fa-user-hard-hat mr-1"></i>{{ __('messages.employees') }}</a>
                                                            <a class="dropdown-item" href="`+ data.other_expenses_url +`"><i class="fal fa-money-bill-alt mr-1"></i>{{ __('messages.other_expenses') }}</a>
                                                        </div>
                                                    </div>`;
                                return buttons;
                            }
                        },
                        {
                            className: "align-middle",
                            id: "customer_name",
                            data:'customer_name',
                            name: 'cu.trade_name'
                        },
                        {
                            className: "align-middle",
                            id: "description",
                            data:'description',
                            name: 'projects.description'
                        },
                        {
                            className: "align-middle",
                            id: "responsable_name",
                            data:'responsable_name',
                            name: 're.trade_name'
                        },
                        {
                            className: "align-middle text-center",
                            id: "date_start",
                            data:'date_start',
                            name: 'projects.date_start'
                        },
                        {
                            className: "align-middle text-center",
                            id: "date_end",
                            data:'date_end',
                            name: 'projects.date_end'
                        },
                        {
                            id: "state",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "align-middle text-center",
                            render: function(data){
                                let badge = ``;
                                if(data.state == 'terminado'){
                                    badge = `<span class="badge badge-primary">`+data.state+`</span>`;
                                }else if(data.state == 'detenido'){
                                    badge = `<span class="badge badge-success">`+data.state+`</span>`;
                                }else if(data.state == 'cancelado'){
                                    badge = `<span class="badge badge-danger">`+data.state+`</span>`;
                                }else if(data.state == 'pendiente'){
                                    badge = `<span class="badge badge-warning">`+data.state+`</span>`;
                                }else{
                                    badge = `<span class="badge badge-info">`+data.state+`</span>`;
                                }
                                return badge;
                            }
                        },
                        {
                            className: "align-middle text-right",
                            id: "investment",
                            data:'investment',
                            name: 'projects.investment'
                        },
                        {
                            className: "align-middle text-right",
                            id: "budget",
                            data:'budget',
                            name: 'projects.budget'
                        }
                    ],
                    dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            text: '<i class="fal fa-plus mr-1"></i> Nuevo',
                            name: 'nuevo_add',
                            className: 'btn-success btn-sm-er mr-1',
                            action:function(){
                                window.location.href = "{{ route('logistics_production_projects_create') }}";
                            }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="fal fa-file-excel mr-1"></i> Excel',
                            titleAttr: 'Generate Excel',
                            className: 'btn-outline-success btn-sm-er mr-1'
                        },
                        {
                            extend: 'print',
                            text: '<i class="fal fa-print mr-1"></i> Print',
                            titleAttr: 'Print Table',
                            className: 'btn-outline-primary btn-sm-er'
                        }
                    ]
                });
            });

        </script>
    @endsection
</x-app-layout>
