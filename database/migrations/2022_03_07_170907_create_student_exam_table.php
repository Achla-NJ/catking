<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_exams', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->enum('took_exam',['yes','no']);
            $table->enum('type',['cat','nmat','snap','xat','iift','micat','tissnet','cet','cmat','other']);
            $table->string('score');
            $table->string('percentile');
            $table->string('score_card_file');
            $table->string('sop_file');
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
        Schema::dropIfExists('student_exams');
    }
}
