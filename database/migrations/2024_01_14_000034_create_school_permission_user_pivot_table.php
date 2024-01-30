<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolPermissionUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('school_permission_user', function (Blueprint $table) {
            $table->unsignedBigInteger('school_permission_id');
            $table->foreign('school_permission_id', 'school_permission_id_fk_9178771')->references('id')->on('school_permissions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id', 'user_id_fk_9178771')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
