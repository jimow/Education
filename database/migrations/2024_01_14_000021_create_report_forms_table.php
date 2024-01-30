<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportFormsTable extends Migration
{
    public function up()
    {
        Schema::create('report_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school_term')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
