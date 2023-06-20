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
        Schema::create('digitalprescriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('appointment_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('appointment_id')->references('id')
                    ->on('appointments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('digitalprescriptions');
    }
};
