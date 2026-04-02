@extends('website.layout.structure')
@section('content')

<!-- NAVIGATION -->
<nav id="navigation">
	<div class="container">
		<div id="responsive-nav">
			<ul class="main-nav nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
			</ul>
		</div>
	</div>
</nav>

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
	<div class="container">
		<h3 class="breadcrumb-header">Checkout</h3>
	</div>
</div>

<!-- SECTION -->
<div class="section">
	<div class="container">
		<div class="row">

			<form action="{{ route('place.order') }}" method="POST">
				@csrf

				<div class="col-md-7">
					<div class="billing-details">
						<div class="section-title">
							<h3 class="title">Billing Details</h3>
						</div>

						<!-- ✔ customer_name -->
						<div class="form-group">
							<input class="input" type="text" name="customer_name" required placeholder="Full Name">
						</div>

						<!-- ✔ customer_phone -->
						<div class="form-group">
							<input class="input" type="text" name="customer_phone" required placeholder="Phone Number">
						</div>

						<!-- ✔ customer_email -->
						<div class="form-group">
							<input class="input" type="email" name="customer_email" placeholder="Email (optional)">
						</div>

						<!-- ✔ customer_address -->
						<div class="form-group">
							<input class="input" type="text" name="customer_address" required placeholder="Address">
						</div>

						<!-- ✔ note -->
						<div class="form-group">
							<textarea class="input" name="note" placeholder="Order Notes (optional)"></textarea>
						</div>
					</div>
				</div>

				<!-- RIGHT SIDE — ORDER SUMMARY -->
				<div class="col-md-5 order-details">
					<div class="section-title text-center">
						<h3 class="title">Your Order</h3>
					</div>

					<div class="order-summary">
						<div class="order-col">
							<strong>PRODUCT</strong>
							<strong>TOTAL</strong>
						</div>

						@foreach($cartItems as $item)
							<div class="order-col">

								<!-- ✔ RIGHT: product_name DB se agaya query ke through -->
								<div>{{ $item->qty }}x {{ $item->product_name }}</div>

								<div>₹{{ $item->total_price }}</div>
							</div>
						@endforeach

						<div class="order-col">
							<div>Shipping</div>
							<div><strong>FREE</strong></div>
						</div>

						<div class="order-col">
							<strong>TOTAL</strong>
							<strong class="order-total">₹{{ $cartItems->sum('total') }}</strong>
						</div>
					</div>

					<!-- ✔ payment_method -->
					<div class="form-group">
						<label><strong>Select Payment Method:</strong></label><br>
						<label><input type="radio" name="payment_method" value="COD" checked> Cash on Delivery</label><br>
						<label><input type="radio" name="payment_method" value="Online"> Online Payment</label>
					</div>

					<button type="submit" class="primary-btn order-submit">Place Order</button>
				</div>
			</form>

		</div>
	</div>
</div>

@endsection