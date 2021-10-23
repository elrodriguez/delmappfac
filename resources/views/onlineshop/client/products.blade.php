<x-shop-layout>
    <div class="row">
        <div id="sidebar" class="span3">
            @livewire('onlineshop.client.sidebar-categories')

            @livewire('onlineshop.client.discount-section')

            <br>
            <br>
            @livewire('onlineshop.client.low-price-products')

        </div>
        <div class="span9">
            @livewire('onlineshop.client.page-products',['search'=>$cat])
        </div>
    </div>
    <!-- 
    Clients 
    -->
    @livewire('onlineshop.client.brands')
</x-shop-layout>