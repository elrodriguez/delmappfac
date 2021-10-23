<div>
    <ul class="nav nav-list promowrapper">
        @foreach($products as $product)
        <li>
            <div class="thumbnail">
                <a class="zoomTool" href="{{ route('onlineshop_public_product_details',$product->seo_url) }}"><span class="icon-search"></span> VISTA RÁPIDA</a>
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->title }}">
                <div class="caption">
                <h4><a class="defaultBtn" href="{{ route('onlineshop_public_product_details',$product->seo_url) }}">VISTA</a> <span class="pull-right">{{ $product->price }}</span></h4>
                </div>
            </div>
        </li>
        <li style="border:0"> &nbsp;</li>
        @endforeach
    </ul>
</div>
