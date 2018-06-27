<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('receipts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('client_id');
			$table->string('receipt_no');
			$table->integer('grand_total');
			$table->date('receipt_date');
			$table->date('due_date');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('receipts');
	}
}
