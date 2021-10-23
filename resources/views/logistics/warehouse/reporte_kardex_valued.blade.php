<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.logistics')</li>
            <li class="breadcrumb-item">@lang('messages.warehouse')</li>
            <li class="breadcrumb-item">@lang('messages.inventory')</li>
            <li class="breadcrumb-item active">@lang('messages.kardex_valued')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-analytics"></i> @lang('messages.kardex_valued')
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
                        <form method="POST" action="{{ route('logistics_warehouse_inventory_inventory_report_valued_excel') }}">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">@lang('messages.date')<span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="custom-range">
                                        <div class="input-group-append">
                                            <span class="input-group-text fs-xl">
                                                <i class="fal fa-calendar"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="hidden" id="date_start" name="date_start">
                                    <input type="hidden" id="date_end" name="date_end">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="warehouse" class="form-label">{{ __('messages.establishment') }}</label>
                                    <select class="custom-select form-control" id="establishment_id" name="establishment_id">
                                        <option value="">{{ __('messages.to_select') }}</option>
                                        @foreach ($establishments as $establishment)
                                            <option value="{{ $establishment->id }}">{{ $establishment->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3 d-flex flex-row align-items-center">
                                    <button type="submit" class="btn btn-secondary ml-auto waves-effect waves-themed mr-3"><i class="fal fa-file-search mr-1"></i>{{ __('messages.report') }}</button>
                                    <button onclick="filterTable()" type="button" class="btn btn-primary waves-effect waves-themed" >
                                        <span class="fal fa-search mr-2" role="status" aria-hidden="true"></span>
                                        <span>{{ __('messages.search') }}</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-content border-faded border-left-0 border-right-0 border-bottom-0">
                        <table id="dt-basic-example" class="table table-bordered table-hover table-striped w-100">
                            <thead class="bg-primary-600">
                                <tr>
                                    <th>{{ __('messages.image') }}</th>
                                    <th>{{ __('messages.product') }}</th>
                                    <th>{{ __('messages.brand') }}</th>
                                    <th>Unidad</th>
                                    <th>Unidades físicas vendidas</th>
                                    <th>Costo unitario</th>
                                    <th>Valor de ventas</th>
                                    <th>Costo de producto</th>
                                    <th>Unidad valorizada</th>
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
    <script defer>
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
                        'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                        'Este mes': [moment().startOf('month'), moment().endOf('month')],
                        'El mes pasado': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    "alwaysShowCalendars": true,
                    "applyButtonClasses": "btn-default shadow-0",
                    "cancelClass": "btn-success shadow-0"
                }, function(start, end, label){
                    $('#date_start').val(start.format('YYYY-MM-DD'));
                    $('#date_end').val(end.format('YYYY-MM-DD'))
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
                    url: "{{ route('logistics_warehouse_inventory_inventory_report_Valued') }}",
                    data: function (d) {
                        return $.extend({}, d, {
                            "establishment_id": $('#establishment_id').val(),
                            "date_start": $('#date_start').val(),
                            "date_end": $('#date_end').val()
                        });
                    }
                },
                columns: [
                    { data: 'id',
                          className: "align-middle",
                            render: function(data){
                                return `<img src="{{ asset('storage/items/`+data+`.jpg')}}" width=50px height=50px  ></img>`;
                            }
                    },
                    { orderable:false,className: "align-middle",id: "description",data:'description',name:'items.description' },
                    { orderable:false,className: "align-middle",id: "name",data:'name',name:'brands.name' },
                    { orderable:false,className: "align-middle text-center",id: "unit_type_id",data:'unit_type_id',name:'items.unit_type_id' },
                    { orderable:false,className: "align-middle text-right",id: "item_quantity",data:'item_quantity'},
                    { orderable:false,className: "align-middle text-right",id: "purchase_unit_price",data:'purchase_unit_price'},
                    { orderable:false,className: "align-middle text-right",id: "item_total",data:'item_total'},
                    { orderable:false,className: "align-middle text-right",id: "item_cost",data:'item_cost'},
                    { orderable:false,className: "align-middle text-right",id: "valued_unit",data:'valued_unit'},
                ],
                dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                buttons: [

                ]
            });
        });
        function filterTable() {
            $('#dt-basic-example').DataTable().draw();
        }

        function exportExcel(){
            $.ajax({
                headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: "POST",
                url: "{{ route('logistics_warehouse_inventory_inventory_report_valued_excel') }}",
                data: {
                    "establishment_id": $('#establishment_id').val(),
                    "date_start": $('#date_start').val(),
                    "date_end": $('#date_end').val()
                },

            });
        }
    </script>
    @endsection
</x-app-layout>
