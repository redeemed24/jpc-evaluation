<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('evaluation_id');
            $table->integer('teacher_id');
            $table->integer('subject_id');
            $table->string('subject_time');
            $table->string('semester');
            $table->integer('evaluation_year');
            $table->boolean('status');
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
        //
    }
}
