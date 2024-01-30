<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSchoolAttendancesTable extends Migration
{
    public function up()
    {
        Schema::table('school_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_number_id')->nullable();
            $table->foreign('admission_number_id', 'admission_number_fk_9178709')->references('id')->on('students');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_9178707')->references('id')->on('years');
            $table->unsignedBigInteger('prepared_by_id')->nullable();
            $table->foreign('prepared_by_id', 'prepared_by_fk_9178702')->references('id')->on('users');
            $table->unsignedBigInteger('confirmed_by_id')->nullable();
            $table->foreign('confirmed_by_id', 'confirmed_by_fk_9178703')->references('id')->on('users');
            $table->unsignedBigInteger('school_name_id')->nullable();
            $table->foreign('school_name_id', 'school_name_fk_9178708')->references('id')->on('schools');
        });
    }
}
