<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsettingsTable extends Migration
{
    public function up()
    {
        Schema::create('termsettings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('term')->nullable();
            $table->date('begins')->nullable();
            $table->date('ends')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
