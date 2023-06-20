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
        Schema::create('clinics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->string('name');
            $table->longText('address');
            $table->string('phone_number');
            $table->integer('fees');
            $table->timestamps();

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
        Schema::dropIfExists('clinics');
    }
};
