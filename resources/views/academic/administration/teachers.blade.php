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
            <li class="breadcrumb-item active">@lang('messages.teachers')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-user-tie"></i> {{ __('messages.teachers') }}
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
                                    <th>DNI</th>
                                    <th>{{ __('messages.name') }}</th>
                                    <th>{{ __('messages.address') }}</th>
                                    <th>{{ __('messages.telephone') }}</th>
                                    <th>{{ __('messages.email') }}</th>
                                    <th>{{ __('messages.birth_date') }}</th>
                                    <th>{{ __('messages.sex') }}</th>
                                    <th>{{ __('messages.creation_date') }}</th>
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
                    ajax: "{{ route('academic_teachers_list') }}",
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
                                                            <a class="dropdown-item" href="`+ data.assign_courses_url +`"><i class="fal fa-books mr-1"></i>{{ __('messages.schooled_courses') }}</a>
                                                            <a class="dropdown-item" href="`+ data.assign_courses_free_url +`"><i class="fal fa-books mr-1"></i>{{ __('messages.reinforcement_training_courses') }}</a>
                                                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="ondelete('`+data.delete_url+`')"><i class="fal fa-trash-alt mr-1"></i>{{ __('messages.delete') }}</a>
                                                        </div>
                                                    </div>`;
                                return buttons;
                            }
                        },
                        { className: "align-middle",id: "number",data:'number',name:'people.number' },
                        { className: "align-middle",id: "trade_name",data:'trade_name',name:'people.trade_name' },
                        { className: "align-middle",id: "address",data:'address',name:'people.address' },
                        { className: "align-middle",id: "telephone",data:'telephone',name:'people.telephone' },
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
                        },
                        {
                            className: "align-middle",
                            id: "created_at",
                            data:'created_at',
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
                                window.location.href = "{{ route('academic_teachers_create') }}";
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
