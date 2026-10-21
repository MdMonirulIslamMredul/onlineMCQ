<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeSessionQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_session_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('practice_sessions')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('practice_questions')->onDelete('cascade');
            $table->integer('correct_count')->default(0);
            $table->integer('incorrect_count')->default(0);
            $table->boolean('is_mastered')->default(false);
            $table->timestamp('last_answered_at')->nullable();
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
        Schema::dropIfExists('practice_session_questions');
    }
}
