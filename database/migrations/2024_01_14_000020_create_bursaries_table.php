<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBursariesTable extends Migration
{
    public function up()
    {
        Schema::create('bursaries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school_term')->nullable();
            $table->decimal('amount_paid', 15, 2)->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('payment_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
