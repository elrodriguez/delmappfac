<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/css/bootstrap-editable.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.logistics')</li>
            <li class="breadcrumb-item">@lang('messages.warehouse')</li>
            <li class="breadcrumb-item"><a href="{{ route('logistics_warehouse_proyectos_orden') }}">@lang('messages.project_orders')</a></li>
            <li class="breadcrumb-item active">@lang('messages.materials')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-boxes"></i> @lang('messages.materials')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.materials')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                @livewire('logistics.warehouse.project-order-materials-form', ['project_id' => $id])
            </div>
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
    <script defer>
        $(document).ready(function(){
            xeditableLoad();
            $("#item-id-ajax").select2({
                ajax:{
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('logistics_production_projects_search_items') }}",
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
        });
        function formatRepo(repo){
            if (repo.loading){
                return repo.description;
            }

            var markup = "<div class='select2-result-repository clearfix d-flex'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.internal_id +"</span>"+ repo.description + "</div>"+
                "<div class='select2-result-repository__statistics d-flex fs-sm mt-2'>" +
                "<div class='select2-result-repository__forks'><i class='fal fa-barcode-alt mr-2'></i> Marca: " + (repo.name?repo.name:'') + "</div>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo){
            return repo.description || repo.id;
        }

        function xeditableLoad(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $('.xeditablequantity').editable({
                validate: function(value) {
                    if($.trim(value) == '') {
                        return "{{ __('messages.this_field_is_required') }}";
                    }

                    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
                    if(preg.test(value) === false){
                        return 'Este campo no es valido';
                    }
                },
                url: "{{ route('logistics_production_projects_update_quantity') }}",
                success: function(data, config) {
                    materialsListReload();
                },
                error: function(errors) {
                    console.log(errors)
                }
            });
            // $('.xeditableprice').editable({
            //     validate: function(value) {
            //         if($.trim(value) == '') {
            //             return "{{ __('messages.this_field_is_required') }}";
            //         }
            //         var regexp = new RegExp("/^([0-9]+\.?[0-9]{0,2})$/");
            //         if (regexp.test(value)) {
            //             return 'Este campo no es valido';
            //         }
            //     },
            //     url: "{{ route('logistics_production_projects_update_price') }}",
            //     success: function(data, config) {
            //         materialsListReload();
            //     },
            //     error: function(errors) {
            //         console.log(errors)
            //     }
            // });
        }
    </script>
    @endsection
</x-app-layout>
