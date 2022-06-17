<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dishes;
use App\Models\Orders;
use App\Models\Tables;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\HistoryOfDiscounts;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Session;

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
            foreach($sale->dishes()->get() as $dish) {
                $tempsales[$dish->id] = $dish->price * (1 - ($sale->discount/100));
            }
        }
        $sales = $tempsales;
        return view('guest.dishes', ['dishes' => $dishes, 'sales' => $sales, 'category' => $category]);
    }

    public function pdfConverter() {
        $dishes = Dishes::all();
        $categories = Categories::all();
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
        $data = ['dishes'=>$dishes,'categories'=>$categories, 'sales' => $sales];
        $pdf = PDF::loadView('guest.menu-pdf', $data);
        return $pdf->stream();
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

        return view('guest.shopping_cart', ['dishes' => $dishes, 'sales' => $sales]);
    }

    public function order(Request $request)
    {
        $dish_ids = $request->input('dishIds');
        $amounts = $request->input('amounts');
        $remarks = $request->input('remarks');
        $table = Tables::where('table_number', session('table_number'))->first();

        $order = Orders::create([
                'have_payed' => 0,
                'order_time' => date('Y-m-d H:i:s')
        ]);
        //create new order
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
        if(session('order_ids')){
            Session::push('order_ids', $order->id);
        }else{
            Session::put('order_ids', [$order->id]);
        }
        return redirect(route('getQrCode' , $order->id));
    }

    public function QrCodeMaker($order_id) {
        if(session('order_ids') && in_array($order_id, session('order_ids'))) {
            $order = Orders::find($order_id);
            $dishes = $order->dishes()->get();
            $qr_code_string = 'Order id: '.$order->id.'||';
            $qr_code_string .= 'Gerechtnummers: ';
            for($i = 0; $i < count($dishes); $i++) {
                $dish = $dishes[$i];
                $qr_code_string .= $dish->dishnumber ? $dish->dishnumber : '';
                $qr_code_string .= $dish->dish_addition ? $dish->dish_addition : '';
                if($i != count($dishes)-1) {
                    $qr_code_string .= ', ';
                }
            }
            return view('order.qrcode', ['qr_code_string' => $qr_code_string])->with('success','De bestelling is geplaatst binnekort SMIKKELLEN MAAR');
        } else {
            abort(404, 'Qr code kan niet aangemaakt worden');
        }
    }
}
