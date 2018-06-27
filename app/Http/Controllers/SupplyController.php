<?php

namespace App\Http\Controllers;

use App\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplyController extends Controller
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
        $supply = new Supply;
        $supply->grower_name = $request->grower_name;
        $supply->grower_rep = $request->grower_rep;
        $supply->code = $request->code;
        $supply->vihicle_reg = $request->vihicle_reg;
        $supply->pammit_no = $request->pammit_no;
        $supply->weight = $request->weight;
        $supply->weighing_bridge = $request->weighing_bridge;
        $supply->no_of_bags = $request->no_of_bags;
        $supply->coffee_types = $request->coffee_types;
        $supply->buyer = $request->buyers;
        $supply->clerks_name = $request->clerks_name;
        $supply->units = $request->unit;
        $supply->user_id = Auth::id();
        $supply->save();
        return $supply;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit(Supply $supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supply $supply)
    {
        // return $request->all();
        $supply = Supply::find($request->id);
        $supply->grower_name = $request->grower_name;
        $supply->grower_rep = $request->grower_rep;
        $supply->code = $request->code;
        $supply->vihicle_reg = $request->vihicle_reg;
        $supply->pammit_no = $request->pammit_no;
        $supply->clerks_name = $request->clerks_name;
        $supply->weight = $request->weight;
        $supply->weighing_bridge = $request->weighing_bridge;
        $supply->no_of_bags = $request->no_of_bags;
        $supply->buyer = $request->buyers;
        $supply->save();
        return $supply;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supply $supply)
    {
        //
    }

    public function getsupply()
    {
        return Supply::all();
    }
}
