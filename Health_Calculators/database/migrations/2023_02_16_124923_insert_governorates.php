<?php

use App\Models\Governorate;
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
        Schema::table('governorates', function (Blueprint $table) {
            $governorates = array(
                ['governorate_name' => 'Alexandria'],
                ['governorate_name' => 'Aswan'],
                ['governorate_name' => 'Asyut'],
                ['governorate_name' => 'Beheira'],
                ['governorate_name' => 'Beni Suef'],
                ['governorate_name' => 'Cairo'],
                ['governorate_name' => 'Dakahlia'],
                ['governorate_name' => 'Damietta'],
                ['governorate_name' => 'Faiyum'],
                ['governorate_name' => 'Gharbia'],
                ['governorate_name' => 'Giza'],
                ['governorate_name' => 'Ismailia'],
                ['governorate_name' => 'Kafr El Sheikh'],
                ['governorate_name' => 'Luxor'],
                ['governorate_name' => 'Matruh'],
                ['governorate_name' => 'Minya'],
                ['governorate_name' => 'Monufia'],
                ['governorate_name' => 'New Valley'],
                ['governorate_name' => 'North Sinai'],
                ['governorate_name' => 'Port Said'],
                ['governorate_name' => 'Qalyubia'],
                ['governorate_name' => 'Qena'],
                ['governorate_name' => 'Red Sea'],
                ['governorate_name' => 'Sharqia'],
                ['governorate_name' => 'Suez'],
                ['governorate_name' => 'Sohag'],
                ['governorate_name' => 'South Sinai']

            );

            foreach ($governorates as $governorate){
                $gov = new Governorate;
                $gov->governorate_name = $governorate['governorate_name'];
                $gov->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('governorates', function (Blueprint $table) {
            //
        });
    }
};
