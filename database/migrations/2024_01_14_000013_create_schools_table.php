<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('phone_number')->nullable();
            $table->string('email');
            $table->string('postal_address')->nullable();
            $table->string('physical_address')->nullable();
            $table->string('physical_location')->nullable();
            $table->string('code')->unique();
            $table->string('fees')->nullable();
            $table->string('uniform_fee')->nullable();
            $table->decimal('f_1_fee', 15, 2)->nullable();
            $table->string('f_2_fee')->nullable();
            $table->decimal('f_3_fee', 15, 2)->nullable();
            $table->decimal('f_4_fee', 15, 2)->nullable();
            $table->decimal('b_1_fee', 15, 2)->nullable();
            $table->decimal('b_2_fee', 15, 2)->nullable();
            $table->string('b_3_fee')->nullable();
            $table->string('b_4_fee')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
