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

			@if(session('error'))
				<div class="alert alert-danger" style="margin-top: 20px;">
					{{ session('error') }}
				</div>
			@endif

			@if($errors->any())
				<div class="alert alert-danger" style="margin-top: 20px;">
					<ul>
						@foreach($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form id="checkout-form" action="{{ route('place.order') }}" method="POST">
				@csrf
				<input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">

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
							<div class="order-col" style="align-items: center; border-bottom: 1px solid #E4E7ED; padding-bottom: 15px; margin-bottom: 15px; display: flex;">
								<div style="width: 50px; margin-right: 15px;">
									<img src="{{ url('upload/product/' . $item->image) }}" alt="{{ $item->product_name }}" style="width: 100%; height: auto; object-fit: contain;">
								</div>
								<div style="flex: 1; text-align: left;">
									<strong>{{ $item->product_name }}</strong><br>
									<small style="color: #8D99AE;">{{ \Illuminate\Support\Str::limit($item->description, 40) }}</small>
								</div>
								<div style="text-align: right;">
									<div>{{ $item->qty }}x ₹{{ $item->product_price }}</div>
									<strong>₹{{ $item->total_price }}</strong>
								</div>
							</div>
						@endforeach

						<div class="order-col">
							<div>Shipping</div>
							<div><strong>FREE</strong></div>
						</div>

						<div class="order-col">
							<strong>TOTAL</strong>
							<strong class="order-total">₹{{ $cartItems->sum('total_price') }}</strong>
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

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('checkout-form').addEventListener('submit', function(e){
    var paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    
    if(paymentMethod === 'Online') {
        e.preventDefault(); // Stop default form submission for Online Payment

        var name = document.querySelector('input[name="customer_name"]').value;
        var email = document.querySelector('input[name="customer_email"]').value;
        var phone = document.querySelector('input[name="customer_phone"]').value;
        var totalAmount = {{ $cartItems->sum('total_price') * 100 }}; // Amount in paise

        if(totalAmount === 0) {
            alert("Cart is empty or total is zero.");
            return;
        }

        var options = {
            "key": "rzp_test_SjdsrKYNCTAMuL", // Razorpay Test Key ID
            "amount": totalAmount,
            "currency": "INR",
            "name": "E-Commerce Store",
            "description": "Order Payment",
            "handler": function (response){
                // On success, set the payment ID to hidden input and submit form programmatically
                document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                
                // Allow the form to submit normally now
                var form = document.getElementById('checkout-form');
                form.submit();
            },
            "prefill": {
                "name": name,
                "email": email,
                "contact": phone
            },
            "theme": {
                "color": "#D10024" // Matches store theme button color
            }
        };
        
        var rzp1 = new Razorpay(options);
        rzp1.on('payment.failed', function (response){
            alert("Payment Failed! Reason: " + response.error.description);
        });
        rzp1.open();
    }
});
</script>

@endsection