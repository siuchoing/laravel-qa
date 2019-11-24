<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body')->default(0);
            $table->unsignedInteger('views')->default(0);   // unsignedInteger (non negative integers)
            $table->unsignedInteger('answers')->default(0); // unsigned means (non negative)
            $table->integer('votes')->default(0);           // integer (+/- integers)
            $table->unsignedBigInteger('best_answer_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');   // when the user deletes his account, all posts will be deleted as well
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
