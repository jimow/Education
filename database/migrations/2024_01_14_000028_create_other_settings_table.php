<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('other_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('fees_percentage')->nullable();
            $table->string('term_1')->nullable();
            $table->string('term_2')->nullable();
            $table->string('term_3')->nullable();
            $table->string('day_fees_percentage')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
