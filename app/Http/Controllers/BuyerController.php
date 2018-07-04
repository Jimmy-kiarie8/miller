<?php

namespace App\Http\Controllers;

use App\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		// return $request->all();
		$client_id = 'CLIENT_' . rand(1, 10);
		$buyer = new Buyer;
		$buyer->name = $request->name;
		$buyer->email = $request->email;
		$buyer->phone = $request->phone;
		$buyer->status = 0;
		$buyer->client_id = 'CLIENT_' . rand(1, 1000);
		// return $client_id;
		$buyer->location = $request->location;
		$buyer->user_id = Auth::id();
		$buyer->save();
		return $buyer;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Buyer  $buyer
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Buyer $buyer) {
		// return $request->all();
		$buyer = Buyer::find($request->id);
		$buyer->name = $request->name;
		$buyer->email = $request->email;
		$buyer->phone = $request->phone;
		$buyer->status = 0;
		$buyer->location = $request->location;
		$buyer->save();
		return $buyer;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Buyer  $buyer
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Buyer $buyer) {
		Buyer::find($receipt->id)->delete();
	}

	public function getBuyers() {
		return Buyer::all();
	}

	public function fewBuyers() {
		return Buyer::orderBy('created_at', 'DESC')->limit(5)->get();
	}
}
