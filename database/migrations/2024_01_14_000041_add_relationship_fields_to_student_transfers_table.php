<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToStudentTransfersTable extends Migration
{
    public function up()
    {
        Schema::table('student_transfers', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_number_id')->nullable();
            $table->foreign('admission_number_id', 'admission_number_fk_9179744')->references('id')->on('students');
            $table->unsignedBigInteger('trasnsfer_from_id')->nullable();
            $table->foreign('trasnsfer_from_id', 'trasnsfer_from_fk_9178684')->references('id')->on('schools');
            $table->unsignedBigInteger('transfer_to_id')->nullable();
            $table->foreign('transfer_to_id', 'transfer_to_fk_9178686')->references('id')->on('schools');
            $table->unsignedBigInteger('principal_approval_transfer_from_id')->nullable();
            $table->foreign('principal_approval_transfer_from_id', 'principal_approval_transfer_from_fk_9178692')->references('id')->on('principals');
            $table->unsignedBigInteger('principal_approval_transfer_to_id')->nullable();
            $table->foreign('principal_approval_transfer_to_id', 'principal_approval_transfer_to_fk_9178693')->references('id')->on('principals');
            $table->unsignedBigInteger('initiated_by_id')->nullable();
            $table->foreign('initiated_by_id', 'initiated_by_fk_9178685')->references('id')->on('users');
            $table->unsignedBigInteger('confirmed_by_id')->nullable();
            $table->foreign('confirmed_by_id', 'confirmed_by_fk_9389335')->references('id')->on('users');
            $table->unsignedBigInteger('authorized_by_id')->nullable();
            $table->foreign('authorized_by_id', 'authorized_by_fk_9178688')->references('id')->on('users');
        });
    }
}
