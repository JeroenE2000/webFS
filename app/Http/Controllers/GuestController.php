<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\HistoryOfDiscounts;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        return view('guest.categories', ['categories' => $categories]);
    }

    public function getDishes($id) {
        $category = Categories::find($id);
        $dishes = Categories::find($id)->dishes;
        $sales = HistoryOfDiscounts::where('start_time', '<=', date('Y-m-d H:i:s'))
            ->where('end_time', '>=', date('Y-m-d H:i:s'))
            ->get();
        $tempsales = [];
        foreach($sales as $sale) {
            foreach($dishes as $dish) {
                if($dish->id == $sale->dishes_id) {
                    $tempsales[$dish->id] = $dish->price * (1 - ($sale->discount/100));
                }
            }
        }
        $sales = $tempsales;
        return view('guest.dishes', ['dishes' => $dishes, 'sales' => $sales, 'category' => $category]);
    }
}
