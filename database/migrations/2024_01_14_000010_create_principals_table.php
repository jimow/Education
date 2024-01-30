<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrincipalsTable extends Migration
{
    public function up()
    {
        Schema::create('principals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('national')->unique();
            $table->string('phone_number')->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
