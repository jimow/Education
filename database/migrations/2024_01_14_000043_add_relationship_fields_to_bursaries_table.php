<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBursariesTable extends Migration
{
    public function up()
    {
        Schema::table('bursaries', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id', 'school_fk_9178711')->references('id')->on('schools');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_9178713')->references('id')->on('years');
        });
    }
}
