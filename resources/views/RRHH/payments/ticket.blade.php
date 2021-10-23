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
            <li class="breadcrumb-item">@lang('messages.payments')</li>
            <li class="breadcrumb-item active">@lang('messages.tickets')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-cash-register"></i> @lang('messages.tickets')
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
                                    <th class="text-center">{{ __('messages.registration_date') }}</th>
                                    <th>{{ __('messages.employee') }}</th>
                                    <th class="text-center">{{ __('messages.type') }}</th>
                                    <th class="text-center">{{ __('messages.number') }}</th>
                                    <th class="text-right">{{ __('messages.total') }}</th>
                                    <th class="text-center">{{ __('messages.state') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalprint" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Imprimir</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="document_external_id" value="">
                <div class="row js-list-filter">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex justify-content-center align-items-center mb-g">
                        <a type="button" onclick="printPDF('a4')" href="javascript:void(0)" class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100 js-showcase-icon shadow-hover-2">
                            <div class="rounded-top color-fusion-300 w-100 bg-primary-300">
                                <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x hover-bg">
                                    <i class="fal fa-file"></i>
                                </div>
                            </div>
                            <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                                <span class="d-block text-truncate text-muted">A4</span>
                             </div>
                        </a>
                    </div>
                    <!--div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 d-flex justify-content-center align-items-center mb-g">
                        <a type="button" onclick="printPDF('ticket')" href="javascript:void(0)" class="rounded bg-white p-0 m-0 d-flex flex-column w-100 h-100 js-showcase-icon shadow-hover-2">
                            <div class="rounded-top color-fusion-300 w-100 bg-primary-300">
                                <div class="rounded-top d-flex align-items-center justify-content-center w-100 pt-3 pb-3 pr-2 pl-2 fa-3x hover-bg">
                                    <i class="fal fa-receipt"></i>
                                </div>
                            </div>
                            <div class="rounded-bottom p-1 w-100 d-flex justify-content-center align-items-center text-center">
                                <span class="d-block text-truncate text-muted">Ticket</span>
                             </div>
                        </a>
                    </div-->
                </div>
            </div>
            <!--div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div-->
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
                    ajax: "{{ route('rrhh_payments_tickts_list') }}",
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
                                                            <a class="dropdown-item" onclick="openModalPrint('`+ data.external_id +`')"><i class="fal fa-print mr-1"></i>{{ __('messages.to_print') }}</a>`;
                                                            if(data.state==1){
                                                            `<a class="dropdown-item" onclick="onCancel('`+ data.cancel_url +`')"><i class="fal fa-times-circle mr-1"></i>{{ __('messages.ticket_cancel') }}</a>`;
                                                            }
                                                        `</div>
                                                    </div>`;
                                return buttons;
                            }
                        },
                        {
                            className: "text-center align-middle",
                            id: "created_at",
                            data:'created_at',
                            name: 'expenses.created_at'
                        },
                        {
                            className: "align-middle",
                            id: "trade_name",
                            data:'trade_name',
                            name: 'people.trade_name'
                        },
                        {
                            className: "text-center align-middle",
                            id: "description",
                            data:'description',
                            name: 'expense_types.description'
                        },
                        {
                            className: "text-center align-middle",
                            id: "number",
                            data:'number',
                            name: 'expenses.number'
                        },
                        {
                            className: "text-right align-middle",
                            id: "total",
                            data:'total',
                            name: 'expenses.total'
                        },
                        {
                            id: "state",
                            data:'state',
                            searchable: false,
                            orderable:false,
                            className: "align-middle text-center",
                            render: function(data){
                                let span;
                                if(data == 1){
                                    span = `<span class="badge badge-warning">registrado</span>`;
                                }else{
                                    span = `<span class="badge badge-danger">anulado</span>`;
                                }
                                return span;
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
                                window.location.href = "{{ route('rrhh_payments_ticket_create') }}";
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
            function onCancel(delete_url){
                Swal.fire({
                    title: "{{ __('messages.are_you_sure') }}",
                    text: "{{ __('messages.You_won_t_be_able_to_reverse_this') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('messages.ticket_cancel') }}",
                    cancelButtonText: "{{ __('messages.cancel') }}"
                }).then(function(result){
                    if (result.value)
                    {
                        $.get(delete_url, function(data) {
                            Swal.fire(data.title, data.message, data.state);
                            if(data.state == 'success'){
                                $('#dt-basic-example').DataTable().ajax.reload();
                            }
                        }).fail(function( data ) {
                            Swal.fire("{{ __('messages.error') }}","{{ __('messages.msg_access_permission') }}", "error");
                        });
                    }
                });
            }
            function openModalPrint(external_id){
                $('#document_external_id').val(external_id);
                $('#exampleModalprint').modal('show');
            }
            function printPDF(format){
                let external_id = $('#document_external_id').val();
                window.open(`print/expense/`+external_id+`/`+format, '_blank');
            }
        </script>
    @endsection
</x-app-layout>
