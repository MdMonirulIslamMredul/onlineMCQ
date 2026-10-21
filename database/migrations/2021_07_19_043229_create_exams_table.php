<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->integer('catID');
            $table->string('mcq_written'); //MCQ or Written
            $table->string('free_paid'); //Free or Paid
            $table->double('tk')->nullable();
            $table->mediumText('exam_name');
            $table->string('type'); // Temporary or Parmanent
            $table->string('startDate')->nullable();
            $table->string('examTime');
            $table->integer('active')->default(0);
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
        Schema::dropIfExists('exams');
    }
}
