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
        Schema::table('digitalprescriptions', function (Blueprint $table) {
            $table->integer('doctor_id')->nullable()->unsigned()->after('id');

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
        Schema::table('digitalprescriptions', function (Blueprint $table) {
            //
        });
    }
};
