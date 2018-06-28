<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    public function receipts() {
    	return $this->hasMany(Receipt::class, 'client');
    }

    public function invoices() {
    	return $this->hasMany(Invoice::class, 'client');
    }
}
