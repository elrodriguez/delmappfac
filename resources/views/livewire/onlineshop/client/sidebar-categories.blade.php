<div class="well well-small">
    <ul class="nav nav-list">
        @foreach ($categories as $category)
            <li><a href="{{ route('onlineshop_public_products',$category->id) }}"><span class="icon-chevron-right"></span>{{ $category->name }}</a></li>
        @endforeach
        <li style="border:0"> &nbsp;</li>
        <li> <a class="totalInCart" href="cart.html"><strong>Total Amount  <span class="badge badge-warning pull-right" style="line-height:18px;">$448.42</span></strong></a></li>
    </ul>
</div>
