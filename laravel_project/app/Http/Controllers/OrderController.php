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
        //
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
    public function destroy($id)
    {
        //
    }
}
