<?php

namespace App\Http\Controllers;

use App\PackingUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackingUnitController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $units = new PackingUnit;
        $units->title = $request->title;
        $units->abbreviation = $request->abbreviation;
        $units->user_id = Auth::id();
        $units->save();
        return $units;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PackingUnit  $packingUnit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PackingUnit $packingUnit)
    {
         // return $request->all();
        $units = PackingUnit::find($request->id);
        $units->title = $request->title;
        $units->abbreviation = $request->abbreviation;
        $units->save();
        return $units;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PackingUnit  $packingUnit
     * @return \Illuminate\Http\Response
     */
    public function destroy(PackingUnit $packingUnit)
    {
        //
    }



    public function getUnits()
    {
        return PackingUnit::all();
    }
}
