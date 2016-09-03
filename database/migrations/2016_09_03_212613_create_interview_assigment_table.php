<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewAssigmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('interview_assignment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('interview_id')->unsigned()->index();
            $table->foreign('interview_id')->references('id')->on('interview_slot');
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('interview_assignment');
    }
}
