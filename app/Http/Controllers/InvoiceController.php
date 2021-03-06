<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Invoice;
use App\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller {
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		
		// $data = $request->except('products');
		// $client = Buyer::where('client_id', $data['client'])->first();
		// $query = DB::table('accounting_journals')->where('morphed_id', $client->id)->first();
		// return $current_balance = $client->journal->getCurrentBalanceInDollars();

		$this->validate($request, [
			'invoice_no' => 'required|alpha_dash|unique:invoices',
			'client' => 'required|max:255',
			// 'client_address' => 'required|max:255',
			'invoice_date' => 'required|date_format:Y-m-d',
			'due_date' => 'required|date_format:Y-m-d',
			'title' => 'required|max:255',
			'discount' => 'required|numeric|min:0',
			'products.*.name' => 'required|max:255',
			'products.*.price' => 'required|numeric|min:1',
			'products.*.qty' => 'required|integer|min:1',
		]);

		$products = collect($request->products)->transform(function ($product) {
			$product['total'] = $product['qty'] * $product['price'];
			return new InvoiceProduct($product);
		});
		// var_dump($products);die;

		if ($products->isEmpty()) {
			return response()
				->json([
					'products_empty' => ['One or more Product is required.'],
				], 422);
		}

		$data = $request->except('products');
		$invoice_no = 'INV_' . $data['invoice_no'];
		// return $invoice_no;
		$data['sub_total'] = $products->sum('total');
		$data['balance'] = $products->sum('total');
		$data['grand_total'] = $data['sub_total'] - $data['discount'];
		$data['vat'] = $data['grand_total'] * 0.16;
		// return $data['vat'];
		$data['invoice_no'] = $invoice_no;

		// $invoice = Invoice::create($data);
		if ($invoice = Invoice::create($data)) {
			$invoice->products()->saveMany($products);
			$client = Buyer::where('client_id', $data['client'])->first();
			// $client->initJournal();
			$query = DB::table('accounting_journals')->where('morphed_id', $client->id)->first();
			if ($query == '') {
				// $product = Invoice::where('invoice_no', $data['invoice_no'])->get();
				if ($client->initJournal()) {
					$next = Buyer::where('client_id', $data['client'])->first();
					$transaction_1 = $next->journal->creditDollars($data['grand_total']);
				}
				// $transaction_1->referencesObject($product);
				// return response()
				// 	->json('if');
			} else {
				// $product = Invoice::where('invoice_no', $data['invoice_no'])->get();
				$transaction_1 = $client->journal->creditDollars($data['grand_total']);
				// $transaction_1->referencesObject($product);
				// return response()
				// 	->json('else');
			}
			
		}




		return response()
			->json($invoice);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$this->validate($request, [
			'invoice_no' => 'required|alpha_dash|unique:invoices,invoice_no,' . $id . ',id',
			'client' => 'required|max:255',
			'currency' => 'required',
			'invoice_date' => 'required|date_format:Y-m-d',
			'due_date' => 'required|date_format:Y-m-d',
			'title' => 'required|max:255',
			'discount' => 'required|numeric|min:0',
			'products.*.name' => 'required|max:255',
			'products.*.price' => 'required|numeric|min:1',
			'products.*.qty' => 'required|integer|min:1',
		]);

		$invoice = Invoice::findOrFail($id);

		$products = collect($request->products)->transform(function ($product) {
			$product['total'] = $product['qty'] * $product['price'];
			return new InvoiceProduct($product);
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

		$invoice->update($data);

		InvoiceProduct::where('invoice_id', $invoice->id)->delete();

		$invoice->products()->saveMany($products);

		return response()
			->json($invoice);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Invoice  $invoice
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Invoice $invoice) {
		Invoice::find($receipt->id)->delete();
	}

	public function getInvoice() {
		// return Invoice::all();
		return Invoice::with('products')->get();
	}

	public function getInvoiceSort(Request $request) {
		return Invoice::whereBetween('created_at', [$request->start_date, $request->end_date])->get();
	}
}
