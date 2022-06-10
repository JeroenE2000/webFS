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
            'dishes' => 'required|array|min:1',
            'discount' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required|',
        ]);
        if($request->input('start_time') > $request->input('end_time')) {
            return redirect()->route('discounts.index')->withErrors(['error' => 'De startijd moet voor de eindtijd zijn']);
        }

        //for loop in the dishes array to check in the pivot table if the dish already got a discount between start_time and end_time
        foreach($request->input('dishes') as $dish) {
            $discount = Dishes::join('dishes_history_of_discounts', 'dishes.id', '=', 'dishes_history_of_discounts.dishes_id')
                        ->join('history_of_discounts', 'dishes_history_of_discounts.history_of_discounts_id', '=', 'history_of_discounts.id')
                        ->where('history_of_discounts.start_time', '<=', $request->input('start_time'))
                        ->where('history_of_discounts.end_time', '>=', $request->input('end_time'))
                        ->where('dishes.id', $dish)
                        ->get();
            if(count($discount) > 0) {
                return redirect()->route('discounts.index')->withErrors(['error' => 'Er is al een korting voor deze gerechten tussen deze tijd']);
            }
        }
        $history = new HistoryOfDiscounts();
        $history->discount = $request->input('discount');
        $history->start_time = $request->input('start_time');
        $history->end_time = $request->input('end_time');
        $history->save();

        $newDiscount = HistoryOfDiscounts::get()->last();
        $dishes = $request->input('dishes');
        foreach($dishes as $dishId){
            $newDiscount->Dishes()->save(Dishes::find($dishId));
        }

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
        return view('cms.sales.edit', [
            'discount' => $discount,
            'dishes' => $dishes
        ]);
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
            'dishes' => 'required|array|min:1',
            'discount' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

       $discount = Dishes::join('dishes_history_of_discounts', 'dishes.id', '=', 'dishes_history_of_discounts.dishes_id')
            ->join('history_of_discounts', 'dishes_history_of_discounts.history_of_discounts_id', '=', 'history_of_discounts.id')
            ->where('history_of_discounts.start_time', '<=', $request->input('start_time'))
            ->where('history_of_discounts.end_time', '>=', $request->input('end_time'))
            ->get();

        if(count($discount) > 0) {
            $this->updateDiscount($request, $id);
            return redirect()->route('discounts.index')->with('success', 'Korting aangepast');
        } else {
            if($request->input('start_time') > $request->input('end_time')) {
                return redirect()->route('discounts.edit', $id)->withErrors(['error' => 'De startijd moet voor de eindtijd zijn']);
            }

            $discount = Dishes::join('dishes_history_of_discounts', 'dishes.id', '=', 'dishes_history_of_discounts.dishes_id')
                ->join('history_of_discounts', 'dishes_history_of_discounts.history_of_discounts_id', '=', 'history_of_discounts.id')
                ->where('history_of_discounts.start_time', '<=', $request->input('start_time'))
                ->where('history_of_discounts.end_time', '>=', $request->input('end_time'))
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
        $discount->discount = $request->input('discount');
        $discount->start_time = $request->input('start_time');
        $discount->end_time = $request->input('end_time');
        $discount->save();
        $dishes = $request->input('dishes');
        $discount->Dishes()->detach();
        if($dishes != null) {
            foreach($dishes as $dishid) {
                $discount->Dishes()->save(Dishes::find($dishid));
            }
        }
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

    public function getSales() {
        $sales = HistoryOfDiscounts::all();
        $dishes = Dishes::all();
        return view('guest.sales', compact('sales', 'dishes'));
    }
}
