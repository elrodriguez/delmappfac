<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.logistics')</li>
            <li class="breadcrumb-item">@lang('messages.warehouse')</li>
            <li class="breadcrumb-item">@lang('messages.inventory')</li>
            <li class="breadcrumb-item active">@lang('messages.inventory_report')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-analytics"></i> @lang('messages.inventory_report')
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
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group row">
                                    <label for="warehouse" class="col-sm-2 col-form-label">Almacén</label>
                                    <div class="col-sm-10">
                                        <select class="custom-select form-control" id="warehouse_id" name="warehouse_id" onchange="filterTable()">
                                            <option value="">{{ __('messages.all') }}</option>
                                            @foreach ($warehouses as $warehouse)
                                                <option value="{{ $warehouse->id }}">{{ $warehouse->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 d-flex flex-row align-items-center">
                                <button onclick="filterTable()" type="button" class="btn btn-primary ml-auto waves-effect waves-themed" >
                                    <span class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                                    <span>{{ __('messages.search') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>{{ __('messages.code') }}</th>
                                    <th>{{ __('messages.image') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>Inventario actual</th>
                                    <th>Precio de venta</th>
                                    <th>Costo</th>
                                    <th>{{ __('messages.warehouse') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('script')
    <script src="{{ url('theme/js/datagrid/datatables/datatables.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/datagrid/datatables/datatables.export.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){

            $('#dt-basic-example').dataTable({
                responsive: true,
                searching: true,
                language: {
                    "lengthMenu": 'Ver <select  class="form-control custom-select btn-sm mr-1">'+
                    '<option value="5">5</option>'+
                    '<option value="10">10</option>'+
                    '<option value="20">20</option>'+
                    '<option value="30">30</option>'+
                    '<option value="40">40</option>'+
                    '<option value="50">50</option>'+
                    '<option value="100">100</option>'+
                    '<option value="200">200</option>'+
                    '<option value="500">500</option>'+
                    '<option value="1000">1000</option>'+
                    '</select>'
                },
                processing: true,
                serverSide: true,
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('logistics_warehouse_inventory_inventory_report') }}",
                    data: function (d) {
                        return $.extend({}, d, {
                            "warehouse_id": $('#warehouse_id').val()
                        });
                    }
                },
                columns: [
                    { orderable:false,className: "align-middle",id: "internal_id",data:'internal_id',name:'items.internal_id'},
                    { 
                        data: 'image_url',
                        className: "align-middle",
                        render: function(data){
                            return `<img src="`+data+`" width=50px height=50px  />`;
                        }
                    },
                    { className: "align-middle",id: "description",data:'description',name:'items.description'},
                    { orderable:false,searchable:false,className: "align-middle text-right",id: "item_warehouse_stock",data:'item_warehouse_stock'},
                    { orderable:false,searchable:false,className: "align-middle text-right",id: "sale_unit_price",data:'sale_unit_price'},
                    { orderable:false,searchable:false,className: "align-middle text-right",id: "purchase_unit_price",data:'purchase_unit_price'},
                    { orderable:false,searchable:false,className: "align-middle",id: "warehouse_description",data:'warehouse_description'}
                ],
                dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
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
        function filterTable() {
            $('#dt-basic-example').DataTable().draw();
        }
        function formatRepo(repo){
            if (repo.loading){
                return repo.description;
            }

            var markup = "<div class='select2-result-repository clearfix d-flex'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.internal_id +"</span>"+ repo.description + "</div>"+
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo){
            return repo.description || repo.id;
        }
    </script>
    @endsection
</x-app-layout>
