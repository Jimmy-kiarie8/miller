<?php

namespace App\Http\Controllers;

use App\Milled;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MilledController extends Controller
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
        $milled = new Milled;
        $milled->code = $request->code;
        $milled->remarks = $request->remarks;
        $milled->grower_name = $request->grower_name;
        $milled->no_of_bags = $request->no_of_bags;
        $milled->no_of_pockets = $request->no_of_pockets;
        $milled->user_id = Auth::id();
        $milled->save();
        return $milled;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Milled  $milled
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Milled $milled)
    {        
        // return $request->all();
        $milled = Milled::find($request->id);
        $milled->code = $request->code;
        $milled->remarks = $request->remarks;
        $milled->grower_name = $request->grower_name;
        $milled->no_of_bags = $request->no_of_bags;
        $milled->no_of_pockets = $request->no_of_pockets;
        $milled->save();
        return $milled;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Milled  $milled
     * @return \Illuminate\Http\Response
     */
    public function destroy(Milled $milled)
    {
        milled::find($milled->id)->delete();
    }

    public function getMiller()
    {
        return Milled::all();
    }
}
