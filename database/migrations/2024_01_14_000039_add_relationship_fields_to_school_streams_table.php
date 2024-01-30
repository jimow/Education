<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSchoolStreamsTable extends Migration
{
    public function up()
    {
        Schema::table('school_streams', function (Blueprint $table) {
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id', 'school_fk_9178645')->references('id')->on('schools');
        });
    }
}
