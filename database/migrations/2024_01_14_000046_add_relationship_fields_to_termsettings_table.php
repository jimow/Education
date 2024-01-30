<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToTermsettingsTable extends Migration
{
    public function up()
    {
        Schema::table('termsettings', function (Blueprint $table) {
            $table->unsignedBigInteger('year_id')->nullable();
            $table->foreign('year_id', 'year_fk_9207343')->references('id')->on('years');
        });
    }
}
