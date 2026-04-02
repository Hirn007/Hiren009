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

                <h3>Your Shopping Cart</h3>
                <br>

                @if($cartItems->isEmpty())
                    <h4>Your cart is empty!</h4>
                @else
                <table class="table table-bordered">
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>

                    @foreach($cartItems as $item)
                    <tr>
                        <td><img src="{{ url('uploads/products/'.$item->image) }}" width="60"></td>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ $item->price }}</td>
                        <td>${{ $item->total_price }}</td>
                    </tr>
                    @endforeach
                </table>
                @endif

            </div>

        </div>
    </div>
</div>
<!-- /SECTION -->

@endsection