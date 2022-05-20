<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->unsignedBigInteger('mobile_number');
            $table->unsignedBigInteger('whatsapp_number')->nullable();
            $table->enum('is_catking_student',['Yes','No']);
            $table->string('dob')->nullable();
            $table->string('password');
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->enum('role',['admin','teacher','student']);
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
        Schema::dropIfExists('users');
    }
}
