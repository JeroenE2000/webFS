<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Orders;
use App\Models\Tables;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cartList()
    {
        $cartItems = \Cart::getContent();
        $tables = Tables::all();
        $user = User::where('role_id', 4)->get();
        return view('cms.cart.index', compact('cartItems' , 'tables' , 'user'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');
        return redirect()->route('dishes.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity,
                ],
                'description' => $request->description,
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return redirect()->route('cart.index');
    }

    public function checkout(Request $request)
    {
        $cartItems = \Cart::getContent();
        $order = new Orders();
        if ($request->input('table_id') != "") {
            $order->table_id = $request->input('table_id');
        }
        $order->have_payed = 0;
        $order->order_time = date('Y-m-d H:i:s');
        $order->save();
        $newOrder = Orders::latest()->first();
        foreach($cartItems as $cartItem) {
            $newOrder->dishes()->attach($cartItem->id,['amount' => $cartItem->quantity, 'price' => $cartItem->price, 'notation' => $cartItem->description]);
        }
        if ($request->input('table_id') != "" && $request->input('user_id') != "") {
            $table = Tables::where('id', $request->input('table_id'))->first();
            $ordertime = date('Y-m-d H:i:s');
            $table->users()->attach($request->input('user_id'), [
                'start_time' => $ordertime,
                'end_time' => $ordertime
            ]);
        }

        if($request->input('table_id') != "" && $request->input('user_id') == "") {
            return redirect(route('cart.index'))->with('warning', 'Er is geen gebruiker gekozen voor deze tafel');
        }
        \Cart::clear();
        return redirect(route('orders.index'))->with('success', 'De bestelling is geplaatst');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('cart.index');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect()->route('cart.index');
    }
}
