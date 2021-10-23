<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/js/formplugins/combotree/bitcombotree-style.css') }}">

    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.logistics')</li>
            <li class="breadcrumb-item">@lang('messages.production')</li>
            <li class="breadcrumb-item"><a href="{{ route('logistics_production_projects') }}">@lang('messages.projects')</a></li>
            <li class="breadcrumb-item active">@lang('messages.new')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-person-dolly"></i> @lang('messages.projects')
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
                @livewire('logistics.production.project-create-form')
            </div>
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/dependency/moment/moment.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/combotree/bitcombotree-js.js') }}"></script>
    <script src="{{ url('theme/js/formplugins/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            $('#datepicker-1').daterangepicker({
                locale:{
                    format: 'DD/MM/YYYY'
                },
                opens: 'left'
            }, function(start, end, label){
                datesSelects(start.format('YYYY-MM-DD'),end.format('YYYY-MM-DD'))
            });

            $('#ubigeo').bitcombotree();

            $("#select2-ajax").select2({
                ajax:{
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('logistics_production_projects_responsable') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params){
                        return {
                            responsable: params.term,
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
            $("#select3-ajax").select2({
                ajax:{
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('logistics_production_projects_client') }}",
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
                return repo.trade_name;
            }

            var markup = "<div class='select2-result-repository clearfix d-flex'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.number +"</span>"+ repo.trade_name + "</div>"+
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo){
            return repo.trade_name || repo.id;
        }
    </script>
    @endsection
</x-app-layout>
