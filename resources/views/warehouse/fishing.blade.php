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
            <li class="breadcrumb-item active">@lang('messages.entry')</li>
            <li class="breadcrumb-item active">@lang('messages.fishing')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='fal fa-info-circle'></i> @lang('messages.fishing')
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
                                    <th width="60px">@lang('messages.actions')</th>
                                    <th width="12%">@lang('messages.number')</th>
                                    <th width="12%" class="text-center">@lang('messages.f_issuance')</th>
                                    <th width="12%" class="text-center">@lang('messages.f_transfer')</th>
                                    <th width="40%">@lang('messages.customer')</th>
                                    <th class="text-right" width="8%">@lang('messages.tons')</th>
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

                // initialize datatable
                $('#dt-basic-example').dataTable(
                {
                    responsive: true,
                    language: {
                        lengthMenu: "{{ __('messages.see') }}"+' <select  class="form-control custom-select btn-sm mr-1">'+
                            '<option value="5">5</option>'+
                            '<option value="10">10</option>'+
                            '<option value="20">20</option>'+
                            '<option value="30">30</option>'+
                            '<option value="40">40</option>'+
                            '<option value="50">50</option>'+
                            '</select>',
                        processing: "{{ __('messages.requesting_data') }}",
                        emptyTable: "{{ __('messages.no_data_available_in_the_table') }}"
                    },
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('income_fishing_list') }}",
                    columns: [
                        {
                            id: "accions",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "text-center",
                            render: function(data){
                                let dropdown = `<div class="dropdown">
                                                        <a href="javascript:void(0)" class="btn btn-info rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fal fa-cogs"></i>
                                                        </a>
                                                        <div class="dropdown-menu" style="">
                                                            <a class="dropdown-item" href="`+ data.sacks_url +`"><i class="fal fa-ball-pile mr-1"></i>{{ __('messages.sacks') }}</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ondelete('`+data.delete_url+`')"><i class="fal fa-trash-alt mr-1"></i>{{ __('messages.delete') }}</a>
                                                        </div>
                                                    </div>`;
                                return dropdown;
                            }
                        },
                        { searchable: false,className: "align-middle",id: "document_fishing_number",data:'document_fishing_number' },
                        { searchable: false,className: "align-middle text-center",id: "date_of_issue",data:'date_of_issue' },
                        { searchable: false,className: "align-middle text-center",id: "date_of_transfer",data:'date_of_transfer' },
                        {
                            className: "align-middle",
                            id: "trade_name",
                            data:'trade_name',
                            name: 'people.trade_name'
                        },
                        {
                            className: "align-middle",
                            id: "weight",
                            data:'weight',
                            className: "text-right",
                            searchable: false,
                        }
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
                                window.location.href = "{{ route('warehouse_fishing_create') }}";
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
