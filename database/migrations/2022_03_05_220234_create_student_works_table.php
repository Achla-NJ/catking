<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_works', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->string('company_name');
            $table->string('role');
            $table->date('join_date');
            $table->date('leave_date');
            $table->enum('work_type',['full_time','part_time','internship']);
            $table->string('responsibilities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_works');
    }
}
