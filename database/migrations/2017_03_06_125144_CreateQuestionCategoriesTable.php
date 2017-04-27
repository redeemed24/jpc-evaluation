<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('question_categories', function (Blueprint $table) {
            $table->increments('question_category_id');
            $table->string('category');
            $table->string('description');
            $table->timestamps();
        });

        Schema::table('questions', function($table){
            $table->integer('question_category_id')->after('question_id');
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
