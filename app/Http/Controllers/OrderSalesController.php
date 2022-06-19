<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrderSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Orders::with('dishes')->orderby('order_time' , 'desc')->paginate(10);
        return view('cms.order_sales.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Orders::with('dishes')->find($id);
        $singleOrder = Orders::find($id);
        return view('cms.order_sales.show', ['order' => $order , 'singleOrder' => $singleOrder]);
    }

    public function toOrdersBetweenDate() {
        return view('cms.order_sales.orders', ['orders' => null]);
    }

    public function ordersBetweenDate(Request $request) {

        $orders = Orders::where('order_time', '>=', $request->start_time)
            ->where('order_time', '<=', $request->end_time)->get();
        $totalprice = 0;
        foreach($orders as $order) {
            foreach($order->dishes as $dish) {
                $totalprice += ($dish->pivot->amount * $dish->price);
            }
        }

        return view('cms.order_sales.orders', ['orders' => $orders , 'totalprice' => $totalprice]);

    }
}
