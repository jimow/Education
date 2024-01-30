<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fullname');
            $table->string('gender');
            $table->date('date_of_birth');
            $table->string('nemis_number')->unique();
            $table->string('admission_number')->unique();
            $table->string('on_scholarship');
            $table->decimal('scholarship_amount', 15, 2)->nullable();
            $table->string('scholarship_donor')->nullable();
            $table->string('disability');
            $table->string('parental_status');
            $table->string('father_fullname')->nullable();
            $table->string('father_phone_number')->nullable();
            $table->string('mother_fullname');
            $table->string('mother_phone_number');
            $table->string('birth_certificate_number')->nullable();
            $table->string('father_national_id_no')->nullable();
            $table->string('mother_national_id_no')->nullable();
            $table->string('status')->nullable();
            $table->string('day_scholar')->nullable();
            $table->string('guardian_fullname')->nullable();
            $table->string('guardian_phone_number')->nullable();
            $table->string('guardian_national')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
