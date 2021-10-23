<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/js/formplugins/combotree/bitcombotree-style.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.logistics')</li>
            <li class="breadcrumb-item active">@lang('messages.entry')</li>
            <li class="breadcrumb-item"><a href="{{ route('warehouse_fishing') }}">@lang('messages.fishing')</a></li>
            <li class="breadcrumb-item active">@lang('messages.new')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class='fal fa-info-circle'></i> @lang('messages.new') @lang('messages.entry')
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
                @livewire('warehouse.fishing-create-form')
            </div>
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/combotree/bitcombotree-js.js') }}"></script>
    <script defer>
        $(document).ready(function(){

            $('#pais_desde').select2();
            $('#pais_llegada').select2();

            $('#ubigeo_desde').bitcombotree();
            $('#ubigeo_llegada').bitcombotree();

            let controls = {
                leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
                rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>'
            }

            $('#datepicker-6').datepicker({
                format: 'dd/mm/yyyy',
                language:"{{ app()->getLocale() }}",
                autoclose:true
            });
            $('#datepicker-7').datepicker({
                format: 'dd/mm/yyyy',
                language:"{{ app()->getLocale() }}",
                autoclose:true
            });

            //////select
            $("#select2-ajax").select2({
                ajax:{
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('search_customer') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return {
                            customer: params.term,
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
                return repo.name;
            }

            var markup = "<div class='select2-result-repository clearfix d-flex'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.number +"</span>"+ repo.name + "</div>"+
                "<div class='select2-result-repository__statistics d-flex fs-sm mt-2'>" +
                "<div class='select2-result-repository__forks'><i class='fal fa-map-marker-alt mr-2'></i>" + repo.country_name + "&nbsp;|&nbsp;" + repo.department_name + "</div>" +
                "<div class='select2-result-repository__stargazers'>&nbsp;|&nbsp;" + repo.province_name + "</div>" +
                "<div class='select2-result-repository__watchers'>&nbsp;|&nbsp;" + repo.district_name + "</div>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo){
            return repo.name || repo.id;
        }

    </script>
    @endsection
</x-app-layout>
