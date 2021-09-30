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
            $table->string('name')->nullable();
            $table->foreignId('classroom_id')
                ->constrained('classrooms')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('duration')
                ->default(60)
                ->comment('Exam Duration in Minutes');
            $table->dateTime('start_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->boolean('is_published')->default(false);
            $table->softDeletes();
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
