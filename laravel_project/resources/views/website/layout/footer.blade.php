	<!-- FOOTER -->
		<footer id="footer">
			<!-- top footer -->
			<div class="section">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">About Us</h3>
								<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut.</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>1734 Stonecoal Road</a></li>
									<li><a href="#"><i class="fa fa-phone"></i>+021-95-51-84</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>email@email.com</a></li>
									<li><a href="https://wa.me/{{ $setting->phone_number ?? '6355125225' }}" target="_blank"><i class="fa fa-whatsapp"></i>WhatsApp Us</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Categories</h3>
								<ul class="footer-links">
									<li><a href="#">Hot deals</a></li>
									<li><a href="#">Laptops</a></li>
									<li><a href="#">Smartphones</a></li>
									<li><a href="#">Cameras</a></li>
									<li><a href="#">Accessories</a></li>
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Information</h3>
								<ul class="footer-links">
									<li><a href="#">About Us</a></li>
									<li><a href="#">Contact Us</a></li>
									<li><a href="#">Privacy Policy</a></li>
									<li><a href="#">Orders and Returns</a></li>
									<li><a href="#">Terms & Conditions</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Service</h3>
								<ul class="footer-links">
									<li><a href="{{ route('user.account') }}">My Account</a></li>
									<li><a href="{{ route('view.cart') }}">View Cart</a></li>
									<li><a href="#">Wishlist</a></li>
									<li><a href="#">Track My Order</a></li>
									<li><a href="#">Help</a></li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /top footer -->

			<!-- bottom footer -->
			<div id="bottom-footer" class="section">
				<div class="container">
					<!-- row -->
					<div class="row">
						<div class="col-md-12 text-center">
							<ul class="footer-payments">
								<li><a href="#"><i class="fa fa-cc-visa"></i></a></li>
								<li><a href="#"><i class="fa fa-credit-card"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-paypal"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-mastercard"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-discover"></i></a></li>
								<li><a href="#"><i class="fa fa-cc-amex"></i></a></li>
							</ul>
							<span class="copyright">
								<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
							<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
							</span>
						</div>
					</div>
						<!-- /row -->
				</div>
				<!-- /container -->
			</div>
			<!-- /bottom footer -->
		</footer>
		<!-- /FOOTER -->

		<!-- jQuery Plugins -->
		<script src="{{url('website/js/jquery.min.js')}}"></script>
		<script src="{{url('website/js/bootstrap.min.js')}}"></script>
		<script src="{{url('website/js/slick.min.js')}}"></script>
		<script src="{{url('website/js/nouislider.min.js')}}"></script>
		<script src="{{url('website/js/jquery.zoom.min.js')}}"></script>
		<script src="{{url('website/js/main.js')}}"></script>

        <script>
            $(document).ready(function() {
                $('#ajax-search-input').on('keyup', function() {
                    let query = $(this).val();
                    if (query.length > 0) {
                        $.ajax({
                            url: "{{ route('product.ajax_search') }}",
                            type: "GET",
                            data: { query: query },
                            success: function(data) {
                                $('#ajax-search-results').empty();
                                if (data.length > 0) {
                                    $('#ajax-search-results').show();
                                    data.forEach(function(product) {
                                        let url = "{{ url('/product') }}/" + product.id;
                                        $('#ajax-search-results').append(
                                            '<div style="padding: 10px; border-bottom: 1px solid #E4E7ED; transition: background 0.3s;" onmouseover="this.style.background=\'#F8F9FA\'" onmouseout="this.style.background=\'transparent\'">' +
                                            '<a href="' + url + '" style="display: block; color: #333; text-decoration: none;">' +
                                            '<div style="display: flex; align-items: center;">' +
                                            '<img src="{{ url("upload/product") }}/' + product.image + '" style="width: 50px; height: 50px; margin-right: 15px; object-fit: cover; border-radius: 4px;">' +
                                            '<div>' +
                                            '<strong style="display: block; font-size: 14px; margin-bottom: 3px;">' + product.name + '</strong>' +
                                            '<span style="color: #D10024; font-weight: bold; font-size: 14px;">$' + product.price + '</span>' +
                                            '</div>' +
                                            '</div>' +
                                            '</a></div>'
                                        );
                                    });
                                } else {
                                    $('#ajax-search-results').show();
                                    $('#ajax-search-results').append('<div style="padding: 15px; text-align: center; color: #666;">No products found for "' + query + '"</div>');
                                }
                            }
                        });
                    } else {
                        $('#ajax-search-results').hide();
                        $('#ajax-search-results').empty();
                    }
                });

                // Hide results when clicking outside
                $(document).click(function(e) {
                    if (!$(e.target).closest('.header-search').length) {
                        $('#ajax-search-results').hide();
                    }
                });

                // Show results again when clicking the input if there's a query
                $('#ajax-search-input').click(function() {
                    if ($(this).val().length > 0 && $('#ajax-search-results').children().length > 0) {
                        $('#ajax-search-results').show();
                    }
                });
            });
        </script>
	</body>
</html>
