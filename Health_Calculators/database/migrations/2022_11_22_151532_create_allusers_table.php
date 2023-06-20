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
        Schema::create('allusers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role')->default(0);
            $table->string('email');
            $table->string('password');
            $table->integer('admin_id')->unsigned()->nullable();
            $table->integer('patient_id')->unsigned()->nullable();
            $table->integer('request_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('admin_id')->references('id')
                    ->on('admins')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')
                    ->on('patients')->onDelete('cascade');
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
        Schema::dropIfExists('allusers');
    }
};
