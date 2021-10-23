<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.logistics')</li>
            <li class="breadcrumb-item">@lang('messages.warehouse')</li>
            <li class="breadcrumb-item">@lang('messages.inventory')</li>
            <li class="breadcrumb-item active">@lang('messages.kardex_report')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-analytics"></i> @lang('messages.kardex_report')
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
                            <div class="col-md-5 mb-3">
                                <label class="form-label">{{ __('messages.product') }} <span class="text-danger">*</span> </label>
                                <div>
                                    <select name="item_id" id="select2-ajax"></select>
                                </div>
                                <div id="msg_item_id" class="invalid-feedback-2" style="display:none">{{ __('validation.required',['attribute' => 'Producto']) }}</div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">{{ __('messages.warehouse') }} <span class="text-danger">*</span> </label>
                                <select name="warehouse_id" id="warehouse_id" class="custom-select form-control">
                                    <option value="">{{ __('messages.to_select') }}</option>
                                    @foreach ($warehouses as $warehouse)
                                        <option value="{{ $warehouse->id }}">{{ $warehouse->description }}</option>
                                    @endforeach
                                </select>
                                <div id="msg_warehouse_id" class="invalid-feedback-2" style="display:none">{{ __('validation.required',['attribute' => 'Almacen']) }}</div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">@lang('messages.date')<span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="custom-range">
                                    <div class="input-group-append">
                                        <span class="input-group-text fs-xl">
                                            <i class="fal fa-calendar"></i>
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" id="date_start" name="date_start" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                <input type="hidden" id="date_end" name="date_end" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                <div id="msg_date_start" class="invalid-feedback-2" style="display:none">{{ __('validation.required',['attribute' => 'Fecha inicio']) }}</div>
                                <div id="msg_date_end" class="invalid-feedback-2" style="display:none">{{ __('validation.required',['attribute' => 'Fecha Fin']) }}</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
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
                                    {{-- <th>{{ __('messages.code') }}</th>
                                    <th>{{ __('messages.image') }}</th>
                                    <th>{{ __('messages.product') }}</th> --}}
                                    <th>{{ __('messages.date') }}</th>
                                    <th>Tipo transacción</th>
                                    <th>{{ __('messages.number') }}</th>
                                    <th>{{ __('messages.f_issuance') }}</th>
                                    <th>{{ __('messages.entry_kardex') }}</th>
                                    <th>{{ __('messages.exit_kardex') }}</th>
                                    <th>Saldo</th>
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
    <script src="{{ url('theme/js/dependency/moment/moment.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script defer>
        function zeroFill( value, length ){
            return (value.toString().length < length) ? PadLeft("0" + value, length) : value;
        }
        $(document).ready(function(){
            $('#custom-range').daterangepicker({
                "showDropdowns": true,
                "showWeekNumbers": true,
                "showISOWeekNumbers": true,
                "timePicker": true,
                "timePicker24Hour": true,
                "timePickerSeconds": true,
                "autoApply": true,
                "maxSpan":
                {
                    "days": 7
                },
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Limpiar',
                    fromLabel: 'Desde',
                    toLabel: 'Hasta',
                    customRangeLabel: 'Seleccionar rango',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                        'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre',
                        'Diciembre'],
                    firstDay: 1
                },
                ranges:{
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Los últimos 7 días': [moment().subtract(6, 'days'), moment()],
                    'Últimos 30 días': [moment().subtract(30, 'days'), moment()],
                    'Este mes': [moment().startOf('month'), moment().endOf('month')],
                    'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                "alwaysShowCalendars": true,
                "applyButtonClasses": "btn-default shadow-0",
                "cancelClass": "btn-success shadow-0"
            }, function(start, end, label){
                $('#date_start').val(start.format('YYYY-MM-DD'));
                $('#date_end').val(end.format('YYYY-MM-DD'));
            });

            $("#select2-ajax").select2({
                ajax:{
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('logistics_warehouse_items_search_autocomplete') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return {
                            search: params.term,
                            page: params.page
                        };
                    },
                    processResults: function(response, params){
                        params.page = params.page || 1;
                        return {
                            results: response.data,
                            pagination:{
                                more: (params.page * 30) < response.recordsFiltered
                            }
                        };
                    },
                    cache: true
                },
                placeholder: '{{ __("messages.search") }}',escapeMarkup: function(markup){
                            return markup;
                },
                minimumInputLength: 1,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            $('#dt-basic-example').dataTable({
                responsive: true,
                searching: false,
                language: {
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
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    method: "POST",
                    url: "{{ route('logistics_warehouse_inventory_kardex_report') }}",
                    data: function (d) {
                        return $.extend({}, d, {
                            "item_id": $('#select2-ajax').val(),
                            "date_start": $('#date_start').val(),
                            "date_end": $('#date_end').val(),
                            "warehouse_id": $('#warehouse_id').val()
                        });
                    }
                },
                columns: [
                    // { orderable:false,className: "align-middle",id: "internal_id",data:'internal_id',name:'items.internal_id' },
                    // { data: 'id',
                    //       className: "align-middle",
                    //         render: function(data){
                    //             return `<img src="{{ asset('storage/items/`+data+`.jpg')}}" width=50px height=50px  ></img>`;
                    //         }
                    // },
                    // { orderable:false,className: "align-middle",id: "description",data:'description',name:'items.description' },
                    { orderable:false,className: "align-middle text-center",id: "created_at",data:'created_at',name:'inventory_kardex.created_at' },
                    { orderable:false,className: "align-middle",id: "transaction_type",data:'transaction_type',name:'transaction_type' },
                    { orderable:false,className: "align-middle",id: "number",data:'number',name:'number' },
                    { orderable:false,className: "align-middle text-center",id: "date_of_issue",data:'date_of_issue',name:'inventory_kardex.date_of_issue' },
                    { orderable:false,className: "align-middle text-right",id: "quantity_entry",data:'quantity_entry',name:'quantity_entry' },
                    { orderable:false,className: "align-middle text-right",id: "quantity_exit",data:'quantity_exit',name:'quantity_exit' },
                    { orderable:false,className: "align-middle text-right",id: "balance",data:'balance',name:'balance' },
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
            
            let p = document.getElementById('select2-ajax').value;
            let a = document.getElementById('warehouse_id').value;
            let s = document.getElementById('date_start').value;
            let e = document.getElementById('date_end').value;

            if(p == null || p == ''){
                document.getElementById('msg_item_id').style.display='block';
            }else{
                document.getElementById('msg_item_id').style.display='none';
            }
            if(a == null || a == ''){
                document.getElementById('msg_warehouse_id').style.display='block';
            }else{
                document.getElementById('msg_warehouse_id').style.display='none';
            }
            if(s == null || s == ''){
                document.getElementById('msg_date_start').style.display='block';
            }else{
                document.getElementById('msg_date_start').style.display='none';
            }
            if(e == null || e == ''){
                document.getElementById('msg_date_end').style.display='block';
            }else{
                document.getElementById('msg_date_end').style.display='none';
            }

            $('#dt-basic-example').DataTable().draw();
        }

        function formatRepo(repo){
            if (repo.loading){
                return repo.description;
            }

            var markup = "<div class='select2-result-repository clearfix d-flex'>" +
                "<div class='select2-result-repository__avatar mr-2'><img src='" + repo.image_url + "' class='width-2 height-2 mt-1 rounded' /></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.internal_id +"</span></div>"+
                "<div class='select2-result-repository__description fs-xs opacity-80 mb-1'>" + repo.description + "</div>"+
                "<div class='select2-result-repository__statistics d-flex fs-sm mt-2'>" +
                "<div class='select2-result-repository__forks'>Marca: " + (repo.name?repo.name:'') + "</div>" +
                //"<div class='select2-result-repository__stargazers'>&nbsp;|&nbsp;stock:&nbsp;" + repo.stock + "</div>" +
                //"<div class='select2-result-repository__watchers'>&nbsp;|&nbsp;" + repo.district_name + "</div>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo){
            return repo.description || repo.id;
        }
    </script>
    @endsection
</x-app-layout>
