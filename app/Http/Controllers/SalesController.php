<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use Illuminate\Http\Request;
use App\Models\HistoryOfDiscounts;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #get all sales of products
        $sales = HistoryOfDiscounts::all();
        $dishes = Dishes::all();
        return view('cms.sales.index', compact('sales', 'dishes'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'dishes_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required|',
        ]);
        if($request->input('start_time') > $request->input('end_time')) {
            return redirect()->route('discounts.index')->withErrors(['error' => 'De startijd moet voor de eindtijd zijn']);
        }
        $discount = HistoryOfDiscounts::where('dishes_id', $request->input('dishes_id'))
            ->where('start_time', '<=', $request->input('start_time'))
            ->where('end_time', '>=', $request->input('end_time'))
            ->get();
        if(count($discount) > 0) {
            return redirect()->route('discounts.index')->withErrors(['error' => 'The dish already has a discount between this time']);
        }
        $history = new HistoryOfDiscounts();
        $history->dishes_id = $request->input('dishes_id');
        $history->discount = $request->input('discount');
        $history->start_time = $request->input('start_time');
        $history->end_time = $request->input('end_time');
        $history->save();

        return redirect()->route('discounts.index')->with('success', 'Korting toegevoegd');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $discount = HistoryOfDiscounts::find($id);
        $dishes = Dishes::all();
        $findDish = Dishes::find($discount->dishes_id);
        return view('cms.sales.edit', compact('discount', 'dishes' , 'findDish'));
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
        $request->validate([
            'dishes_id' => 'required|numeric',
            'discount' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required|',
        ]);
       #check if the discount is already in the database
        $discount = HistoryOfDiscounts::where('dishes_id', $request->input('dishes_id'))
            ->where('start_time', '=', $request->input('start_time'))
            ->where('end_time', '=', $request->input('end_time'))
            ->get();
        if(count($discount) > 0) {
            $this->updateDiscount($request, $id);
            return redirect()->route('discounts.index')->with('success', 'Korting aangepast');
        } else {
            if($request->input('start_time') > $request->input('end_time')) {
                return redirect()->route('discounts.edit', $id)->withErrors(['error' => 'De startijd moet voor de eindtijd zijn']);
            }
            $discount = HistoryOfDiscounts::where('dishes_id', $request->input('dishes_id'))
                ->where('start_time', '<=', $request->input('start_time'))
                ->where('end_time', '>=', $request->input('end_time'))
                ->get();
            if(count($discount) > 0) {
                return redirect()->route('discounts.edit', $id)->withErrors(['error' => 'The dish already has a discount between this time']);
            } else {
                $this->updateDiscount($request, $id);
                return redirect()->route('discounts.index')->with('success', 'Korting aangepast');
            }
        }
    }

    public function updateDiscount($request, $id)
    {
        $discount = HistoryOfDiscounts::find($id);
        $discount->dishes_id = $request->input('dishes_id');
        $discount->discount = $request->input('discount');
        $discount->start_time = $request->input('start_time');
        $discount->end_time = $request->input('end_time');
        $discount->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discount = HistoryOfDiscounts::find($id);
        $discount->delete();
        return redirect()->route('discounts.index')->with('success', 'Korting verwijderd');
    }
}
