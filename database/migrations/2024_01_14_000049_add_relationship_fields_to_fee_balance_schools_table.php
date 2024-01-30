<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToFeeBalanceSchoolsTable extends Migration
{
    public function up()
    {
        Schema::table('fee_balance_schools', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id', 'school_fk_9211159')->references('id')->on('schools');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_9211162')->references('id')->on('years');
        });
    }
}
