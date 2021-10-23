<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/statistics/chartist/chartist.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/statistics/chartjs/chartjs.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
    </x-slot>

    @if ($PRT0001GN == 4)
        @livewire('dashboard.fishery')
    @elseif($PRT0001GN == 3)
        @livewire('dashboard.warehouse')
    @elseif($PRT0001GN == 5 || $PRT0001GN == 6)
        @livewire('dashboard.academic')
    @elseif($PRT0001GN == 7)
        @livewire('dashboard.drugstore')
    @endif
    @section('script')
        @if ($PRT0001GN == 4)
            <script src="{{ url('theme/js/statistics/chartist/chartist.js') }}" defer></script>
            <script defer>
                $(document).ready(function(){
                    distributedSeries();
                });
            </script>
        @elseif($PRT0001GN == 3)
            <script src="{{ url('theme/js/statistics/chartjs/chartjs.bundle.js') }}"></script>
            <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}"></script>
            <script defer>
                $(document).ready(function(){
                    $(".js-data-products-ajax").select2({
                        ajax:{
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            type: 'GET',
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
                        "<div class='select2-result-repository__avatar mr-2'><img src='" + repo.image_url + "' class='width-2 height-2 mt-1 rounded' /></div>" +
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
            </script>
        @endif
    @endsection
</x-app-layout>
