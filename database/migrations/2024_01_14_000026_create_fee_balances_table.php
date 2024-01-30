<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeeBalancesTable extends Migration
{
    public function up()
    {
        Schema::create('fee_balances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('balance', 15, 2)->nullable();
            $table->string('term')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
