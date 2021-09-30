<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')
                ->constrained('exams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('question_id')
                ->constrained('questions')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('student_id')
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('given_answer')->nullable();
            $table->string('correct_answer')->nullable();
            $table->integer('mark')->default(0);
            $table->boolean('is_correct')->default(false);
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
        Schema::dropIfExists('exam_sheets');
    }
}
