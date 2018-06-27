<?php

namespace App\Http\Controllers;

use App\CoffeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoffeeTypeController extends Controller
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
        $coffee = new CoffeeType;
        $coffee->type = $request->coffee;
        $coffee->description = $request->description;
        $coffee->user_id = Auth::id();
        $coffee->save();
        return $coffee;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CoffeeType  $coffeeType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CoffeeType $coffeeType)
    {
        // return $request->all();
        $coffee = CoffeeType::find($request->id);
        $coffee->type = $request->coffee;
        $coffee->description = $request->description;
        $coffee->save();
        return $coffee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CoffeeType  $coffeeType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CoffeeType $coffeeType)
    {
        //
    }

    public function getCoffee()
    {
        return CoffeeType::all();
    }
}
