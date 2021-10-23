@php
    $ticket_b = \App\Models\Support\Helpdesk\SupTicket::find(mydecrypt($id));
    $user_b = \App\Models\Support\Administration\SupServiceAreaUser::where('user_id',auth()->user()->id)->first();
@endphp
<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/datagrid/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/fa-solid.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/miscellaneous/reactions/reactions.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/select2/select2.bundle.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/css/bootstrap-editable.css') }}">
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/toastr/toastr.css') }}">
    @endsection
    <x-slot name="header">
        <ol class="breadcrumb page-breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0);">{{ config('app.name', 'Laravel') }}</a></li>
            <li class="breadcrumb-item">@lang('messages.technical_support')</li>
            <li class="breadcrumb-item">@lang('messages.help_desk')</li>
            <li class="breadcrumb-item"><a href="{{ route('support_helpdesk_ticket') }}">@lang('messages.ticket')</a></li>
            <li class="breadcrumb-item active">@lang('messages.attend')</li>
            <li class="position-absolute pos-top pos-right d-none d-sm-block">@livewire('js-get-date')</li>
        </ol>
        <div class="subheader">
            <h1 class="subheader-title">
                <i class="fal fa-receipt"></i> {{ __('messages.ticket') }}
            </h1>
        </div>
    </x-slot>
    <div class="row">
        <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
            @livewire('support.helpdesk.ticket-attend-form', ['ticket_id' => $id])
            @if($ticket_b->sup_service_area_id == 1)
                @livewire('support.helpdesk.ticket-attend-solution-register', ['ticket_id' => $id])
            @endif
        </div>
        <div class="col-lg-6 col-xl-3 order-lg-2 order-xl-2">
            @livewire('support.helpdesk.ticket-attend-chat-form', ['ticket_id' => $id])
            @if($user_b->sup_service_area_id == $ticket_b->sup_service_area_id)
                @livewire('support.helpdesk.ticket-attend-resend', ['ticket_id' => $id])
            @endif
        </div>
        <div class="col-lg-12 col-xl-6 order-lg-3 order-xl-3 mt-3">
            @livewire('support.helpdesk.ticket-attend-suggest-list', ['ticket_id' => $id])
        </div>
    </div>

    @section('script')
    <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/select2/select2.bundle.js') }}" defer></script>
    <script src="{{ url('theme/js/formplugins/x-editable-develop/dist/bootstrap4-editable/js/bootstrap-editable.min.js') }}"></script>
    <script src="{{ url('theme/js/notifications/toastr/toastr.js') }}"></script>
    <script defer>
        $(document).ready(function(){
            $('#chat-attend-ticket').scrollTop( $('#chat-attend-ticket').prop('scrollHeight') );
            // $("#select6-ajax").select2({
            //     ajax:{
            //         headers: {
            //             'X-CSRF-TOKEN': "{{ csrf_token() }}"
            //         },
            //         type: 'POST',
            //         url: "{{ route('support_administration_area_users_search_users') }}",
            //         dataType: 'json',
            //         delay: 250,
            //         data: function(params){
            //             return {
            //                 search: params.term,
            //                 page: params.page
            //             };
            //         },
            //         processResults: function(response, params){
            //             params.page = params.page || 1;
            //             return {
            //                 results: response.data,
            //                 pagination:{
            //                     more: (params.page * 30) < response.recordsFiltered
            //                 }
            //             };
            //         },
            //         cache: true
            //     },
            //     placeholder: '{{ __("messages.search") }}',escapeMarkup: function(markup){
            //         return markup;
            //     },
            //     minimumInputLength: 1,
            //     templateResult: formatRepo,
            //     templateSelection: formatRepoSelection
            // });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });
            $('#version_sicmact').editable({
                validate: function(value,params) {
                    if($.trim(value) == '') {
                        return "{{ __('messages.this_field_is_required') }}";
                    }
                },
                url: "{{ route('support_helpdesk_ticket_version_sicmact_update') }}",
                success: function(data, config) {
                    let tit = data.data.tit;
                    let msg = data.data.msg;
                    let ico = data.data.ico;
                    alertToastr(tit,msg,ico);
                },
                error: function(errors) {
                    console.log(errors)
                }
            });
        });
        // function formatRepo(repo){
        //         if (repo.loading){
        //             return repo.trade_name;
        //         }

        //         var markup = "<div class='select2-result-repository clearfix d-flex'>" +
        //             "<div class='select2-result-repository__avatar mr-2'><img src='" + repo.profile_photo_path + "' class='width-2 height-2 mt-1 rounded' /></div>" +
        //             "<div class='select2-result-repository__meta'>" +
        //             "<div class='select2-result-repository__title fs-lg fw-500'><span class='badge border border-dark text-dark mr-1'>" + repo.number +"</span></div>"+
        //             "<div class='select2-result-repository__description fs-xs opacity-80 mb-1'>" + repo.trade_name + "</div>"+
        //             "<div class='select2-result-repository__statistics d-flex fs-sm mt-2'>" +
        //             "</div>" +
        //             "</div></div>";

        //         return markup;
        //     }

        // function formatRepoSelection(repo){
        //     return repo.trade_name || repo.id;
        // }
        
        function alertToastr(tit,msg,ico){
            Command: toastr[ico](msg, tit)
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-bottom-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": 300,
                "hideDuration": 100,
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        }
    </script>
    @endsection
</x-app-layout>
