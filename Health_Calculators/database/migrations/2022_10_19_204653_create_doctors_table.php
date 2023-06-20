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
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('request_id')->unsigned()->nullable();
            // $table->unsignedBigInteger('request_id');
            $table->binary('profile_image');
            $table->longText('bio');
            $table->string('phone_number');
            $table->timestamps();

            $table->foreign('request_id')->references('id')
                    ->on('requests')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
};
