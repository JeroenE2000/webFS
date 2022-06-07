<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use App\Models\Allergies;
use App\Models\Categories;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(isset($request->dishsearch)) {
            $dishes = Dishes::where('name', 'like', '%' . $request->dishsearch . '%')
                ->orWhere('dishnumber', 'like', '%' . $request->dishsearch . '%')
                ->with('Allergies')
                ->with('Categories')
                ->get();
        } else {
            $dishes = Dishes::with('Allergies' , 'Categories')->get();
        }
        if(isset($request->category)) {
            $dishes = $dishes->where('categories_id', $request->category);
        }
        $categories = Categories::all();
        $allergies = Allergies::all();
        return view('cms.dishes.index' , ['dishes' => $dishes , 'categories' => $categories , 'allergies' => $allergies]);
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
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'spicness_scale' => 'required|integer|between:0,3',
            'dish_addition' => 'max:3'
        ]);

        $name = $request->input('name');
        $spiciness = $request->input('spiciness');
        $allergens = $request->input('allergens');
        $price = $request->input('price');
        $category_id = $request->input('category_id');
        $description = $request->input('description');
        $dish_additon = $request->input('dish_additon');
        $number = Dishes::orderby('dishnumber', 'DESC')->first()->dishnumber + 1;

        $course = Dishes::create([
            'name' => $name,
            'spiciness' => $spiciness,
            'dish_addition' => $dish_additon,
            'price' => $price,
            'categories_id' => $category_id,
            'description' => $description,
            'dishnumber' => $number
        ]);
        if($allergens != null){
            foreach($allergens as $allergenId){
                $course->Allergies()->save(Allergies::find($allergenId));
            }
        }
        $course->save();
        return redirect()->route('dishes.index')->with('success', 'Dish successfully added');

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
        return view('cms.dishes.edit' , [
            'course' => Dishes::findOrFail($id),
            'categories' => Categories::all(),
            'allergens' => Allergies::all(),
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
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required',
            'spicness_scale' => 'required|integer|between:0,3',
            'dish_addition' => 'max:3'
        ]);

        $dish = Dishes::find($id);
        $dish->name = $request->input('name');
        $dish->price = $request->input('price');
        $dish->dishnumber = $request->input('dish_number');
        $dish->categories_id = $request->input('category_id');
        $dish->spicness_scale = $request->input('spicness_scale');
        $dish->description = $request->input('description');
        $dish->dish_addition = $request->input('dish_addition');
        $dish->save();
        $allergens = $request->input('allergens');

        $dish->Allergies()->detach();
        if($allergens != null) {
            foreach ($allergens as $allergenId) {
                $dish->Allergies()->save(Allergies::find($allergenId));
            }
        }
        return redirect()->route('dishes.index')->with('success', 'Dish updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dish = Dishes::find($id);
        $dish->delete();
        return redirect()->route('dishes.index');
    }
}
