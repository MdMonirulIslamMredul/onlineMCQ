<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMcqResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcq_results', function (Blueprint $table) {
            $table->id();
            $table->integer('examID');
            $table->integer('userID');
            $table->integer('qid');
            $table->integer('userAns')->nullable();
            $table->integer('rightAns');
            $table->string('mark');
            $table->string('negativeMark');
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
        Schema::dropIfExists('mcq_results');
    }
}
