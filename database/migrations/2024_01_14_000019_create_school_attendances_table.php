<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('school_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school_term')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
