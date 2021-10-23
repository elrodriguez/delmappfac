<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.academic')</li>
            <li class="breadcrumb-item">@lang('messages.administration')</li>
            <li class="breadcrumb-item active">@lang('messages.products_and_services')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-dolly-flatbed"></i> {{ __('messages.products_and_services') }}
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
                                    <th>{{ __('messages.type') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.price') }}</th>
                                    <th>{{ __('messages.stock') }}</th>
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
                    ajax: "{{ route('academic_products_and_services_list') }}",
                    columns: [
                        {
                            id: "accions",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "text-center",
                            render: function(data){
                                return `<a href="`+ data.edit_url +`" class="btn btn-warning btn-icon rounded-circle waves-effect waves-themed" title="{{ __('messages.edit') }}">
                                                    <i class="fal fa-edit"></i>
                                                </a>`;
                            }
                        },
                        { className: "align-middle",id: "item_type_description",data:'item_type_description',name:'item_types.description' },
                        { className: "align-middle",id: "description",data:'description',name:'items.description' },
                        { className: "align-middle",id: "sale_unit_price",data:'sale_unit_price',name:'items.sale_unit_price' },
                        {
                            searchable:false,
                            orderable:false,
                            className: "align-middle",
                            id: "stock",data:'stock',
                            name:'items.stock'
                        },
                    ],
                    dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {
                            text: '<i class="fal fa-plus mr-1"></i> {{ __("messages.new") }}',
                            name: 'nuevo_add',
                            className: 'btn-success btn-sm-er mr-1',
                            action:function(){
                                window.location.href = "{{ route('academic_products_and_services_create') }}";
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
