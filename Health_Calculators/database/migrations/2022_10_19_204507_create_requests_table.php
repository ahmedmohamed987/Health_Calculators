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
        Schema::create('requests', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('request_status');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->integer('registration_number');
            $table->date('registration_date');
            $table->integer('last_year_of_payment');
            $table->date('expiry_date');
            $table->string('specialty_type');
            $table->binary('gulid_card_image');
            $table->integer('admin_id')->unsigned()->nullable();
            // $table->unsignedBigInteger('admin_id');
            $table->timestamps();

            $table->foreign('admin_id')->references('id')
                    ->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
