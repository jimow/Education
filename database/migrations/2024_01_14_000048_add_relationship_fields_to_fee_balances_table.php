<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFeeBalancesTable extends Migration
{
    public function up()
    {
        Schema::table('fee_balances', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_number_id')->nullable();
            $table->foreign('admission_number_id', 'admission_number_fk_9211151')->references('id')->on('students');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_9211154')->references('id')->on('years');
        });
    }
}
