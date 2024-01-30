<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToSchoolsTable extends Migration
{
    public function up()
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->unsignedBigInteger('gender_type_id')->nullable();
            $table->foreign('gender_type_id', 'gender_type_fk_9178626')->references('id')->on('school_gender_types');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id', 'category_fk_9178627')->references('id')->on('school_categories');
            $table->unsignedBigInteger('ward_id')->nullable();
            $table->foreign('ward_id', 'ward_fk_9178628')->references('id')->on('wards');
            $table->unsignedBigInteger('principal_id')->nullable();
            $table->foreign('principal_id', 'principal_fk_9178629')->references('id')->on('principals');
            $table->unsignedBigInteger('registered_by_id')->nullable();
            $table->foreign('registered_by_id', 'registered_by_fk_9178881')->references('id')->on('users');
            $table->unsignedBigInteger('approved_by_id')->nullable();
            $table->foreign('approved_by_id', 'approved_by_fk_9178882')->references('id')->on('users');
        });
    }
}
