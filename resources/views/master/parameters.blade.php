<x-app-layout>
    @section('styles')
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    @endsection
    <x-slot name="header">
        <div class="px-3 px-sm-5 pt-4">
            <h1 class="mb-4">
                @lang('messages.parameters')
            </h1>
        </div>
    </x-slot>
    @livewire('master.parameter-list')
    @livewire('master.parameter-create-modal')
    @livewire('master.parameter-edit-modal')
    @section('script')
        <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
        <script defer>
            function showModalParamter(){
                $('#create-parameters').modal('show');
            }
            function showModalParamterEdit(parameter_id){
                openthis(parameter_id);
            }
        </script>
    @endsection
</x-app-layout>
