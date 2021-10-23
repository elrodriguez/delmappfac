<x-shop-layout>
    <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/formplugins/bootstrap-datepicker/bootstrap-datepicker.css') }}">
    <div class="row">
        <div id="sidebar" class="span3">
            @livewire('onlineshop.client.sidebar-categories')

            @livewire('onlineshop.client.discount-section')

            <br>
            <br>
            @livewire('onlineshop.client.low-price-products')

        </div>
        <div class="span9">
            @livewire('onlineshop.client.page-register')
        </div>
    </div>
    <!-- 
    Clients 
    -->
    @livewire('onlineshop.client.brands')
    <script src="{{ url('theme/js/formplugins/bootstrap-datepicker/bootstrap-datepicker.js') }}" defer></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", function(event) { 
            $('#date_of_birth').datepicker({
                format: 'yyyy/mm/dd',
                language:"es",
                autoclose:true
            });
        });
    </script>
</x-shop-layout>