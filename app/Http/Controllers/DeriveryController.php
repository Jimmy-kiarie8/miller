<?php

namespace App\Http\Controllers;

use App\Derivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeriveryController extends Controller
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
        $derivery = new Derivery;
        $derivery->grower_name = $request->grower_name;
        $derivery->grower_rep = $request->grower_rep;
        $derivery->code = $request->code;
        $derivery->vihicle_reg = $request->vihicle_reg;
        $derivery->pammit_no = $request->pammit_no;
        $derivery->weight = $request->weight;
        $derivery->weighing_bridge = $request->weighing_bridge;
        $derivery->no_of_bags = $request->no_of_bags;
        $derivery->coffee_types = $request->coffee_types;
        $derivery->society = $request->society;
        $derivery->clerks_name = $request->clerks_name;
        $derivery->units = $request->unit;
        $derivery->user_id = Auth::id();
        $derivery->save();
        return $derivery;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Derivery  $derivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Derivery $derivery)
    {
        // return $request->all();
        $derivery = Derivery::find($request->id);
        $derivery->grower_name = $request->grower_name;
        $derivery->grower_rep = $request->grower_rep;
        $derivery->code = $request->code;
        $derivery->vihicle_reg = $request->vihicle_reg;
        $derivery->pammit_no = $request->pammit_no;
        $derivery->clerks_name = $request->clerks_name;
        $derivery->weight = $request->weight;
        $derivery->weighing_bridge = $request->weighing_bridge;
        $derivery->no_of_bags = $request->no_of_bags;
        $derivery->society = $request->society;
        $derivery->save();
        return $derivery;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Derivery  $derivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Derivery $derivery)
    {
        //
    }

    public function getderivery()
    {
        return Derivery::all();
    }
}
