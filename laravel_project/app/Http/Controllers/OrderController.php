<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all(); // Model se data lo

        return view('admin.order_list', compact('orders'));
    }

    public function orderManagement()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('grand_total');
        
        $pendingOrders = Order::where('status', 'Pending')->count();
        $processingOrders = Order::where('status', 'Processing')->count();
        $shippedOrders = Order::where('status', 'Shipped')->count();
        $deliveredOrders = Order::where('status', 'Delivered')->count();
        
        $pendingPercent = $totalOrders > 0 ? round(($pendingOrders / $totalOrders) * 100) : 0;
        $processingPercent = $totalOrders > 0 ? round(($processingOrders / $totalOrders) * 100) : 0;
        $shippedPercent = $totalOrders > 0 ? round(($shippedOrders / $totalOrders) * 100) : 0;
        $deliveredPercent = $totalOrders > 0 ? round(($deliveredOrders / $totalOrders) * 100) : 0;

        return view('admin.order_management', compact(
            'totalOrders', 'totalRevenue', 'pendingOrders', 'deliveredOrders',
            'processingOrders', 'shippedOrders',
            'pendingPercent', 'processingPercent', 'shippedPercent', 'deliveredPercent'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderList()
    {
        return $this->index();
   }


    public function create()
    {
        $categories = Category::all();  // category table ka data fetch

        return view('admin.add_order', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->customer_phone = $request->customer_phone;
        $order->customer_email = $request->customer_email;
        $order->customer_address = $request->customer_address;
        $order->payment_method = $request->payment_method;
        $order->note = $request->note;
        $order->grand_total = 0;
        $order->status = 'Pending';
        $order->save();

        $grand_total = 0;
        if($request->has('product_id')) {
            for($i = 0; $i < count($request->product_id); $i++) {
                $item = new OrderItem();
                $item->order_id = $order->id;
                $item->product_id = $request->product_id[$i];
                $item->qty = $request->qty[$i];
                $item->price = $request->price[$i];
                $item->total = $request->qty[$i] * $request->price[$i];
                $item->save();
                
                $grand_total += $item->total;
            }
        }
        $order->grand_total = $grand_total;
        $order->save();

        return redirect('admin/orders')->with('success', 'Order created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.order_details', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        // delete related order items
        OrderItem::where('order_id', $id)->delete();
        $order->delete();

        return redirect()->back()->with('success', 'Order deleted successfully.');
    }

    public function destroy($id)
    {
        //
    }
}
