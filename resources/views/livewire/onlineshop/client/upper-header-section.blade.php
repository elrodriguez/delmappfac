@php
    $path = explode('/', request()->path());
@endphp
<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="topNav">
		<div class="container">
			<div class="alignR">
				<div class="pull-left socialNw">
					@foreach($social_media as $item)
						@if($item->social_media_name == 'Facebook')
							<a href="{{ $item->url_event }}" target="_blank"><span class="icon-facebook"></span></a>
						@elseif($item->social_media_name == 'Twitter')
							<a href="{{ $item->url_event }}" target="_blank"><span class="icon-twitter"></span></a>
						@elseif($item->social_media_name == 'Youtube')
							<a href="{{ $item->url_event }}" target="_blank"><span class="icon-youtube"></span></a>
						@elseif($item->social_media_name == 'WhatsApp')
							<a href="{{ $item->url_event }}" target="_blank"><span class="icon-whatsApp"></span></a>
						@endif
					@endforeach
				</div>
				<a class="{{ ($path[0]=='store' && $path[1]=='home' ? 'active':'') }}" href="{{ route('onlineshop_public_home') }}"> <span class="icon-home"></span> Inicio</a> 
				@if (Route::has('login'))
                    @auth
					<a class="{{ ($path[0]=='store' && $path[1]=='my_account' ? 'active':'') }}" href="{{ route('onlineshop_public_myaccount') }}"><span class="icon-user"></span> Mi cuenta</a> 
                    @else
                        @if (Route::has('register'))
							<a class="{{ ($path[0]=='store' && $path[1]=='register' ? 'active':'') }}" href="{{ route('onlineshop_public_register') }}"><span class="icon-edit"></span> Registrate Gratis </a> 
                        @endif
                    @endauth
                @endif
				<a class="{{ ($path[0]=='store' && $path[1]=='contact' ? 'active':'') }}" href="{{ route('onlineshop_public_contact') }}"><span class="icon-envelope"></span> Contactenos</a>
				<a href="cart.html"><span class="icon-shopping-cart"></span> 2 Item(s) - <span class="badge badge-warning"> $448.42</span></a>
			</div>
		</div>
	</div>
</div>
