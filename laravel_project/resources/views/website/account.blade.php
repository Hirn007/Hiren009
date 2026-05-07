@extends('website.layout.structure')
@section('content')

<!-- BREADCRUMB -->
<div id="breadcrumb" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="breadcrumb-header">My Account</h3>
                <ul class="breadcrumb-tree">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">My Account</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- /BREADCRUMB -->

<!-- SECTION -->
<div class="section">
    <div class="container">
        <div class="row">
            
            <!-- User Profile Sidebar -->
            <div class="col-md-3">
                <div class="section-title">
                    <h4 class="title">Profile</h4>
                </div>
                <div class="billing-details">
                    <div class="form-group">
                        <strong>Name:</strong> <br> {{ $user->name }}
                    </div>
                    <div class="form-group">
                        <strong>Email:</strong> <br> {{ $user->email }}
                    </div>
                    <a href="{{ url('/logout') }}" class="primary-btn">Logout</a>
                </div>
            </div>
            
            <!-- Orders List -->
            <div class="col-md-9">
                <div class="section-title">
                    <h4 class="title">My Orders</h4>
                </div>
                
                @if($orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Grand Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}</td>
                                    <td>
                                        @if($order->status == 'Pending')
                                            <span class="label label-warning">{{ $order->status }}</span>
                                        @elseif($order->status == 'Delivered')
                                            <span class="label label-success">{{ $order->status }}</span>
                                        @else
                                            <span class="label label-info">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $order->payment_method }}</td>
                                    <td>₹{{ $order->grand_total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        You haven't placed any orders yet. <a href="{{ url('/') }}">Start shopping!</a>
                    </div>
                @endif
                
            </div>
            
        </div>
    </div>
</div>
<!-- /SECTION -->

@endsection
