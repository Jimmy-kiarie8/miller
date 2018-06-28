<?php

namespace App\Http\Controllers;

use App\Buyer;
use App\Derivery;
use App\Invoice;
use App\Receipt;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function getBuyersReport(Request $request, $id)
    {
    	$validatedData = $request->validate([
	        'start_date' => 'required|date',
	        'end_date' => 'required|date',
	    ]);
		$start_date = $request->start_date;
		$end_date = $request->end_date;
    	if ($id != 0) {
	        $buyers = Buyer::find($id);
	                        // ->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
	        $receipts = Receipt::where('client', $id)->whereBetween('created_at', [$request->start_date, $request->end_date])->sum('grand_total');
	        $invoices = Invoice::where('client', $id)->whereBetween('created_at', [$request->start_date, $request->end_date])->sum('grand_total');
	        $Allinvoices = Invoice::where('client', $id)->get();
	        $Allreceipts = Receipt::where('client', $id)->get();
	        $balance = $invoices - $receipts;
	        $report = [
	        	'invoicesArr' => $Allinvoices,
	        	'receiptsArr' => $Allreceipts,
	        	'balance' => $balance,
	        	'client' => $buyers,
	        ];
    	} else {
    		$buyers = Buyer::all();
	                        // ->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
	        $receipts = Receipt::whereBetween('created_at', [$request->start_date, $request->end_date])->sum('grand_total');
	        $invoices = Invoice::whereBetween('created_at', [$request->start_date, $request->end_date])->sum('grand_total');
	        $Allinvoices = Invoice::all();
	        // return $start_date;
	        $Allreceipts = Receipt::all();
	        $balance = $invoices - $receipts;
	        $report = [
	        	'invoicesArr' => $Allinvoices,
	        	'receiptsArr' => $Allreceipts,
	        	'balance' => $balance,
	        	'client' => $buyers,
	        ];
    	}
    	

      	return $report;
    }

    public function getDerivery(Request $request, $id)
    {
    	$validatedData = $request->validate([
	        'derivery_start_date' => 'required|date',
	        'derivery_end_date' => 'required|date',
	    ]);
    	return Derivery::where('society', $id)
    	            ->whereBetween('created_at', [$request->derivery_start_date, $request->derivery_end_date])->get();
    }
}
