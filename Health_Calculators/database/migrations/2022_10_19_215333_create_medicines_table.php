<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use League\CommonMark\Extension\Table\Table;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('prescription_id')->unsigned()->nullable();
            $table->string('name');
            $table->double('dosage');
            $table->integer('period');
            $table->time('time');
            $table->longText('notes');
            $table->timestamps();

            $table->foreign('prescription_id')->references('id')
                    ->on('digitalprescriptions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
};
