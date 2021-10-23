<div>
    <header id="header">
        <div class="row">
            <div class="span4">
                <h1>
                    <a class="logo" href="{{ route('onlineshop_public_home') }}"><span>Twitter Bootstrap ecommerce template</span> 
                        @if(file_exists(public_path('storage/'.$configuration->logo)))
                            <img src="{{ url('storage/'.$configuration->logo) }}" alt="{{ $company->name }}" width="224" height="51" />
                        @else
                            <img src="{{ url('theme/img/logo.png') }}" alt="{{ $company->name }}" width="224" height="51">
                        @endif
                    </a>
                </h1>
            </div>
            <div class="span4">
                <div class="offerNoteWrapper">
                    <h1 class="dotmark">
                        <i class="icon-cut"></i>
                        Siguenos tambien en redes sociales
                    </h1>
                </div>
            </div>
            <div class="span4 alignR">
                <p><br> <strong> Support (24/7) : Cel.{{ $configuration->mobile_phone }} Tel.{{ $configuration->fixed_phone }}</strong><br><br></p>
                <span class="btn btn-mini">[ 2 ] <span class="icon-shopping-cart"></span></span>
                <span class="btn btn-warning btn-mini">$</span>
                <span class="btn btn-mini">&pound;</span>
                <span class="btn btn-mini">&euro;</span>
            </div>
        </div>
    </header>
</div>
