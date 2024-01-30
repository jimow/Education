<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentBursaryRegistersTable extends Migration
{
    public function up()
    {
        Schema::create('student_bursary_registers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('term');
            $table->decimal('amount_paid', 15, 2);
            $table->string('payment_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
