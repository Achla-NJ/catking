<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_education', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->string('class');
            $table->float('marks');
            $table->string('school');
            $table->enum('class_type',['matric','secondary','graduation','post_graduation','diploma','other']);            
            $table->date('completion_date');
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
        Schema::dropIfExists('student_education');
    }
}
