<div class="well well-small">
    <h3>Nuevos Productos </h3>
    <hr class="soften"/>
    <div class="row-fluid">
        <div id="newProductCar" class="carousel slide">
            <div class="carousel-inner">
                <div class="item active">
                    <ul class="thumbnails">
                        @php
                            $item = 1;
                        @endphp
                        @foreach($new_products as $new_product)
                            <li class="span3">
                                <div class="thumbnail">
                                    <a class="zoomTool" href="{{ route('onlineshop_public_product_details',$new_product->seo_url) }}" title="add to cart"><span class="icon-search"></span> VISTA RÁPIDA</a>
                                    <a href="#" class="tag"></a>
                                    <a href="{{ route('onlineshop_public_product_details',$new_product->seo_url) }}">
                                        <img src="{{ asset('storage/'.$new_product->image) }}" alt="bootstrap-ring">
                                    </a>
                                </div>
                            </li>
                            @if($item == 4)
                                </ul>
                            </div>
                            <div class="item">
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
                </div>
            </div>
            <a class="left carousel-control" href="#newProductCar" data-slide="prev">&lsaquo;</a>
            <a class="right carousel-control" href="#newProductCar" data-slide="next">&rsaquo;</a>
        </div>
    </div>
    <div class="row-fluid">
        <ul class="thumbnails">
            @php
                $count = 1;
            @endphp
            @foreach($products as $product)
                <li class="span4">
                    <div class="thumbnail">
                        <a class="zoomTool" href="{{ route('onlineshop_public_product_details',$product->seo_url) }}" title="add to cart"><span class="icon-search"></span> VISTA RÁPIDA</a>
                        <a href="{{ route('onlineshop_public_product_details',$product->seo_url) }}"><img src="{{ asset('storage/'.$product->image) }}" alt=""></a>
                        <div class="caption cntr">
                            <p>{{ $product->title }}</p>
                            <p><strong> {{ $product->price }}</strong></p>
                            <h4><a class="shopBtn" href="#" title="add to cart"> Añadir a la cesta </a></h4>
                            <div class="actionList">
                                <a class="pull-left" href="#"> Te gusta </a> 
                                <a class="pull-left" href="#"> Comparar </a>
                            </div> 
                            <br class="clr">
                        </div>
                    </div>
                </li>
                @if($count == 3)
                    </ul>
                    <ul class="thumbnails">
                    @php
                        $count = 1;
                    @endphp
                @else
                    @php
                        $count++;
                    @endphp
                @endif
            @endforeach
        </ul>
    </div>
</div>
