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
            @livewire('onlineshop.client.carousel-promotions')

            <!-- New Products -->
            @livewire('onlineshop.client.new-products')
            <!-- Featured Products -->
            @livewire('onlineshop.client.featured-products')

            <div class="well well-small">
                <a class="btn btn-mini pull-right" href="#">View more <span class="icon-plus"></span></a>
                Popular Products 
            </div>
            <hr>
            <div class="well well-small">
                <a class="btn btn-mini pull-right" href="#">View more <span class="icon-plus"></span></a>
                Best selling Products 
            </div>
        </div>
    </div>
    <!-- 
    Clients 
    -->
    @livewire('onlineshop.client.brands')
</x-shop-layout>