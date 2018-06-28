<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model {
	protected $fillable = [
		'receipt_no', 'receipt_date', 'due_date',
		'title', 'sub_total', 'discount',
		'grand_total', 'client',
		'client_address',
	];

	public function products() {
		return $this->hasMany(ReceiptProduct::class);
	}
	
    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
