<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePracticeSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practice_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('practice_quiz_id')->constrained('practice_quizzes')->onDelete('cascade');
            $table->integer('total_questions')->default(0);
            $table->integer('mastered_questions')->default(0);
            $table->integer('total_attempts')->default(0);
            $table->integer('correct_attempts')->default(0);
            $table->string('status')->default('in_progress'); // 'in_progress' or 'completed'
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('practice_sessions');
    }
}
