<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCountPerTermsTable extends Migration
{
    public function up()
    {
        Schema::create('student_count_per_terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('count')->nullable();
            $table->string('term')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
