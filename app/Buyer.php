<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Scottlaurent\Accounting\ModelTraits\AccountingJournal;

class Buyer extends Model
{
	use AccountingJournal;
	
    public function receipts() {
    	return $this->hasMany(Receipt::class, 'client');
    }

    public function invoices() {
    	return $this->hasMany(Invoice::class, 'client');
    }
}
