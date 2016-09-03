<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddInterviewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('interviews', function (Blueprint $table) {
            $table->integer('decision');
            $table->integer('passion');
            $table->integer('commitment');
            $table->integer('drive');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         $table->dropColumn('decision');
         $table->dropColumn('passion');
         $table->dropColumn('commitment');
         $table->dropColumn('drive');
    }
}
