<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    @endsection
    @php
        $generico = \App\Models\Master\Person::where('trade_name','like','%Generico%')
            ->where('identity_document_type_id',0)
            ->select('people.id AS value',DB::raw('CONCAT(people.number," - ",people.trade_name) AS text'))
            ->first();
    @endphp
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.market')</li>
            <li class="breadcrumb-item">@lang('messages.sales')</li>
            <li class="breadcrumb-item active">@lang('messages.new_document')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-file-alt"></i> @lang('messages.new_document')
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-xl-12">
            <div id="panel-1" class="panel">
                <div class="panel-hdr">
                    <h2>@lang('messages.new')</h2>
                    <div class="panel-toolbar">
                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Collapse"></button>
                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Fullscreen"></button>
                        <button class="btn btn-panel" data-action="panel-close" data-toggle="tooltip" data-offset="0,10" data-original-title="Close"></button>
                    </div>
                </div>
                @livewire('market.sales.document-create-form')
            </div>
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/autocomplete-bootstrap/bootstrap-autocomplete.min.js') }}" defer></script>
    <script>
        $(document).ready(function(){

            $("#datepicker-1").datepicker({
                format: 'dd/mm/yyyy',
                language:"{{ app()->getLocale() }}",
                autoclose:true
            }).datepicker('setDate','0');

            $("#datepicker-2").datepicker({
                format: 'dd/mm/yyyy',
                language:"{{ app()->getLocale() }}",
                autoclose:true
            }).datepicker('setDate','0');

            //////select

            $('.basicAutoComplete').autoComplete().on('autocomplete.select', function (evt, item) {
                //console.log(item.value)
                selectCustomer(item.value);
            });

            $('.basicAutoComplete').autoComplete('set', { value: "{{ $generico->value }}", text: "{{ $generico->text }}" });


            $("#select3-ajax").select2({
                ajax:{
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('market_sales_products_search') }}",
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
                templateResult: formatRepop,
                templateSelection: formatRepoSelectionp
            });
        });
        function formatRepo(repo){
            if (repo.loading){
                return repo.trade_name;
            }

            var markup = "<div class='select2-result-repository clearfix d-flex'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.number +"</span>"+ repo.trade_name + "</div>"+
                "<div class='select2-result-repository__statistics d-flex fs-sm mt-2'>" +
                "<div class='select2-result-repository__forks'><i class='fal fa-map-marker-alt mr-2'></i>" + repo.country_name + "&nbsp;|&nbsp;" + repo.department_name + "</div>" +
                "<div class='select2-result-repository__stargazers'>&nbsp;|&nbsp;" + repo.province_name + "</div>" +
                "<div class='select2-result-repository__watchers'>&nbsp;|&nbsp;" + repo.district_name + "</div>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo){
            return repo.trade_name || repo.id;
        }

        function formatRepop(repo){
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
                "<div class='select2-result-repository__stargazers'>&nbsp;|&nbsp;stock:&nbsp;" + repo.stock + "</div>" +
                "<div class='select2-result-repository__watchers'>&nbsp;|&nbsp;Precio&nbsp;" + repo.sale_price + "</div>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelectionp(repo){
            return repo.description || repo.id;
        }
    </script>
    @endsection
</x-app-layout>
