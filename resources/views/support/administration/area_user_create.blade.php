<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.technical_support')</li>
            <li class="breadcrumb-item">@lang('messages.administration')</li>
            <li class="breadcrumb-item"><a href="{{ route('support_administration_area_user') }}">@lang('messages.areas_and_user')</a></li>
            <li class="breadcrumb-item active">@lang('messages.new')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-user-headset"></i> @lang('messages.areas_and_user')
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
                @livewire('support.administration.area-user-create-form')
            </div>
        </div>
    </div>
    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}" defer></script>
    <script defer>
        $(document).ready(function(){
            $("#select2-ajax").select2({
                ajax:{
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: "{{ route('support_administration_area_users_search_users') }}",
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
                return repo.trade_name;
            }

            var markup = "<div class='select2-result-repository clearfix d-flex'>" +
                "<div class='select2-result-repository__avatar mr-2'><img src='" + repo.profile_photo_path + "' class='width-2 height-2 mt-1 rounded' /></div>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.number +"</span></div>"+
                "<div class='select2-result-repository__description fs-xs opacity-80 mb-1'>" + repo.trade_name + "</div>"+
                "<div class='select2-result-repository__statistics d-flex fs-sm mt-2'>" +
                "</div>" +
                "</div></div>";

            return markup;
        }

        function formatRepoSelection(repo){
            return repo.trade_name || repo.id;
        }
    </script>
    @endsection
</x-app-layout>
