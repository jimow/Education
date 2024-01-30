<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToConstituenciesTable extends Migration
{
    public function up()
    {
        Schema::table('constituencies', function (Blueprint $table) {
            $table->unsignedBigInteger('county_id')->nullable();
            $table->foreign('county_id', 'county_fk_9178595')->references('id')->on('counties');
        });
    }
}
