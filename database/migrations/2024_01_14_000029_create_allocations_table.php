<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllocationsTable extends Migration
{
    public function up()
    {
        Schema::create('allocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('amount', 15, 2);
            $table->string('payment_code')->nullable();
            $table->string('cheque_no')->nullable();
            $table->longText('remarks')->nullable();
            $table->string('term')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('other_details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
