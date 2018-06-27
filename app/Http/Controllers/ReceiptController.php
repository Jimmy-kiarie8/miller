<?php

namespace App\Http\Controllers;

use App\Receipt;
use App\ReceiptProduct;
use Illuminate\Http\Request;

class ReceiptController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		$this->validate($request, [
			'receipt_no' => 'required|alpha_dash|unique:receipts',
			'client' => 'required|max:255',
			// 'client_address' => 'required|max:255',
			'receipt_date' => 'required|date_format:Y-m-d',
			'due_date' => 'required|date_format:Y-m-d',
			'title' => 'required|max:255',
			'discount' => 'required|numeric|min:0',
			'products.*.name' => 'required|max:255',
			'products.*.price' => 'required|numeric|min:1',
			'products.*.qty' => 'required|integer|min:1',
		]);

		$products = collect($request->products)->transform(function ($product) {
			$product['total'] = $product['qty'] * $product['price'];
			return new ReceiptProduct($product);
		});
		// var_dump($products);die;

		if ($products->isEmpty()) {
			return response()
				->json([
					'products_empty' => ['One or more Product is required.'],
				], 422);
		}

		$data = $request->except('products');
		$data['sub_total'] = $products->sum('total');
		$data['grand_total'] = $data['sub_total'] - $data['discount'];

		$receipt = Receipt::create($data);

		$receipt->products()->saveMany($products);

		return response()
			->json([
				'created' => true,
				'id' => $receipt->id,
			]);
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
		$this->validate($request, [
			'receipt_no' => 'required|alpha_dash|unique:receipts,receipt_no,' . $id . ',id',
			'client' => 'required|max:255',
			// 'client_address' => 'required|max:255',
			'receipt_date' => 'required|date_format:Y-m-d',
			'due_date' => 'required|date_format:Y-m-d',
			'title' => 'required|max:255',
			'discount' => 'required|numeric|min:0',
			'products.*.name' => 'required|max:255',
			'products.*.price' => 'required|numeric|min:1',
			'products.*.qty' => 'required|integer|min:1',
		]);

		$receipt = Receipt::findOrFail($id);

		$products = collect($request->products)->transform(function ($product) {
			$product['total'] = $product['qty'] * $product['price'];
			return new ReceiptProduct($product);
		});

		if ($products->isEmpty()) {
			return response()
				->json([
					'products_empty' => ['One or more Product is required.'],
				], 422);
		}

		$data = $request->except('products');
		$data['sub_total'] = $products->sum('total');
		$data['grand_total'] = $data['sub_total'] - $data['discount'];

		$receipt->update($data);

		ReceiptProduct::where('receipt_id', $receipt->id)->delete();

		$receipt->products()->saveMany($products);

		return response()
			->json([
				'updated' => true,
				'id' => $receipt->id,
			]);
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
		return Receipt::with('products')->get();
	}
}
