<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolSchoolPermissionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('school_school_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('school_permission_id');
            $table->foreign('school_permission_id', 'school_permission_id_fk_9178761')->references('id')->on('school_permissions')->onDelete('cascade');
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id', 'school_id_fk_9178761')->references('id')->on('schools')->onDelete('cascade');
        });
    }
}
