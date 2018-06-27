<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiptProduct extends Model {
	protected $fillable = [
		'name', 'price', 'qty', 'total',
	];

	public function receipt() {
		return $this->belongsTo(Invoice::class);
	}
}
