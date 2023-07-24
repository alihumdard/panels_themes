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
        Schema::create('result_cards', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('name');
            $table->string('f_name');
            $table->string('phone');
            $table->string('serial_no');
            $table->foreignId('course_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('course_title');
            $table->foreignId('batch_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('batch_title');
            $table->string('file_name');
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
        Schema::dropIfExists('result_cards');
    }
};
