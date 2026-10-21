<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_questions', function (Blueprint $table) {
            $table->id();
            $table->integer('examID');
            $table->mediumText('questions');
            $table->mediumText('optn1');
            $table->mediumText('optn2');
            $table->mediumText('optn3');
            $table->mediumText('optn4')->nullable();
            $table->mediumText('optn5')->nullable();
            $table->integer('rightAns');
            $table->string('mark');
            $table->string('negativeMark');
            $table->longText('writeAnsDes')->nullable();
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
        Schema::dropIfExists('mcq_questions');
    }
}
