<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Twitter Bootstrap shopping cart</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Bootstrap styles -->
        <link href="{{ asset('shop-cart/assets/css/bootstrap.css') }}" rel="stylesheet"/>
        <!-- Customize styles -->
        <link href="{{ asset('shop-cart/assets/css/style.css') }}" rel="stylesheet"/>
        <!-- font awesome styles -->
        <link href="{{ asset('shop-cart/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
            <!--[if IE 7]>
                <link href="css/font-awesome-ie7.min.css" rel="stylesheet">
            <![endif]-->

            <!--[if lt IE 9]>
                <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->

        <!-- Favicons -->
        <link rel="shortcut icon" href="{{ asset('shop-cart/assets/ico/favicon.ico') }}">
        <link rel="stylesheet" media="screen, print" href="{{ url('theme/css/notifications/sweetalert2/sweetalert2.bundle.css') }}">
    </head>
    <body>
    <!-- Upper Header Section -->
    @livewire('onlineshop.client.upper-header-section')

    

    <div class="container">
        <div id="gototop"> </div>

        <!--Lower Header Section -->

        @livewire('onlineshop.client.lower-header-section')

        <!-- Navigation Bar Section -->
        @livewire('onlineshop.client.navigation-bar-section')

        <!-- Body Section -->
            {{ $slot }}
        <!-- Footer -->
        @livewire('onlineshop.client.footer-section')
        </div><!-- /container -->
        @livewire('onlineshop.client.copyright-section')

        @livewireScripts
        <a href="#" class="gotop"><i class="icon-double-angle-up"></i></a>
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="{{ asset('shop-cart/assets/js/jquery.js') }}"></script>
        <script src="{{ asset('shop-cart/assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('shop-cart/assets/js/jquery.easing-1.3.min.js') }}"></script>
        <script src="{{ asset('shop-cart/assets/js/jquery.scrollTo-1.4.3.1-min.js') }}"></script>
        <script src="{{ asset('shop-cart/assets/js/shop.js') }}" async></script>
        <script src="{{ url('theme/js/notifications/sweetalert2/sweetalert2.bundle.js') }}" defer></script>
    </body>
</html>