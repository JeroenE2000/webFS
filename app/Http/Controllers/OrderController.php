<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\HistoryOfDiscounts;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(session('table_number')) {
            return redirect(route('tableCategories'));
        }
        return view('order.index');
    }

    public function getCategories()
    {
        if(!session('table_number'))
        {
            return redirect(route('order.index'));
        }
        $categories = Categories::all();
        return view('order.categories', [
            'categories' => $categories
        ]);
    }

    public function storeTableNumber(Request $request){
        $request->validate([
            'number' => 'required|min:0'
        ]);

        Session::put('table_number', $request->input('number'));
        return redirect(route('tableCategories'));
    }

    public function getDishes($id)
    {
        if(!session('table_number'))
        {
            return redirect(route('order.index'));
        }
        $category = Categories::find($id);
        $dishes = Categories::find($id)->dishes;
        $sales = HistoryOfDiscounts::where('start_time', '<=', date('Y-m-d H:i:s'))
            ->where('end_time', '>=', date('Y-m-d H:i:s'))
            ->get();
        $tempsales = [];
        foreach($sales as $sale) {
            foreach($sale->dishes()->get() as $dish) {
                $tempsales[$dish->id] = $dish->price * (1 - ($sale->discount/100));
            }
        }
        $sales = $tempsales;
        return view('order.orderdishes', ['dishes' => $dishes, 'sales' => $sales, 'category' => $category]);
    }

}
