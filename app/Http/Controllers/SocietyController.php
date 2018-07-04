<?php

namespace App\Http\Controllers;

use App\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocietyController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		// return $request->all();
		$society = new Society;
		$society->name = $request->name;
		$society->email = $request->email;
		$society->phone = $request->phone;
		$society->status = 0;
		$society->location = $request->location;
		$society->user_id = Auth::id();
		$society->save();
		return $society;
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Society  $society
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Society $society) {
		// return $request->all();
		$society = Society::find($request->id);
		$society->name = $request->name;
		$society->email = $request->email;
		$society->phone = $request->phone;
		$society->location = $request->location;
		$society->save();
		return $society;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Society  $society
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Society $society) {
		return Society::find($society->id)->delete();
	}

	public function getSociety() {
		return Society::all();
	}

	public function fewSocieties() {
		return Society::orderBy('created_at', 'DESC')->limit(5)->get();
	}
}
