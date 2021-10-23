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
            <li class="breadcrumb-item">@lang('messages.warehouse')</li>
            <li class="breadcrumb-item">@lang('messages.inventory')</li>
            <li class="breadcrumb-item active">@lang('messages.movements')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-map-signs"></i> {{ __('messages.movements') }}
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>{{ __('messages.list') }}</h2>
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
                                    <th>{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.warehouse') }}</th>
                                    <th class="text-right">{{ __('messages.stock') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('logistics.warehouse.movements-modal-form')
    @livewire('logistics.warehouse.translate-modal-form')
    @livewire('logistics.warehouse.remove-modal-form')
    @section('script')
    <script src="{{ url('theme/js/datagrid/datatables/datatables.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/datagrid/datatables/datatables.export.js') }}" defer></script>
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/autocomplete-bootstrap/bootstrap-autocomplete.min.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            $('.basicAutoComplete').autoComplete().on('autocomplete.select', function (evt, item) {
                selectProduct(item.value);
            });

            $('#dt-basic-example').dataTable({
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
                ajax: "{{ route('logistics_warehouse_inventory_movements_list') }}",
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
                                                        <a class="dropdown-item" href="javascript:void(0)" onclick="openTranslateModalForm(`+data.item_id+`,`+data.warehouse_id+`,`+data.stock+`)"><i class="fal fa-dolly mr-1"></i>{{ __('messages.translate') }}</a>
                                                        <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="openRemoveModalForm(`+data.item_id+`,`+data.warehouse_id+`,`+data.stock+`)")"><i class="fal fa-trash-alt mr-1"></i>{{ __('messages.stir') }}</a>
                                                    </div>
                                                </div>`;
                            return buttons;
                        }
                    },
                    { className: "align-middle",id: "item_description",data:'item_description',name:'items.description' },
                    { className: "align-middle",id: "warehouse_description",data:'warehouse_description',name:'warehouses.description' },
                    { className: "align-middle text-right",id: "stock",data:'stock',name:'item_warehouses.stock' },
                ],
                dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        text: '<i class="fal fa-plus mr-1"></i> {{ __("messages.entry") }}',
                        name: 'btn_entry',
                        className: 'btn btn-primary btn-pills waves-effect waves-themed btn-sm-er mr-1',
                        action:function(){
                            openModalMovements('i')
                        }
                    },
                    {
                        text: '<i class="fal fa-minus mr-1"></i> {{ __("messages.exit_kardex") }}',
                        name: 'btn_exit',
                        className: 'btn btn-danger btn-pills waves-effect waves-themed btn-sm-er mr-1',
                        action:function(){
                            openModalMovements('s')
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

        function openTranslateModalForm(item_id,warehouse_id,stock){
            translateModalForm(item_id,warehouse_id,stock);
        }
        function openRemoveModalForm(item_id,warehouse_id,stock){
            removeModalForm(item_id,warehouse_id,stock);
        }
    </script>
    @endsection
</x-app-layout>
