<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Electro - HTML Ecommerce Template</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="{{ url('website/css/bootstrap.min.css') }}"/>

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="{{ url('website/css/slick.css') }}" />
	<link type="text/css" rel="stylesheet" href="{{ url('website/css/slick-theme.css') }}"/>

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="{{ url('website/css/nouislider.min.css') }}" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="{{ url('website/css/font-awesome.min.css') }}" />

	<!-- Custom stylesheet -->
	<link type="text/css" rel="stylesheet" href="{{ url('website/css/style.css') }}" />
</head>

<body>
	<!-- HEADER -->
<header>
    <!-- TOP HEADER -->
    <div id="top-header">
        <div class="container">
            <ul class="header-links pull-left">
                <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
                <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
                <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
            </ul>
            <ul class="header-links pull-right">
                <li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
                @auth
                    <li><a href="{{ route('user.account') }}"><i class="fa fa-user-o"></i> My Account</a></li>
                    <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a></li>
                @else
                    <li><a href="{{ url('/login') }}"><i class="fa fa-user-o"></i> Login</a></li>
                    <li><a href="{{ url('/sign-up') }}"><i class="fa fa-user-plus"></i> Sign Up</a></li>
                @endauth
            </ul>
        </div>
    </div>
    <!-- /TOP HEADER -->

    <!-- MAIN HEADER -->
    <div id="header">
        <div class="container">
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="{{ url('/') }}" class="logo">
                            <img src="{{ url('website/img/logo.png') }}" alt="Electro Logo">
                        </a>
                    </div>
                </div>
                <!-- /LOGO -->

                <!-- SEARCH BAR -->
                <div class="col-md-6">
                    <div class="header-search" style="position: relative;">
                        <form action="{{ url('/search') }}" method="GET">
                            <select class="input-select" name="category">
                                <option value="">All Categories</option>
                                <option value="1">Category 01</option>
                                <option value="2">Category 02</option>
                            </select>
                            <input class="input" type="text" name="query" id="ajax-search-input" placeholder="Search here" autocomplete="off">
                            <button class="search-btn" type="submit">Search</button>
                        </form>
                        <div id="ajax-search-results" style="position: absolute; top: 100%; left: 0; width: 100%; background: #fff; z-index: 999; border: 1px solid #E4E7ED; display: none; max-height: 400px; overflow-y: auto; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); border-radius: 0 0 4px 4px;"></div>
                    </div>
                </div>
                <!-- /SEARCH BAR -->

                <!-- ACCOUNT -->
                <div class="col-md-3 clearfix">
                    <div class="header-ctn">
                        <!-- Wishlist -->
                        <div>
                            <a href="{{ url('/wishlist') }}">
                                <i class="fa fa-heart-o"></i>
                                <span>Your Wishlist</span>
                                <div class="qty">2</div>
                            </a>
                        </div>
                        <!-- /Wishlist -->

                        <!-- Cart -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Your Cart</span>
                                <div class="qty">{{ \DB::table('cart')->count() }}</div>
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list">
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="{{ url('website/img/product01.png') }}" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">Product Name</a></h3>
                                            <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>
                                    <div class="product-widget">
                                        <div class="product-img">
                                            <img src="{{ url('website/img/product02.png') }}" alt="">
                                        </div>
                                        <div class="product-body">
                                            <h3 class="product-name"><a href="#">Product Name</a></h3>
                                            <h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
                                        </div>
                                        <button class="delete"><i class="fa fa-close"></i></button>
                                    </div>
                                </div>
                                <div class="cart-summary">
                                    <small>3 Item(s) selected</small>
                                    <h5>SUBTOTAL: $2940.00</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="{{ url('/cart') }}">View Cart</a>
                                    <a href="{{ url('/checkout') }}">Checkout <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <!-- /Cart -->

                        <!-- Menu Toggle -->
                        <div class="menu-toggle">
                            <a href="#">
                                <i class="fa fa-bars"></i>
                                <span>Menu</span>
                            </a>
                        </div>
                        <!-- /Menu Toggle -->
                    </div>
                </div>
                <!-- /ACCOUNT -->
            </div>
        </div>
    </div>
    <!-- /MAIN HEADER -->
</header>
<!-- /HEADER -->
 
</body>
</html>