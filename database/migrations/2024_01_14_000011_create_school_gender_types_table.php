<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolGenderTypesTable extends Migration
{
    public function up()
    {
        Schema::create('school_gender_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('gender_type');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
