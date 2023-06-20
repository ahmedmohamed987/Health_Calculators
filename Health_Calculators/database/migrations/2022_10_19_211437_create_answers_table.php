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
        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->integer('question_id')->unsigned()->nullable();
            $table->longText('answer');
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')
                        ->on('doctors')->onDelete('cascade');

            $table->foreign('question_id')->references('id')
                        ->on('questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
