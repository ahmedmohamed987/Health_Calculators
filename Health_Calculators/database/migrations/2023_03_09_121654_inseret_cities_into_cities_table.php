<?php

use App\Models\City;
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
        Schema::table('cities', function (Blueprint $table) {
            $cities = array(

                ['name' => '15 May',
                'governorate_id' => 6],

                ['name' => 'Aldarb Alahmar',
                'governorate_id' => 6],

                ['name' => 'Zawya al-Hamra',
                'governorate_id' => 6],

                ['name' => 'El-Zaytoun',
                'governorate_id' => 6],

                ['name' => 'Sahel',
                'governorate_id' => 6],

                ['name' => 'El Salam',
                'governorate_id' => 6],

                ['name' => 'Sayeda Zeinab',
                'governorate_id' => 6],

                ['name' => 'New Cairo',
                'governorate_id' => 6],

                ['name' => 'El Marg',
                'governorate_id' => 6],

                ['name' => 'Ezbet el Nakhl',
                'governorate_id' => 6],

                ['name' => 'Ataba',
                'governorate_id' => 6],

                ['name' => 'El Daher',
                'governorate_id' => 6],

                ['name' => 'Shorouk',
                'governorate_id' => 6],

                ['name' => 'El Sharabeya',
                'governorate_id' => 6],

                ['name' => 'El darrasa',
                'governorate_id' => 6],

                ['name' => 'El-Khalifa',
                'governorate_id' => 6],

                ['name' => 'Tebin',
                'governorate_id' => 6],

                ['name' => 'Al Azbakeyah',
                'governorate_id' => 6],

                ['name' => 'Matareya',
                'governorate_id' => 6],

                ['name' => 'Maadi',
                'governorate_id' => 6],

                ['name' => 'Maasara',
                'governorate_id' => 6],

                ['name' => 'Mokattam',
                'governorate_id' => 6],

                ['name' => 'Manyal',
                'governorate_id' => 6],

                ['name' => 'Mosky',
                'governorate_id' => 6],

                ['name' => 'Nozha',
                'governorate_id' => 6],

                ['name' => 'Waily',
                'governorate_id' => 6],

                ['name' => 'Bab al-Shereia',
                'governorate_id' => 6],

                ['name' => 'Garden City',
                'governorate_id' => 6],

                ['name' => 'Hadayek El-Kobba',
                'governorate_id' => 6],

                ['name' => 'Helwan',
                'governorate_id' => 6],

                ['name' => 'Dar Al Salam',
                'governorate_id' => 6],

                ['name' => 'Shubra',
                'governorate_id' => 6],

                ['name' => 'Tura',
                'governorate_id' => 6],

                ['name' => 'Abdeen',
                'governorate_id' => 6],

                ['name' => 'Abaseya',
                'governorate_id' => 6],

                ['name' => 'Ain Shams',
                'governorate_id' => 6],

                ['name' => 'Nasr City',
                'governorate_id' => 6],

                ['name' => 'New Heliopolis',
                'governorate_id' => 6],

                ['name' => 'Masr Al Qadima',
                'governorate_id' => 6],

                ['name' => 'Mansheya Nasir',
                'governorate_id' => 6],

                ['name' => 'Badr City',
                'governorate_id' => 6],

                ['name' => 'Obour City',
                'governorate_id' => 6],

                ['name' => 'Cairo Downtown',
                'governorate_id' => 6],

                ['name' => 'Zamalek',
                'governorate_id' => 6],

                ['name' => 'Kasr El Nile',
                'governorate_id' => 6],

                ['name' => 'Rehab',
                'governorate_id' => 6],

                ['name' => 'Katameya',
                'governorate_id' => 6],

                ['name' => 'Madinty',
                'governorate_id' => 6],

                ['name' => 'Rod Alfarag',
                'governorate_id' => 6],

                ['name' => 'Sheraton',
                'governorate_id' => 6],

                ['name' => 'El-Gamaleya',
                'governorate_id' => 6],

                ['name' => '10th of Ramadan City',
                'governorate_id' => 6],

                ['name' => 'Helmeyat Alzaytoun',
                'governorate_id' => 6],

                ['name' => 'New Nozha',
                'governorate_id' => 6],

                ['name' => 'Capital New',
                'governorate_id' => 6]

            );

            foreach ($cities as $c){
                $city = new City;
                $city->governorate_id = $c['governorate_id'];
                $city->name = $c['name'];
                $city->save();
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
        Schema::table('cities', function (Blueprint $table) {
            //
        });
    }
};
