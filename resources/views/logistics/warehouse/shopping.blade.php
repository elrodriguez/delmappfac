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
                <li class="breadcrumb-item active">@lang('messages.shopping')</li>
                <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='fal fa-info-circle'></i> @lang('messages.shopping')
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
                                    <th width="60px" class="text-center">@lang('messages.actions')</th>
                                    <th width="10%" class="text-center">@lang('messages.f_issuance')</th>
                                    <th width="30%">@lang('messages.provider')</th>
                                    <th width="30%" class="text-center">@lang('messages.number')</th>
                                    <th width="10%" class="text-center">@lang('messages.products')</th>
                                    <th width="10%" class="text-center">@lang('messages.coin')</th>
                                    <th width="10%" class="text-center">@lang('messages.total')</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalDetalle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabelDetalle">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-sm">
                    <thead class="bg-primary-600">
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ __('messages.image') }}</th>
                        <th scope="col" class="text-center">{{ __('messages.code') }}</th>
                        <th scope="col">{{ __('messages.description') }}</th>
                        <th scope="col" class="text-center">{{ __('messages.quantity') }}</th>
                        <th scope="col" class="text-center">{{ __('messages.total') }}</th>
                      </tr>
                    </thead>
                    <tbody id="tbody_details_products">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.close') }}</button>
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
                    ajax: "{{ route('shopping_list') }}",
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
                                                            <a class="dropdown-item" href="`+ data.edit_url +`"><i class="fal fa-edit mr-1"></i>{{ __('messages.edit') }}</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ondelete('`+data.delete_url+`')"><i class="fal fa-trash-alt mr-1"></i>{{ __('messages.delete') }}</a>
                                                        </div>
                                                    </div>`;
                                return dropdown;
                            }
                        },
                        {
                            orderable: false,
                            className: "text-center align-middle",
                            id: "date_of_issue",
                            data:'date_of_issue'
                        },

                        {
                            className: "align-middle",
                            id: "supplier",
                            data:'supplier'
                        },
                        {
                            id: "purchase_number",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "align-middle",
                            render: function(data){
                                let html = `<span class="m-0">`+data.purchase_number+`</span><br>
                                            <code>`+data.description+`</code>
                                            `;
                                return html;
                            }
                        },
                        {
                            id: "products",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "text-center",
                            render: function(data){
                                let dropdown = `<a class="btn btn-default  btn-sm-er mr-1" href="javascript:void(0)" onclick="showProducts('`+data.products_url+`','`+data.purchase_number+`')">
                                                    <i class="fal fa-eye"></i>
                                                </a>`;
                                return dropdown;
                            }
                        },
                        {
                            className: "align-middle text-center",
                            id: "coin",
                            data:'coin'
                        },
                        {
                            className: "align-middle text-right",
                            id: "total",
                            data:'total'
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
                                window.location.href = "{{ route('logistics_warehouse_shopping_created') }}";
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
        function showProducts(url,doc){
            $.ajax({
                type : 'GET',
                url : url,
                dataType : 'json',
                success : function(data) {
                    let html = ``;
                    $.each(data, function(i, item) {
                        console.log(item)
                        html += `<tr>
                            <td class="text-center">`+(i+1)+`</td>
                            <td class="text-center"><img src="{{ asset('storage/items/`+item.item_id+`.jpg')}}" width=50px height=50px ></img></td>
                            <td class="text-center">`+item.code+`</td>
                            <td>`+item.description+`</td>
                            <td class="text-right">`+item.quantity+`</td>
                            <td class="text-right">`+item.total+`</td>
                        </tr>`;
                    });
                    $('#tbody_details_products').html(html);
                },
            }) ;
            $('#exampleModalLabelDetalle').html('DOC: '+doc);
            $('#exampleModalDetalle').modal('show');
        }
    </script>
    @endsection
</x-app-layout>
