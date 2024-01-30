<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWardsTable extends Migration
{
    public function up()
    {
        Schema::table('wards', function (Blueprint $table) {
            $table->unsignedBigInteger('constituency_id')->nullable();
            $table->foreign('constituency_id', 'constituency_fk_9178604')->references('id')->on('constituencies');
        });
    }
}
