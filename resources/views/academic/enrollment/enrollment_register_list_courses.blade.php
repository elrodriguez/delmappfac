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
            <li class="breadcrumb-item">@lang('messages.enrollment')</li>
            <li class="breadcrumb-item active">@lang('messages.enrolled_course')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-line-columns"></i> {{ __('messages.enrolled_course') }}
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>{{ __('messages.enrolled_course') }}</h2>
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
                                    <td class="align-middle" width="50px">{{ __('messages.actions') }}</td>
                                    <th class="align-middle">{{ __('messages.description') }}</th>
                                    <th class="align-middle">DNI</th>
                                    <th class="align-middle">{{ __('messages.name') }}</th>
                                    <th class="align-middle">{{ __('messages.address') }}</th>
                                    <th class="align-middle">{{ __('messages.email') }}</th>
                                    <th class="align-middle">{{ __('messages.birth_date') }}</th>
                                    <th class="align-middle">{{ __('messages.sex') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModalrepresentative" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">{{ __('messages.representative') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="bg-primary-500">
                        <tr>
                            <th class="align-middle text-center">DNI</th>
                            <th class="align-middle">{{ __('messages.name') }}</th>
                            <th class="align-middle">{{ __('messages.address') }}</th>
                            <th class="align-middle">{{ __('messages.email') }}</th>
                            <th class="align-middle text-center">{{ __('messages.birth_date') }}</th>
                            <th class="align-middle text-center">{{ __('messages.telephone') }}</th>
                            <th class="align-middle text-center">{{ __('messages.live_with_the_student') }}</th>
                            <th class="align-middle text-center">{{ __('messages.relationship') }}</th>
                            <th class="align-middle text-center">{{ __('messages.sex') }}</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-representative">
                    </tbody>
                </table>
                </div>
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
        function openModal(control){
            let representatives = JSON.parse(control.name);
            let html = '';
            representatives.forEach(element => {
                html +=`<tr>
                    <th class="align-middle text-center" scope="row">`+element.number+`</th>
                    <td class="align-middle">`+element.trade_name+`</td>
                    <td class="align-middle">`+element.address+`</td>
                    <td class="align-middle">`+element.email+`</td>
                    <td class="align-middle text-center">`+element.birth_date+`</td>
                    <td class="align-middle text-center">`+element.telephone+`</td>
                    <td class="align-middle text-center">`;
                        if(element.live_with_the_student == 1){
                            html +=`<span class="badge badge-primary">{{ __('messages.yes') }}</span>`;
                        }else{
                            html +=`<span class="badge badge-danger">{{ __('messages.no') }}</span>`;
                        }
                html +=` </td>
                    <td class="align-middle">`+element.relationship+`</td>
                    <td class="align-middle text-center">`;
                        if(element.sex == 'm'){
                            html +=` <i class="fal fa-3x fa-male" title="Masculino"></i>`;
                        }else{
                            html +=` <i class="fal fa-3x fa-female" title="Femenino"></i>`;
                        }
                html +=` </td>
                </tr>`;
            });
            $('#tbody-representative').html(html);
            $('#exampleModalrepresentative').modal('show');
        }
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
                ajax: "{{ route('enrollment_cadastre_list_courses') }}",
                columns: [
                    {
                        id: "accions",
                        data: null,
                        searchable:false,
                        orderable:false,
                        className: "align-middle text-center",
                        render: function(data){
                            let buttons = `<div class="dropdown">
                                                    <a href="javascript:void(0)" class="btn btn-info rounded-circle btn-icon waves-effect waves-themed" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fal fa-cogs"></i>
                                                    </a>
                                                    <div class="dropdown-menu" style="">
                                                        <a class="dropdown-item" name='`+JSON.stringify(data.student_representative)+`' onclick="openModal(this)" href="javascript:void(0)"><i class="fal fa-user-friends mr-1"></i>{{ __('messages.representative') }}</a>
                                                    </div>
                                                </div>`;
                            return buttons;
                        }
                    },
                    {
                        id: "summary",
                        data: null,
                        //searchable:false,
                        orderable:false,
                        name: "academic_levels.description",
                        className: "align-middle text-left",
                        render: function(data){
                            let html = `<strong>`+data.level_description+`</strong><br>
                                            <span>`+data.year_description+`</span>`;
                            return html;
                        }
                    },
                    { className: "align-middle",id: "number",data:'number',name:'people.number' },
                    { className: "align-middle",id: "trade_name",data:'trade_name',name:'people.trade_name' },
                    { className: "align-middle",id: "address",data:'address',name:'people.address' },
                    { className: "align-middle",id: "email",data:'email',name:'people.email' },
                    { className: "align-middle",id: "birth_date",data:'birth_date',name:'people.birth_date' },
                    {
                        data: null,
                        searchable:false,
                        orderable:false,
                        className: "text-center align-middle",
                        render: function(data){
                            if(data.sex == 'm'){
                                return `<i class="fal fa-3x fa-male" title="Masculino"></i>`;
                            }else{
                                return `<i class="fal fa-3x fa-female" title="Femenino"></i>`;
                            }
                        }
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
                            window.location.href = "{{ route('enrollment_register') }}";
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

    </script>
    @endsection
</x-app-layout>
