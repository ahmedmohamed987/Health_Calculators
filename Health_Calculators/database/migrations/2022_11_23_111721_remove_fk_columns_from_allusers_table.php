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
            $table->dropColumn('patient_id');
            $table->dropColumn('request_id');
            $table->dropColumn('admin_id');
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
