<div>
    <ul class="breadcrumb">
        <li><a href="{{ route('onlineshop_public_home') }}">Inicio</a> <span class="divider">/</span></li>
        <li><a href="products.html">Items</a> <span class="divider">/</span></li>
        <li class="active">Vista previa</li>
    </ul>	
    <div class="well well-small">
        <div class="row-fluid">
            <div class="span5">
                <div id="myCarousel" class="carousel slide cntr">
                    <div class="carousel-inner">
                        @foreach(json_decode($product->images) as $key => $image)
                        <div class="item {{ $key == 0 ? 'active' : '' }}">
                            <a href="#"> <img src="{{ url('storage/'.$image->url) }}" alt="" style="width:100%"></a>
                        </div>
                        @endforeach
                    </div>
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">‹</a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">›</a>
                </div>
            </div>
            <div class="span7">
                <h3>{{ $this->product->title }} [{{ $product->price }}]</h3>
                <hr class="soft"/>
                    
                <form class="form-horizontal qtyFrm">
                    <div class="control-group">
                        <label class="control-label"><span>{{ number_format($price_total, 2, '.', ' ') }}</span></label>
                        <div class="controls">
                            <input type="number" class="span6" placeholder="Qty." wire:model="quantity">
                         </div>
                    </div>
                    
                    <div class="control-group" style="display: none">
                        <label class="control-label"><span>Color</span></label>
                        <div class="controls">
                            <select class="span11">
                                <option>Red</option>
                                <option>Purple</option>
                                <option>Pink</option>
                                <option>Red</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group" style="display: none">
                        <label class="control-label"><span>Materials</span></label>
                        <div class="controls">
                            <select class="span11">
                                <option>Material 1</option>
                                <option>Material 2</option>
                                <option>Material 3</option>
                                <option>Material 4</option>
                            </select>
                        </div>
                    </div>
                    <h4>{{ round($this->product->stock) }} Artículos en stock</h4>
                    <p>{{ $this->product->description }}<p>
                    <button type="submit" class="shopBtn"><span class=" icon-shopping-cart"></span> Añadir a la cesta</button>
                </form>
            </div>
        </div>
    </div>
</div>
