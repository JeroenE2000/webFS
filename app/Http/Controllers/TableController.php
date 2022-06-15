<?php

namespace App\Http\Controllers;

use App\Models\Tables;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tables = Tables::all();
        return view('cms.tables.index', compact('tables'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'table_number' => 'required|unique:tables,table_number',
            'guest_amount' => 'required'
        ]);

        $table = new Tables();
        $table->table_number = $request->input('table_number');
        $table->guest_amount = $request->input('guest_amount');
        $table->save();

        return redirect()->route('tables.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $table = Tables::find($id);
        return view('cms.tables.edit', compact('table'));
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
        $this->validate($request, [
            'table_number' => 'required|unique:tables,table_number,'.$id,
            'guest_amount' => 'required'
        ]);

        $table = Tables::find($id);
        $table->table_number = $request->input('table_number');
        $table->guest_amount = $request->input('guest_amount');
        $table->save();

        return redirect()->route('tables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Tables::find($id);
        $table->delete();
        return redirect()->route('tables.index');
    }
}
