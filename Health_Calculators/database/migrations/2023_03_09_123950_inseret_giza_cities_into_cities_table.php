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

                ['name' => 'Ard Ellwaa',
                'governorate_id' => 11],

                ['name' => 'Smart Village',
                'governorate_id' => 11],

                ['name' => 'Saft Allaban',
                'governorate_id' => 11],

                ['name' => 'Hadayek October',
                'governorate_id' => 11],

                ['name' => 'Haraneya',
                'governorate_id' => 11],

                ['name' => 'Hadayek Alahram',
                'governorate_id' => 11],

                ['name' => 'Abu Rawash',
                'governorate_id' => 11],

                ['name' => 'Sixth of October',
                'governorate_id' => 11],

                ['name' => 'Cheikh Zayed',
                'governorate_id' => 11],

                ['name' => 'Hawamdiyah',
                'governorate_id' => 11],

                ['name' => 'Al Badrasheen',
                'governorate_id' => 11],

                ['name' => 'Saf',
                'governorate_id' => 11],

                ['name' => 'Atfih',
                'governorate_id' => 11],

                ['name' => 'Al Ayat',
                'governorate_id' => 11],

                ['name' => 'Al-Bawaiti',
                'governorate_id' => 11],

                ['name' => 'Manshiyet Al Qanater',
                'governorate_id' => 11],

                ['name' => 'Oaseem',
                'governorate_id' => 11],

                ['name' => 'Kerdasa',
                'governorate_id' => 11],

                ['name' => 'Abu Nomros',
                'governorate_id' => 11],

                ['name' => 'Kafr Ghati',
                'governorate_id' => 11],

                ['name' => 'Manshiyet Al Bakari',
                'governorate_id' => 11],

                ['name' => 'Dokki',
                'governorate_id' => 11],

                ['name' => 'Agouza',
                'governorate_id' => 11],

                ['name' => 'Haram',
                'governorate_id' => 11],

                ['name' => 'Warraq',
                'governorate_id' => 11],

                ['name' => 'Imbaba',
                'governorate_id' => 11],

                ['name' => 'Boulaq Dakrour',
                'governorate_id' => 11],

                ['name' => 'Al Wahat Al Baharia',
                'governorate_id' => 11],

                ['name' => 'Omraneya',
                'governorate_id' => 11],

                ['name' => 'Moneeb',
                'governorate_id' => 11],

                ['name' => 'Bin Alsarayat',
                'governorate_id' => 11],

                ['name' => 'Kit Kat',
                'governorate_id' => 11],

                ['name' => 'Mohandessin',
                'governorate_id' => 11],

                ['name' => 'Faisal',
                'governorate_id' => 11],

                //
                ['name' => 'Abu Qir',
                'governorate_id' => 1],

                ['name' => 'Al Ibrahimeyah',
                'governorate_id' => 1],

                ['name' => 'Azarita',
                'governorate_id' => 1],

                ['name' => 'Anfoushi',
                'governorate_id' => 1],

                ['name' => 'Dekheila',
                'governorate_id' => 1],

                ['name' => 'El Soyof',
                'governorate_id' => 1],

                ['name' => 'Ameria',
                'governorate_id' => 1],

                ['name' => 'El Labban',
                'governorate_id' => 1],

                ['name' => 'Al Mafrouza',
                'governorate_id' => 1],

                ['name' => 'El Montaza',
                'governorate_id' => 1],

                ['name' => 'Mansheya',
                'governorate_id' => 1],

                ['name' => 'Naseria',
                'governorate_id' => 1],

                ['name' => 'Ambrozo',
                'governorate_id' => 1],

                ['name' => 'Bab Sharq',
                'governorate_id' => 1],

                ['name' => 'Bourj Alarab',
                'governorate_id' => 1],

                ['name' => 'Stanley',
                'governorate_id' => 1],

                ['name' => 'Smouha',
                'governorate_id' => 1],

                ['name' => 'Sidi Bishr',
                'governorate_id' => 1],

                ['name' => 'Shads',
                'governorate_id' => 1],

                ['name' => 'Gheet Alenab',
                'governorate_id' => 1],

                ['name' => 'Fleming',
                'governorate_id' => 1],

                ['name' => 'Victoria',
                'governorate_id' => 1],

                ['name' => 'Camp Shizar',
                'governorate_id' => 1],

                ['name' => 'Karmooz',
                'governorate_id' => 1],

                ['name' => 'Mahta Alraml',
                'governorate_id' => 1],

                ['name' => 'Mina El-Basal',
                'governorate_id' => 1],

                ['name' => 'Asafra',
                'governorate_id' => 1],

                ['name' => 'Agamy',
                'governorate_id' => 1],

                ['name' => 'Bakos',
                'governorate_id' => 1],

                ['name' => 'Boulkly',
                'governorate_id' => 1],

                ['name' => 'Cleopatra',
                'governorate_id' => 1],

                ['name' => 'Glim',
                'governorate_id' => 1],

                ['name' => 'Al Mamurah',
                'governorate_id' => 1],

                ['name' => 'Al Mandara',
                'governorate_id' => 1],

                ['name' => 'Moharam Bek',
                'governorate_id' => 1],

                ['name' => 'Elshatby',
                'governorate_id' => 1],

                ['name' => 'Sidi Gaber',
                'governorate_id' => 1],

                ['name' => 'North Coast',
                'governorate_id' => 1],

                ['name' => 'Alhadra',
                'governorate_id' => 1],

                ['name' => 'Alattarin',
                'governorate_id' => 1],

                ['name' => 'Sidi Kerir',
                'governorate_id' => 1],

                ['name' => 'Elgomrok',
                'governorate_id' => 1],

                ['name' => 'Al Max',
                'governorate_id' => 1],

                ['name' => 'Marina',
                'governorate_id' => 1],

                ['name' => 'Mansoura',
                'governorate_id' => 7],

                ['name' => 'Talkha',
                'governorate_id' => 7],

                ['name' => 'Mitt Ghamr',
                'governorate_id' => 7],

                ['name' => 'Dekernes',
                'governorate_id' => 7],

                ['name' => 'Aga',
                'governorate_id' => 7],

                ['name' => 'Menia El Nasr',
                'governorate_id' => 7],

                ['name' => 'Sinbillawin',
                'governorate_id' => 7],

                ['name' => 'El Kurdi',
                'governorate_id' => 7],

                ['name' => 'Bani Ubaid',
                'governorate_id' => 7],

                ['name' => 'Al Manzala',
                'governorate_id' => 7],

                ['name' => 'tami al-amdid',
                'governorate_id' => 7],

                ['name' => 'aljamalia',
                'governorate_id' => 7],

                ['name' => 'Sherbin',
                'governorate_id' => 7],

                ['name' => 'Mataria',
                'governorate_id' => 7],

                ['name' => 'Belqas',
                'governorate_id' => 7],

                ['name' => 'Meet Salsil',
                'governorate_id' => 7],

                ['name' => 'Gamasa',
                'governorate_id' => 7],

                ['name' => 'Mahalat Damana',
                'governorate_id' => 7],

                ['name' => 'Nabroh',
                'governorate_id' => 7],

                ['name' => 'Hurghada',
                'governorate_id' => 23],

                ['name' => 'Ras Ghareb',
                'governorate_id' => 23],

                ['name' => 'Safaga',
                'governorate_id' => 23],

                ['name' => 'El Qusiar',
                'governorate_id' => 23],

                ['name' => 'Marsa Alam',
                'governorate_id' => 23],

                ['name' => 'Shalatin',
                'governorate_id' => 23],

                ['name' => 'Halaib',
                'governorate_id' => 23],

                ['name' => 'Aldahar',
                'governorate_id' => 23],

                ['name' => 'Damanhour',
                'governorate_id' => 4],

                ['name' => 'Kafr El Dawar',
                'governorate_id' => 4],

                ['name' => 'Rashid',
                'governorate_id' => 4],

                ['name' => 'Edco',
                'governorate_id' => 4],

                ['name' => 'Abu al-Matamir',
                'governorate_id' => 4],

                ['name' => 'Abu Homs',
                'governorate_id' => 4],

                ['name' => 'Delengat',
                'governorate_id' => 4],

                ['name' => 'Mahmoudiyah',
                'governorate_id' => 4],

                ['name' => 'Rahmaniyah',
                'governorate_id' => 4],

                ['name' => 'Itai Baroud',
                'governorate_id' => 4],

                ['name' => 'Housh Eissa',
                'governorate_id' => 4],

                ['name' => 'Shubrakhit',
                'governorate_id' => 4],

                ['name' => 'Kom Hamada',
                'governorate_id' => 4],

                ['name' => 'Badr',
                'governorate_id' => 4],

                ['name' => 'Wadi Natrun',
                'governorate_id' => 4],

                ['name' => 'New Nubaria',
                'governorate_id' => 4],

                ['name' => 'Alnoubareya',
                'governorate_id' => 4],

                ['name' => 'Fayoum El Gedida',
                'governorate_id' => 9],

                ['name' => 'Tamiya',
                'governorate_id' => 9],

                ['name' => 'Snores',
                'governorate_id' => 9],

                ['name' => 'Etsa',
                'governorate_id' => 9],

                ['name' => 'Epschway',
                'governorate_id' => 9],

                ['name' => 'Yusuf El Sediaq',
                'governorate_id' => 9],

                ['name' => 'Hadqa',
                'governorate_id' => 9],

                ['name' => 'Atsa',
                'governorate_id' => 9],

                ['name' => 'Algamaa',
                'governorate_id' => 9],

                ['name' => 'Sayala',
                'governorate_id' => 9],

                ['name' => 'Tanta',
                'governorate_id' => 10],

                ['name' => 'Al Mahalla Al Kobra',
                'governorate_id' => 10],

                ['name' => 'Kafr El Zayat',
                'governorate_id' => 10],

                ['name' => 'Zefta',
                'governorate_id' => 10],

                ['name' => 'El Santa',
                'governorate_id' => 10],

                ['name' => 'Qutour',
                'governorate_id' => 10],

                ['name' => 'Basion',
                'governorate_id' => 10],

                ['name' => 'Samannoud',
                'governorate_id' => 10],

                ['name' => 'Fayed',
                'governorate_id' => 12],

                ['name' => 'Qantara Sharq',
                'governorate_id' => 12],

                ['name' => 'Qantara Gharb',
                'governorate_id' => 12],

                ['name' => 'El Tal El Kabier',
                'governorate_id' => 12],

                ['name' => 'Abu Sawir',
                'governorate_id' => 12],

                ['name' => 'Kasasien El Gedida',
                'governorate_id' => 12],

                ['name' => 'Nefesha',
                'governorate_id' => 12],

                ['name' => 'Sheikh Zayed',
                'governorate_id' => 12],

                ['name' => 'Shbeen El Koom',
                'governorate_id' => 17],

                ['name' => 'Sadat City',
                'governorate_id' => 17],

                ['name' => 'Menouf',
                'governorate_id' => 17],

                ['name' => 'Sars El-Layan',
                'governorate_id' => 17],

                ['name' => 'Ashmon',
                'governorate_id' => 17],

                ['name' => 'Al Bagor',
                'governorate_id' => 17],

                ['name' => 'Quesna',
                'governorate_id' => 17],

                ['name' => 'Berkat El Saba',
                'governorate_id' => 17],

                ['name' => 'Al Shohada',
                'governorate_id' => 17],

                ['name' => 'Minya El Gedida',
                'governorate_id' => 16],

                ['name' => 'El Adwa',
                'governorate_id' => 16],

                ['name' => 'Magagha',
                'governorate_id' => 16],

                ['name' => 'Bani Mazar',
                'governorate_id' => 16],

                ['name' => 'Mattay',
                'governorate_id' => 16],

                ['name' => 'Samalut',
                'governorate_id' => 16],

                ['name' => 'Madinat El Fekria',
                'governorate_id' => 16],

                ['name' => 'Deir Mawas',
                'governorate_id' => 16],

                ['name' => 'Meloy',
                'governorate_id' => 16],

                ['name' => 'Abu Qurqas',
                'governorate_id' => 16],

                ['name' => 'Ard Sultan',
                'governorate_id' => 16],

                ['name' => 'Banha',
                'governorate_id' => 21],

                ['name' => 'Qalyub',
                'governorate_id' => 21],

                ['name' => 'Shubra Al Khaimah',
                'governorate_id' => 21],

                ['name' => 'Al Qanater Charity',
                'governorate_id' => 21],

                ['name' => 'Khanka',
                'governorate_id' => 21],

                ['name' => 'Kafr Shukr',
                'governorate_id' => 21],

                ['name' => 'Tukh',
                'governorate_id' => 21],

                ['name' => 'Qaha',
                'governorate_id' => 21],

                ['name' => 'Obour',
                'governorate_id' => 21],

                ['name' => 'Khosous',
                'governorate_id' => 21],

                ['name' => 'Shibin Al Qanater',
                'governorate_id' => 21],

                ['name' => 'Mostorod',
                'governorate_id' => 21],

                ['name' => 'El Kharga',
                'governorate_id' => 18],

                ['name' => 'Paris',
                'governorate_id' => 18],

                ['name' => 'Mout',
                'governorate_id' => 18],

                ['name' => 'Farafra',
                'governorate_id' => 18],

                ['name' => 'Balat',
                'governorate_id' => 18],

                ['name' => 'Dakhla',
                'governorate_id' => 18],

                ['name' => 'Suez',
                'governorate_id' => 27],

                ['name' => 'Alganayen',
                'governorate_id' => 27],

                ['name' => 'Ataqah',
                'governorate_id' => 27],

                ['name' => 'Ain Sokhna',
                'governorate_id' => 27],

                ['name' => 'Faysal',
                'governorate_id' => 27],

                ['name' => 'Aswan El Gedida',
                'governorate_id' => 2],

                ['name' => 'Drau',
                'governorate_id' => 2],

                ['name' => 'Kom Ombo',
                'governorate_id' => 2],

                ['name' => 'Nasr Al Nuba',
                'governorate_id' => 2],

                ['name' => 'Kalabsha',
                'governorate_id' => 2],

                ['name' => 'Edfu',
                'governorate_id' => 2],

                ['name' => 'Al-Radisiyah',
                'governorate_id' => 2],

                ['name' => 'Al Basilia',
                'governorate_id' => 2],

                ['name' => 'Al Sibaeia',
                'governorate_id' => 2],

                ['name' => 'Abo Simbl Al Siyahia',
                'governorate_id' => 2],

                ['name' => 'Marsa Alam',
                'governorate_id' => 2],

                ['name' => 'Asyut El Gedida',
                'governorate_id' => 3],

                ['name' => 'Dayrout',
                'governorate_id' => 3],

                ['name' => 'Manfalut',
                'governorate_id' => 3],

                ['name' => 'Qusiya',
                'governorate_id' => 3],

                ['name' => 'Abnoub',
                'governorate_id' => 3],

                ['name' => 'Abu Tig',
                'governorate_id' => 3],

                ['name' => 'El Ghanaim',
                'governorate_id' => 3],

                ['name' => 'Sahel Selim',
                'governorate_id' => 3],

                ['name' => 'El Badari',
                'governorate_id' => 3],

                ['name' => 'Sidfa',
                'governorate_id' => 3],

                ['name' => 'Beni Suef El Gedida',
                'governorate_id' => 5],

                ['name' => 'Al Wasta',
                'governorate_id' => 5],

                ['name' => 'Naser',
                'governorate_id' => 5],

                ['name' => 'Ehnasia',
                'governorate_id' => 5],

                ['name' => 'beba',
                'governorate_id' => 5],

                ['name' => 'Fashn',
                'governorate_id' => 5],

                ['name' => 'Somasta',
                'governorate_id' => 5],

                ['name' => 'Alabbaseri',
                'governorate_id' => 5],

                ['name' => 'Mokbel',
                'governorate_id' => 5],

                ['name' => 'Port Fouad',
                'governorate_id' => 20],

                ['name' => 'Alarab',
                'governorate_id' => 20],

                ['name' => 'Zohour',
                'governorate_id' => 20],

                ['name' => 'Alsharq',
                'governorate_id' => 20],

                ['name' => 'Aldawahi',
                'governorate_id' => 20],

                ['name' => 'Almanakh',
                'governorate_id' => 20],

                ['name' => 'Mubarak',
                'governorate_id' => 20],

                ['name' => 'New Damietta',
                'governorate_id' => 8],

                ['name' => 'Ras El Bar',
                'governorate_id' => 8],

                ['name' => 'Faraskour',
                'governorate_id' => 8],

                ['name' => 'Zarqa',
                'governorate_id' => 8],

                ['name' => 'Alsaru',
                'governorate_id' => 8],

                ['name' => 'Alruwda',
                'governorate_id' => 8],

                ['name' => 'Kafr El-Batikh',
                'governorate_id' => 8],

                ['name' => 'Azbet Al Burg',
                'governorate_id' => 8],

                ['name' => 'Meet Abou Ghalib',
                'governorate_id' => 8],

                ['name' => 'Kafr Saad',
                'governorate_id' => 8],

                ['name' => 'Zagazig',
                'governorate_id' => 24],

                ['name' => 'Al Ashr Men Ramadan',
                'governorate_id' => 24],

                ['name' => 'Minya Al Qamh',
                'governorate_id' => 24],

                ['name' => 'Belbeis',
                'governorate_id' => 24],

                ['name' => 'Mashtoul El Souq',
                'governorate_id' => 24],

                ['name' => 'Qenaiat',
                'governorate_id' => 24],

                ['name' => 'Abu Hammad',
                'governorate_id' => 24],

                ['name' => 'El Qurain',
                'governorate_id' => 24],

                ['name' => 'Hehia',
                'governorate_id' => 24],

                ['name' => 'Abu Kabir',
                'governorate_id' => 24],

                ['name' => 'Faccus',
                'governorate_id' => 24],

                ['name' => 'El Salihia El Gedida',
                'governorate_id' => 24],

                ['name' => 'Al Ibrahimiyah',
                'governorate_id' => 24],

                ['name' => 'Deirb Negm',
                'governorate_id' => 24],

                ['name' => 'Kafr Saqr',
                'governorate_id' => 24],

                ['name' => 'Awlad Saqr',
                'governorate_id' => 24],

                ['name' => 'Husseiniya',
                'governorate_id' => 24],

                ['name' => 'San Alhajar Alqablia',
                'governorate_id' => 24],

                ['name' => 'Manshayat Abu Omar',
                'governorate_id' => 24],

                ['name' => 'Al Toor',
                'governorate_id' => 27],

                ['name' => 'Sharm El-Shaikh',
                'governorate_id' => 27],

                ['name' => 'Dahab',
                'governorate_id' => 27],

                ['name' => 'Nuweiba',
                'governorate_id' => 27],

                ['name' => 'Taba',
                'governorate_id' => 27],

                ['name' => 'Saint Catherine',
                'governorate_id' => 27],

                ['name' => 'Abu Redis',
                'governorate_id' => 27],

                ['name' => 'Abu Zenaima',
                'governorate_id' => 27],

                ['name' => 'Ras Sidr',
                'governorate_id' => 27],

                ['name' => 'Kafr El Sheikh Downtown',
                'governorate_id' => 13],

                ['name' => 'Desouq',
                'governorate_id' => 13],

                ['name' => 'Fooh',
                'governorate_id' => 13],

                ['name' => 'Metobas',
                'governorate_id' => 13],

                ['name' => 'Burg Al Burullus',
                'governorate_id' => 13],

                ['name' => 'Baltim',
                'governorate_id' => 13],

                ['name' => 'Masief Baltim',
                'governorate_id' => 13],

                ['name' => 'Hamol',
                'governorate_id' => 13],

                ['name' => 'Bella',
                'governorate_id' => 13],

                ['name' => 'Riyadh',
                'governorate_id' => 13],

                ['name' => 'Sidi Salm',
                'governorate_id' => 13],

                ['name' => 'Qellen',
                'governorate_id' => 13],

                ['name' => 'Sidi Ghazi',
                'governorate_id' => 13],

                ['name' => 'El Hamam',
                'governorate_id' => 15],

                ['name' => 'Alamein',
                'governorate_id' => 15],

                ['name' => 'Dabaa',
                'governorate_id' => 15],

                ['name' => 'Al-Nagila',
                'governorate_id' => 15],

                ['name' => 'Sidi Brani',
                'governorate_id' => 15],

                ['name' => 'Salloum',
                'governorate_id' => 15],

                ['name' => 'Siwa',
                'governorate_id' => 15],

                ['name' => 'Marina',
                'governorate_id' => 15],

                ['name' => 'North Coast',
                'governorate_id' => 15],

                ['name' => 'New Luxor',
                'governorate_id' => 14],

                ['name' => 'Esna',
                'governorate_id' => 14],

                ['name' => 'New Tiba',
                'governorate_id' => 14],

                ['name' => 'Al ziynia',
                'governorate_id' => 14],

                ['name' => 'Al Bayadieh',
                'governorate_id' => 14],

                ['name' => 'Al Qarna',
                'governorate_id' => 14],

                ['name' => 'Armant',
                'governorate_id' => 14],

                ['name' => 'Al Tud',
                'governorate_id' => 14],

                ['name' => 'New Qena',
                'governorate_id' => 22],

                ['name' => 'Abu Tesht',
                'governorate_id' => 22],

                ['name' => 'Nag Hammadi',
                'governorate_id' => 22],

                ['name' => 'Deshna',
                'governorate_id' => 22],

                ['name' => 'Alwaqf',
                'governorate_id' => 22],

                ['name' => 'Qaft',
                'governorate_id' => 22],

                ['name' => 'Naqada',
                'governorate_id' => 22],

                ['name' => 'Farshout',
                'governorate_id' => 22],

                ['name' => 'Quos',
                'governorate_id' => 22],

                ['name' => 'Arish',
                'governorate_id' => 19],

                ['name' => 'Sheikh Zowaid',
                'governorate_id' => 19],

                ['name' => 'Nakhl',
                'governorate_id' => 19],

                ['name' => 'Rafah',
                'governorate_id' => 19],

                ['name' => 'Bir al-Abed',
                'governorate_id' => 19],

                ['name' => 'Al Hasana',
                'governorate_id' => 19],

                ['name' => 'Sohag El Gedida',
                'governorate_id' => 26],

                ['name' => 'Akhmeem',
                'governorate_id' => 26],

                ['name' => 'Akhmim El Gedida',
                'governorate_id' => 26],

                ['name' => 'Albalina',
                'governorate_id' => 26],

                ['name' => 'El Maragha',
                'governorate_id' => 26],

                ['name' => 'Almunsha\'a',
                'governorate_id' => 26],

                ['name' => 'Dar AISalaam',
                'governorate_id' => 26],

                ['name' => 'Gerga',
                'governorate_id' => 26],

                ['name' => 'Jahina Al Gharbia',
                'governorate_id' => 26],

                ['name' => 'Saqilatuh',
                'governorate_id' => 26],

                ['name' => 'Tama',
                'governorate_id' => 26],

                ['name' => 'Tahta',
                'governorate_id' => 26],

                ['name' => 'Alkawthar',
                'governorate_id' => 26],

                ['name' => 'Arbaeen',
                'governorate_id' => 25],

                ['name' => 'Ganayen',
                'governorate_id' => 25],

                ['name' => 'Attaka',
                'governorate_id' => 25],

                ['name' => 'Faisal',
                'governorate_id' => 25]
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
