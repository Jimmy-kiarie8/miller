<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model {
	protected $fillable = [
		'invoice_no', 'invoice_date', 'due_date',
		'title', 'sub_total', 'discount',
		'grand_total', 'client',
		'client_address', 'balance', 'vat'
	];

	public function products() {
		return $this->hasMany(InvoiceProduct::class);
	}

	public function buyer() {
		return $this->belongsTo(Buyer::class);
	}

	public function receipts() {
		return $this->hasMany(Receipt::class, 'invoice_id');
	}
}
