<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">Configuración del sistema</li>
            <li class="breadcrumb-item"><a href="{{ route('users_activity_log') }}">{{ __('messages.user_activities') }}</a></li>
            <li class="breadcrumb-item active">{{ __('messages.see_details') }}</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='fal fa-radar'></i> {{ __('messages.see_details') }}
            </h1>
        </div>
    </x-slot>

    @livewire('master.user-activity-log-details',['user_id' => $id])

    @section('script')
    <script src="{{ url('theme/js/dependency/moment/moment.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}" defer></script>
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
                    setDatesEndStart(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'));
                    //console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                });
            });

        </script>
    @endsection
</x-app-layout>
