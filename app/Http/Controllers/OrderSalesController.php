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
}
