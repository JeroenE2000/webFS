<?php

namespace App\Http\Controllers;

use App\Models\Allergies;
use Illuminate\Http\Request;

class AllergiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allergies = Allergies::paginate(5);
        return view('cms.allergies.index' , ['allergies' => $allergies]);
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
            'name' => 'required|unique:allergies|max:255',
        ]);
        Allergies::create($request->all());
        return redirect()->route('allergies.index')->with('success', 'Allergie created successfully.');
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
            'name' => 'required|unique:allergies|max:255',
        ]);
        Allergies::findOrFail($id)->update($request->all());
        return redirect()->route('allergies.index')->with('success', 'Allergie updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Allergies::findOrFail($id)->delete();
        return redirect()->route('allergies.index')->with('success', 'Allergie deleted successfully.');
    }
}
