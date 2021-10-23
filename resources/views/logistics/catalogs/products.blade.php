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
            <li class="breadcrumb-item">@lang('messages.catalogs')</li>
            <li class="breadcrumb-item active">@lang('messages.products_and_services')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-boxes"></i> {{ __('messages.products_and_services') }}
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
                                    <th>{{ __('messages.image') }}</th>
                                    <th>{{ __('messages.code') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.brand') }}</th>
                                    <th>{{ __('messages.stock_min') }}</th>
                                    <th>{{ __('messages.initial_stock') }}</th>
                                    <th>{{ __('messages.current_stock') }}</th>
                                    <th>{{ __('messages.price_purchase') }}</th>
                                    <th>{{ __('messages.price_sale') }}</th>
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
            $(document).ready(function(){
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
                    ajax: "{{ route('logistics_catalogs_products_list') }}",
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
                                                            <a class="dropdown-item" href="`+ data.edit_url +`"><i class="fal fa-edit mr-1"></i>{{ __('messages.edit') }}</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ondelete('`+data.delete_url+`')"><i class="fal fa-trash-alt mr-1"></i>{{ __('messages.delete') }}</a>
                                                        </div>
                                                    </div>`;
                                return buttons;
                            }
                        },
                        { data: 'image_url',
                          className: "align-middle text-center",
                          searchable:false,
                            render: function(data){
                                return `<img src="`+data+`" width=50px height=50px ></img>`;
                            }
                        },
                        { className: "align-middle",id: "internal_id",data:'internal_id',name:'items.internal_id' },
                        { className: "align-middle",id: "description",data:'description',name:'items.description' },
                        { className: "align-middle",id: "name",data:'name',name:'brands.name' },
                        { className: "align-middle text-right",searchable:false,orderable:false,orderable:false,id: "stock_min",data:'stock_min',name:'items.stock_min' },
                        { className: "align-middle text-right",searchable:false,orderable:false,id: "stock",data:'stock',name:'items.stock' },
                        { className: "align-middle text-right",searchable:false,orderable:false,id: "current_stock",data:'current_stock' },
                        { className: "align-middle text-right",searchable:false,orderable:false,id: "purchase_unit_price",data:'purchase_unit_price',name:'items.purchase_unit_price' },
                        { className: "align-middle text-right",searchable:false,orderable:false,id: "sale_unit_price",data:'sale_unit_price',name:'items.sale_unit_price' },
                    ],
                    dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            text: '<i class="fal fa-upload mr-1"></i>{{ __("messages.to_import") }}',
                            name: 'nuevo_import',
                            className: 'btn-warning btn-sm-er mr-1',
                            action:function(){
                                window.location.href = "{{ route('logistics_catalogs_products_imports') }}";
                            }
                        },
                        {
                            text: '<i class="fal fa-plus mr-1"></i> {{ __("messages.new") }}',
                            name: 'nuevo_add',
                            className: 'btn-success btn-sm-er mr-1',
                            action:function(){
                                window.location.href = "{{ route('logistics_catalogs_products_create') }}";
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
            function ondelete(delete_url){
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
                        $.get(delete_url, function(data) {
                            if(data.success == true){
                                Swal.fire("{{ __('messages.removed') }}", "{{ __('messages.was_successfully_removed') }}", "success");
                                $('#dt-basic-example').DataTable().ajax.reload();
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
