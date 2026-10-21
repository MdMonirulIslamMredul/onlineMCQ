<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWrittenResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('written_results', function (Blueprint $table) {
            $table->id();
            $table->integer('examID');
            $table->integer('userID');
            $table->integer('qid');
            $table->longText('userAns')->nullable();
            $table->string('mark');
            $table->string('rightansMark')->nullable();
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
        Schema::dropIfExists('written_results');
    }
}
