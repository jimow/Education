<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStudentBursaryRegistersTable extends Migration
{
    public function up()
    {
        Schema::table('student_bursary_registers', function (Blueprint $table) {
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_9178730')->references('id')->on('years');
            $table->unsignedBigInteger('requested_by_id')->nullable();
            $table->foreign('requested_by_id', 'requested_by_fk_9179760')->references('id')->on('users');
            $table->unsignedBigInteger('authorized_by_id')->nullable();
            $table->foreign('authorized_by_id', 'authorized_by_fk_9178735')->references('id')->on('users');
            $table->unsignedBigInteger('admission_number_id')->nullable();
            $table->foreign('admission_number_id', 'admission_number_fk_9207347')->references('id')->on('students');
        });
    }
}
