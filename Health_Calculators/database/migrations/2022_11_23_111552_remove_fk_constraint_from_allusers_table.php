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
        Schema::table('allusers', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropForeign(['request_id']);
            $table->dropForeign(['admin_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('allusers', function (Blueprint $table) {
            //
        });
    }
};
