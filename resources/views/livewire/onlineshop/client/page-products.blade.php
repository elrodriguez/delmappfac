<div>
    <div class="well well-small">
        <h3>Nuestros productos</h3>
        <div class="row-fluid">
            <ul class="thumbnails">
                @php
                    $item = 1;
                @endphp
                @foreach($products as $product)
                    <li class="span4">
                        <div class="thumbnail">
                            <a href="{{ route('onlineshop_public_product_details',$product->seo_url) }}" class="overlay"></a>
                            <a class="zoomTool" href="{{ route('onlineshop_public_product_details',$product->seo_url) }}" title="add to cart"><span class="icon-search"></span> VISTA RÁPIDA</a>
                            <a href="{{ route('onlineshop_public_product_details',$product->seo_url) }}"><img src="{{ url('storage/'.$product->image) }}" alt=""></a>
                            <div class="caption cntr">
                                <p>{{ $product->title }}</p>
                                <p><strong> {{ $product->price }}</strong></p>
                                <h4><a class="shopBtn" href="#" title="add to cart"> Añadir a la cesta </a></h4>
                                <div class="actionList" style="display: none">
                                    <a class="pull-left" href="#">Add to Wish List </a> 
                                    <a class="pull-left" href="#"> Add to Compare </a>
                                </div> 
                                <br class="clr">
                            </div>
                        </div>
                    </li>
                    @if($item == 3)
                        </ul>
                    </div>
                    <div class="row-fluid">
                        <ul class="thumbnails">
                        @php
                            $item = 1;
                        @endphp
                    @else
                        @php
                            $item++;
                        @endphp
                    @endif
                @endforeach
            </ul>
            {{ $products->links() }}
        </div>
    </div>
</div>
