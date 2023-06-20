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
        Schema::create('creditcards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('patient_id')->unsigned()->nullable();
            $table->integer('card_number');
            $table->string('card_name');
            $table->integer('cvv');
            $table->date('expiry_date');
            $table->timestamps();

            $table->foreign('patient_id')->references('id')
                    ->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('creditcards');
    }
};
