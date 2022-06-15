<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dishes;
use App\Models\Orders;
use App\Models\Tables;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\HistoryOfDiscounts;
use Illuminate\Support\Facades\Auth;
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
        $tables = Tables::all();
        return view('order.index' , compact('tables'));
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

    public function storeTableNumber(Request $request)
    {
        $request->validate([
            'number' => 'required|min:0'
        ]);
        $table = Tables::where('table_number', $request->number)->first();
        if(!$table) {
            return redirect(route('order'))->withErrors(['error' => 'Tafelnummer bestaat niet']);
        }

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

    public function shoppingCart()
    {
        $dishes = Dishes::all();
        $sales = HistoryOfDiscounts::where('start_time', '<=', date('Y-m-d H:i:s'))
                ->where('end_time', '>=', date('Y-m-d H:i:s'))
                ->get();
        $tempsales = [];
        foreach($sales as $sale) {
            foreach($sale->dishes()->get() as $dish) {
                $tempsales[$dish->id] = $dish->price * (1 - ($sale->discount/100));
            }
        }
        $sales = (object)$tempsales;

        return view('order.shopping_cart', ['dishes' => $dishes, 'sales' => $sales]);
    }

    public function saveOrder(Request $request)
    {
        $dish_ids = $request->input('dishIds');
        $amounts = $request->input('amounts');
        $remarks = $request->input('remarks');

        if(session('ordered_time')) {
            $difference = Carbon::now()->diffInMinutes(Carbon::parse(session('ordered_time')), true);
            if($difference <= 10) {
                $minutesUntilNextOrder = 10 - $difference;
                return redirect(route('getShoppingCart'))->with('alert-danger', 'De volgende bestelling kan geplaatst worden over: '.$minutesUntilNextOrder.' minuten');
            }
        }
        Session::put('ordered_time', Carbon::now());
        $table = Tables::where('table_number', session('table_number'))->first();

        $ordertime = date('Y-m-d H:i:s');

        $order = Orders::create([
            'table_id' => $table->id,
            'have_payed' => 0,
            'order_time' => $ordertime
            ]);

        $table->users()->attach(Auth::user()->id, [
            'start_time' => $ordertime,
            'end_time' => null
        ]);

        for($index = 0; $index < count($dish_ids); $index++){
            $dish = Dishes::find($dish_ids[$index]);
            if($dish->Discounts->count() > 0) {
                foreach ($dish->Discounts()->get() as $sale){
                    if($sale->start_time <= date('Y-m-d H:i:s') && $sale->end_time >= date('Y-m-d H:i:s')){
                        $order->dishes()->attach($dish_ids[$index], [
                            'amount' => $amounts[$index],
                            'notation' => $remarks[$index],
                            'price' =>  $dish->price = $dish->price * (1 - ($sale->discount/100))
                        ]);
                    }
                }
            } else {
                $order->dishes()->attach($dish_ids[$index], [
                    'amount' => $amounts[$index],
                    'notation' => $remarks[$index],
                    'price' => $dish->price
                ]);
            }
        }
        return redirect(route('tableCategories'))->with('alert-success', 'Bestelling geplaatst!');
    }

    public function checkOutPage()
    {
        return view('order.check_out', ['tableNumber' => session('table_number')]);
    }

    public function checkOutAndLogOut(Request $request)
    {
        if(session('table_number') == null) {
            return redirect(route('checkOutPage'))->with('warning', 'U moet eerst een tafelnummer kiezen voordat je kan uitchecken!');
        }
        $table = Tables::where('table_number', session('table_number'))->first();
        $table->users()->wherePivot('end_time', null)
        ->wherePivot('users_id', Auth::user()->id)->wherePivot('table_id', $table->id)
        ->updateExistingPivot(Auth::user()->id, ['end_time' => date('Y-m-d H:i:s')]);
        Session::flush();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
