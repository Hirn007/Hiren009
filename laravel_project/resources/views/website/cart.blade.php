@extends('website.layout.structure')

@section('content')

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <ul class="breadcrumb-tree">
            <li><a href="/">Home</a></li>
            <li class="active">Your Cart</li>
        </ul>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h3 class="title" style="margin-bottom:20px;">Your Shopping Cart</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($cartItems->isEmpty())
                    <div style="text-align:center; padding:50px 0;">
                        <i class="fa fa-shopping-cart" style="font-size:60px; color:#ccc;"></i>
                        <h4 style="margin-top:20px; color:#888;">Your cart is empty!</h4>
                        <a href="/" class="primary-btn" style="display:inline-block; margin-top:15px;">Continue Shopping</a>
                    </div>
                @else
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr style="background:#D10024; color:#fff;">
                                <th>Image</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($cartItems as $item)
                            @php $grandTotal += $item->total_price; @endphp
                            <tr>
                                <td>
                                    <img src="{{ url('upload/product/'.$item->image) }}" width="70" height="70" style="object-fit:cover; border-radius:4px;">
                                </td>
                                <td style="vertical-align:middle;"><strong>{{ $item->product_name }}</strong></td>
                                <td style="vertical-align:middle;">{{ $item->qty }}</td>
                                <td style="vertical-align:middle;">₹{{ number_format($item->price, 2) }}</td>
                                <td style="vertical-align:middle;">₹{{ number_format($item->total_price, 2) }}</td>
                                <td style="vertical-align:middle;">
                                    <a href="{{ route('cart.delete', $item->cart_id) }}" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Remove this item?')">
                                        <i class="fa fa-trash"></i> Remove
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" style="text-align:right;"><strong>Grand Total:</strong></td>
                                <td><strong style="color:#D10024; font-size:18px;">₹{{ number_format($grandTotal, 2) }}</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                    <div style="text-align:right; margin-top:20px;">
                        <a href="/" class="primary-btn" style="display:inline-block; margin-right:10px;">
                            <i class="fa fa-arrow-left"></i> Continue Shopping
                        </a>
                        <a href="{{ url('/checkout') }}" class="primary-btn" style="display:inline-block; background:#D10024;">
                            Proceed to Checkout <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
<!-- /SECTION -->

@endsection