<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToReportFormsTable extends Migration
{
    public function up()
    {
        Schema::table('report_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable();
            $table->foreign('student_id', 'student_fk_9178720')->references('id')->on('students');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_9178722')->references('id')->on('years');
        });
    }
}
