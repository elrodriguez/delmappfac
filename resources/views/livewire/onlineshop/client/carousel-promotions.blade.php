<div class="well np">
    <div id="myCarousel" class="carousel slide homCar">
        <div class="carousel-inner">
            @foreach($promotions as $promotion)
            <div class="item">
                <img style="width:100%" src="{{ asset('storage/'.$promotion->image) }}" alt="{{ $promotion->title }}">
                <div class="carousel-caption">
                    <h4>{{ $promotion->title }}</h4><br>
                    <p><span>{{ $promotion->description }}</span></p>
                </div>
            </div>
            @endforeach
        </div>
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div>
</div>
