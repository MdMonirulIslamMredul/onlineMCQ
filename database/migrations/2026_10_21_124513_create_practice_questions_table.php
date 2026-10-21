<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practice_quiz_id')->constrained('practice_quizzes')->onDelete('cascade');
            $table->text('question');
            $table->text('optn1');
            $table->text('optn2');
            $table->text('optn3')->nullable();
            $table->text('optn4')->nullable();
            $table->text('optn5')->nullable();
            $table->tinyInteger('right_ans');
            $table->text('explanation')->nullable();
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
        Schema::dropIfExists('practice_questions');
    }
}
