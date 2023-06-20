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
        Schema::create('deletedappointments', function (Blueprint $table) {
            $table->id();
            $table->integer('appointment_id')->nullable()->unsigned();
            $table->string('reasion');
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deletedappointments');
    }
};
