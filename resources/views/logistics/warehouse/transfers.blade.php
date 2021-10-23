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
            <li class="breadcrumb-item active">@lang('messages.transfers')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-dolly"></i> {{ __('messages.transfers') }}
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
                        <div class="table-responsive">
                            <table id="dt-basic-example" class="table table-bordered table-striped w-100">
                                <thead class="bg-primary-600">
                                    <tr>
                                        <td class="text-center">{{ __('messages.date') }}</td>
                                        <th>{{ __('messages.origin_warehouse') }}</th>
                                        <th>{{ __('messages.destination_warehouse') }}</th>
                                        <th>{{ __('messages.reason_for_transfer') }}</th>
                                        <th class="text-center">{{ __('messages.products') }}</th>
                                        <th class="text-right">{{ __('messages.quantity') }} {{ __('messages.products') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
        $(document).ready(function() {
            $('.basicAutoComplete').autoComplete().on('autocomplete.select', function (evt, item) {
                selectProduct(item.value);
            });

            var dt = $('#dt-basic-example').dataTable({
                //responsive: true,
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
                ajax: "{{ route('logistics_warehouse_inventory_transfers_list') }}",
                columns: [

                    { className: "align-middle",id: "created_at",data:'created_at'},
                    { className: "align-middle",id: "warehouse",data:'warehouse.description'},
                    { className: "align-middle",id: "warehouse_destination",data:'warehouse_destination.description'},
                    { className: "align-middle",id: "description",data:'description'},
                    {
                        className:      'details-control text-center align-middle',
                        orderable:      false,
                        data:           null,
                        defaultContent: `<button  type="button" class="btn btn-info btn-icon rounded-circle waves-effect waves-themed">
                                            <i class="fal fa-search-plus"></i>
                                        </button>`
                    },
                    { className: "align-middle text-right",id: "quantity",data:'quantity' },
                ],
                dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [
                    {
                        text: '<i class="fal fa-plus mr-1"></i> {{ __("messages.new") }}',
                        name: 'btn_new',
                        className: 'btn btn-success btn-pills waves-effect waves-themed btn-sm-er mr-1',
                        action:function(){
                            window.location.href = "{{ route('logistics_warehouse_inventory_transfers_create') }}";
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

            var detailRows = [];

            $('#dt-basic-example tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.api().row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    row.child( format( row.data() ) ).show();

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
            } );

            // On each draw, loop over the `detailRows` array and show any child rows
            dt.on( 'draw', function () {
                $.each( detailRows, function ( i, id ) {
                    $('#'+id+' td.details-control').trigger( 'click' );
                } );
            } );
        });
        function format ( d ) {
            var html = `<table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('messages.product') }}</th>
                                    <th class="text-right" scope="col">{{ __('messages.quantity') }}</th>
                                </tr>
                            </thead>
                            <tbody>`;
                                d.inventory.forEach(function(item, index) {
                                    html+=`
                                        <tr>
                                            <td class="text-center">`+(index+1)+`</td>
                                            <td>`+item.item.description+`</td>
                                            <td class="text-right">`+item.quantity+`</td>
                                        </tr>
                                    `;
                                });
                            html+=`</tbody>
                        </table>`;
            return html;
        }
        function openTranslateModalForm(item_id,warehouse_id,stock){
            translateModalForm(item_id,warehouse_id,stock);
        }
        function openRemoveModalForm(item_id,warehouse_id,stock){
            removeModalForm(item_id,warehouse_id,stock);
        }
    </script>
    @endsection
</x-app-layout>
