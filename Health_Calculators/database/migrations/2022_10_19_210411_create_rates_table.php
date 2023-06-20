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
        Schema::create('rates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned()->nullable();
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->integer('rate');
            $table->timestamps();

            $table->foreign('patient_id')->references('id')
                    ->on('patients')->onDelete('cascade');

            $table->foreign('doctor_id')->references('id')
                    ->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rates');
    }
};
