<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('course_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->integer('level');
            $table->integer('total_questions');
            $table->integer('total_marks');
            $table->integer('total_time');
            $table->json('ratio');
            $table->integer('month');
            $table->integer('year');
            $table->integer('ym_index');
            $table->date('registration_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('is_enable')->default(1);
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('batches');
    }
};
