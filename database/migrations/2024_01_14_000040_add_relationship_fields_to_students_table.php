<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStudentsTable extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->foreign('ward_id', 'ward_fk_9178655')->references('id')->on('wards');
            $table->unsignedBigInteger('stream_id')->nullable();
            $table->foreign('stream_id', 'stream_fk_9178672')->references('id')->on('school_streams');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->foreign('school_id', 'school_fk_9178673')->references('id')->on('schools');
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id', 'form_fk_9178674')->references('id')->on('student_forms');
            $table->unsignedBigInteger('registered_by_id')->nullable();
            $table->foreign('registered_by_id', 'registered_by_fk_9178680')->references('id')->on('users');
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->foreign('approved_by_id', 'approved_by_fk_9178681')->references('id')->on('users');
        });
    }
}
