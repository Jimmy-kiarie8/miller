<?php

namespace App\Http\Controllers;

use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		return $request->all();
		$receipt = new Receipt;
		$receipt->receipt_no = $request->receipt_no;
		$receipt->client_id = $request->client;
		$receipt->receipt_date = $request->receipt_date;
		$receipt->grand_total = $request->grand_total;
		$receipt->due_date = $request->due_date;
		$receipt->user_id = Auth::id();
		$receipt->save();
		return $receipt;
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Receipt  $receipt
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Receipt $receipt) {
		// return $request->all();
		$receipt = Receipt::find($request->id);
		$receipt->receipt_no = $request->receipt_no;
		$receipt->client_id = $request->client;
		$receipt->receipt_date = $request->receipt_date;
		$receipt->grand_total = $request->grand_total;
		$receipt->due_date = $request->due_date;
		$receipt->save();
		return $receipt;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Receipt  $receipt
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Receipt $receipt) {
		Receipt::find($receipt->id)->delete();
	}

	public function getReceipts() {
		return Receipt::all();
	}
}
