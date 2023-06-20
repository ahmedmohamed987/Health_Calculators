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
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned()->nullable();
            $table->integer('worktime_id')->unsigned()->nullable();
            $table->date('date');
            $table->boolean('payment_type');
            $table->integer('appointment_fees');
            $table->timestamps();

            $table->foreign('patient_id')->references('id')
                    ->on('patients')->onDelete('cascade');
            $table->foreign('worktime_id')->references('id')
                    ->on('worktimes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
