<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-colorpicker/bootstrap-colorpicker.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.onlineshop')</li>
            <li class="breadcrumb-item">@lang('messages.administration')</li>
            <li class="breadcrumb-item active">@lang('messages.products_and_services')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-boxes"></i> {{ __('messages.products_and_services') }}
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
                                    <th>{{ __('messages.image') }}</th>
                                    <th>{{ __('messages.code') }}</th>
                                    <th>{{ __('messages.description') }}</th>
                                    <th>{{ __('messages.brand') }}</th>
                                    <th>{{ __('messages.price_purchase') }}</th>
                                    <th>{{ __('messages.price_sale') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Right Large -->
    <div id="modalVirtualStore" class="modal fade default-example-modal-right-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-right">
            <div class="modal-content">
                
                    <div class="modal-header">
                        <h5 class="modal-title h4" id="labelVirtualStore">Large right side modal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form name="formVirtualStore" id="formVirtualStore" class="needs-validation" novalidate enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="item_id" id="item_id">
                            <input type="hidden" name="sho_item_id" id="sho_item_id">
                            <div class="row">
                                <div class="col-12">
                                    <div id="divFileOne"></div>
                                    <span id="spanGroupFile" class="text-lowercase mt-1"></span>
                                    <div class="d-flex flex-row-reverse">
                                        <button id="btnFileAdd" type="button" class="btn btn-xs btn-dark waves-effect waves-themed mt-2"><i class="fal fa-plus"></i></button>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div id="divColorOne"></div>
                                    <div class="d-flex flex-row-reverse">
                                        <button id="btnColorAdd" type="button" class="btn btn-xs btn-dark waves-effect waves-themed mt-2"><i class="fal fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="example-textarea">{{ __('messages.online_title') }}</label>
                                        <input type="text" class="form-control" name="online_title" id="online_title">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-6 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="example-textarea">{{ __('messages.online_price') }}</label>
                                        <input type="text" class="form-control" name="online_price" id="online_price">
                                    </div>
                                </div>
                                <div class="col-6 mt-2">
                                    <div class="form-group">
                                        <label class="form-label" for="example-textarea">{{ __('messages.online_stock') }}</label>
                                        <input type="text" class="form-control" name="online_stock" id="online_stock">
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('messages.description') }}</label>
                                        <textarea class="form-control" id="item_description" name="item_description" rows="3"></textarea>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('messages.state') }}</label>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="customState" checked name="item_state">
                                            <label class="custom-control-label" for="customState">{{ __('messages.active') }}</label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('messages.new_product') }}</label>
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="new_product" name="new_product">
                                            <label class="custom-control-label" for="new_product">{{ __('messages.active') }}</label>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="btnVirtualStoreClose">{{ __('messages.close') }}</button>
                        <button type="button" class="btn btn-primary" onclick="enviar_formulario()">{{ __('messages.save') }}</button>
                    </div>
            </div>
        </div>
    </div>

    @section('script')
    <script src="{{ url('theme/js/datagrid/datatables/datatables.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/datagrid/datatables/datatables.export.js') }}" defer></script>
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-colorpicker/bootstrap-colorpicker.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/validate-form/jquery.validate.min.js') }}"></script>
    <script defer>
            $(document).ready(function(){
                $('#cp1').colorpicker();
                $('[data-toggle="tooltip"]').tooltip();
                var table = $('#dt-basic-example').on( 'draw.dt', function () {
                    $('[data-toggle="tooltip"]').tooltip();
                }).on( 'click', 'tr', function () {
                    if ( $(this).hasClass('selected') ) {
                        $(this).removeClass('selected');
                    }
                    else {
                        table.$('tr.selected').removeClass('selected');
                        $(this).addClass('selected');
                    }
                }).dataTable({
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
                    ajax: "{{ route('onlineshop_administration_products_list') }}",
                    columns: [
                        {
                            id: "accions",
                            data: null,
                            searchable:false,
                            orderable:false,
                            className: "text-center align-middle",
                            render: function(data){
                                var buttons = `<button onclick="openModalVirtualStore(this)" data-ur='`+data.gallery_url+`' data-sh='`+data.sho_item+`' data-pk="`+data.id+`" data-de="`+data.description+`" data-pr="`+data.sale_unit_price+`" type="button" class="btn bg-primary-500 btn-icon rounded-circle waves-effect waves-themed btnVirtualStore" data-placement="right" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Tienda virtual">
                                                    <i class="fal fa-bags-shopping"></i>
                                                </button>`;
                                return buttons;
                            }
                        },
                        { data: 'image_url',
                          className: "align-middle text-center",
                          searchable:false,
                            render: function(data){
                                return `<img src="`+data+`" width=50px height=50px ></img>`;
                            }
                        },
                        { className: "align-middle",id: "internal_id",data:'internal_id',name:'items.internal_id' },
                        { className: "align-middle",id: "description",data:'description',name:'items.description' },
                        { className: "align-middle",id: "name",data:'name',name:'brands.name' },
                        { className: "align-middle text-right",searchable:false,orderable:false,id: "purchase_unit_price",data:'purchase_unit_price',name:'items.purchase_unit_price' },
                        { className: "align-middle text-right",searchable:false,orderable:false,id: "sale_unit_price",data:'sale_unit_price',name:'items.sale_unit_price' },
                    ],
                    dom:"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: []
                });

                $('#btnFileAdd').on('click',function( event ){
                    event.preventDefault();

                    let caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ2346789";
                    let iddx = "";
                    for (i=0; i<5; i++) iddx +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));

                    let html = `<div class="form-group" id="fl`+iddx+`">
                                    <label class="form-label">Imagen</label>
                                    <input type="file" id="inputGroupFile`+iddx+`" name="file[]">
                                    <button class="btn btn-outline-default waves-effect waves-themed" type="button" onclick="removeFile('fl`+iddx+`')">{{ __('messages.cancel') }}</button>
                                </div>`;
                    $('#divFileOne').append(html)
                });

                $('#btnColorAdd').on('click',function( event ){
                    event.preventDefault();

                    let caracteres = "abcdefghijkmnpqrtuvwxyzABCDEFGHJKMNPQRTUVWXYZ2346789";
                    let iddc = "";
                    for (i=0; i<5; i++) iddc +=caracteres.charAt(Math.floor(Math.random()*caracteres.length));

                    let html = `<div class="form-group" id="cpc`+iddc+`">
                                    <label class="form-label" for="inputGroupColor`+iddc+`">Color</label>
                                    <div id="cp`+iddc+`" class="input-group colorpicker-element" title="Using input value" data-colorpicker-id="2">
                                        <input type="text" class="form-control input-lg" value="#480A9C" name="item_color[]">
                                        <span class="input-group-append">
                                            <span class="input-group-text colorpicker-input-addon" data-original-title="" title="" tabindex="0"><i style="background: rgb(221, 15, 32);"></i></span>
                                            <button class="btn btn-outline-default waves-effect waves-themed" type="button" onclick="removeColor('cpc`+iddc+`')"><i class="fal fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>`;
                    $('#divColorOne').append(html);
                    $('#cp'+iddc).colorpicker();
                });

                $('#btnVirtualStoreClose').click( function () {
                    table.$('tr.selected').removeClass('selected');
                });
            });
            function removeFile(id) {
                $("#"+id).remove();
            }
            function removeColor(id) {
                $("#"+id).remove();
            }
            function openModalVirtualStore(element){
                let title = $(element).attr("data-de"); 
                let price = $(element).attr("data-pr");
                let id = $(element).attr("data-pk");
                let sho_item = $(element).attr("data-sh");
                let gallery_url = $(element).attr("data-ur");
                
                if(sho_item != 'null'){
                    $.each(JSON.parse(sho_item), function(i, item){
                        $('#sho_item_id').val(item.id);
                        $('#online_price').val(item.price);
                        $('#online_title').val(item.title);
                        $('#online_stock').val(item.stock);
                        $('#item_description').val(item.description);

                        if(item.state == 1){
                            $("#customState").attr("checked", true);
                        }else{
                            $("#customState").attr('checked',false); 
                        }

                        let html = '';
                        $('#divColorOne').empty();
                        $.each(item.color, function(i, cl){
                             html += `<div class="form-group" id="cpcx`+i+`">
                                    <label class="form-label" for="inputGroupColorx`+i+`">Color `+(i+1)+`</label>
                                    <div id="cpx`+i+`" class="input-group colorpicker-element cpx-color" title="Using input value" data-colorpicker-id="2">
                                        <input type="text" class="form-control input-lg" value="`+cl+`" name="item_color[]">
                                        <span class="input-group-append">
                                            <span class="input-group-text colorpicker-input-addon" data-original-title="" title="" ><i style="background: rgb(221, 15, 32);"></i></span>
                                            <button class="btn btn-outline-default waves-effect waves-themed" type="button" onclick="removeColor('cpcx`+i+`')"><i class="fal fa-times"></i></button>
                                        </span>
                                    </div>
                                </div>`;
                                
                        });
                        $('#divColorOne').append(html);
                        $('.cpx-color').colorpicker();
                        
                    });
                    let ctn = `Puede ver imágenes registradas anteriormente <a href="`+gallery_url+`">aquí</a>`;
                    $('#spanGroupFile').html(ctn);
                    $('#spanGroupFile').css('display','block');
                }else{
                    $("#customState").attr("checked", true);
                    $('#online_price').val(price);
                    $('#online_title').val(title);
                    $('#online_stock').val('');
                    $('#item_description').val('');
                    $('#sho_item_id').val('');
                    $('#spanGroupFile').css('display','none');
                    $('#divColorOne').empty();
                    let html = `<div class="form-group">
                                    <label class="form-label">Color</label>
                                    <div id="cp1" class="input-group colorpicker-element" title="Using input value" data-colorpicker-id="2">
                                        <input type="text" class="form-control input-lg" value="#DD0F20" name="item_color[]">
                                        <span class="input-group-append">
                                            <span class="input-group-text colorpicker-input-addon" data-original-title="" title="" tabindex="0"><i style="background: rgb(221, 15, 32);"></i></span>
                                        </span>
                                    </div>
                                </div>`;
                    $('#divColorOne').append(html);
                    $('#cp1').colorpicker();
                }

                $('#divFileOne').empty();
                let = divFile = `<div class="form-group">
                                    <label class="form-label" for="inputGroupFile">Imagen</label>
                                    <input type="file" id="inputGroupFile" name="file[]">
                                </div>`;

                $('#divFileOne').append(divFile);

                $('#labelVirtualStore').html(title);
                $('#item_id').val(id);
                $('#modalVirtualStore').modal('show');
                
            };
        </script>
        <script type="text/javascript">
            function enviar_formulario(){
                var form = $('#formVirtualStore');
                form.validate({
                    rules: {
                        item_description: {
                            required: true
                        },
                        online_price:{
                            required: true
                        },
                        online_stock:{
                            required: true
                        }
                    },
                    messages: {
                        item_description: {
                            required: 'Por favor, introduzca descripción'
                        },
                        online_price: {
                            required: 'Por favor, introduzca precio'
                        },
                        online_stock: {
                            required: 'Por favor, introduzca stock'
                        }
                    },
                    errorPlacement: function (error, element) {
                        error.insertAfter(element.parent());
                    }
                });
                if (form.valid()) {
                    var frm = document.getElementById('formVirtualStore');
                    var dataf = new FormData(frm);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('onlineshop_administration_products_save') }}",
                        data: dataf,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function(response){
                            if(response.success == true){
                                Swal.fire(response.tit,response.msg,response.ico);
                                if(response.act == 'store'){
                                    $('#modalVirtualStore').modal('hide')
                                }
                                $('#dt-basic-example').DataTable().ajax.reload();
                            }
                        },
                        error: function(result) {
                            console.log(result)
                        }
                    });
                    
                }
            } 
        </script>
    @endsection
</x-app-layout>
