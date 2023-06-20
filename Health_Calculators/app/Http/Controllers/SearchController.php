<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Req;
use App\Models\Rate;
use App\Models\City;
use App\Models\Governorate;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function Search(Request $request)
    {

        $searchQuery = $request->searchQuery;

        $DoctorsQuery=Req::select('doctors.id', 'requests.first_name', 'requests.last_name', 'requests.address', 'doctors.profile_image',
                                'requests.specialty_type as speciality_type','clinics.clinic_address as clinic_address','doctors.clinic_id',
                                'doctors.request_id')->leftJoin('doctors','doctors.request_id','=','requests.id')
                                ->leftJoin('clinics','doctors.clinic_id','clinics.id')
                                ->where('request_status','=',1)->where('doctors.clinic_id','!=',null);

        if(!empty($request->searchQuery))
        {
            $DoctorsQuery->where(function($query) use ($searchQuery){
                $query->where('requests.first_name', 'LIKE', '%'.$searchQuery.'%');
                $query->orWhere('requests.last_name', 'LIKE', '%'.$searchQuery.'%');
                $query->orWhere(DB::raw('CONCAT_WS(" ", requests.first_name, requests.last_name)'), 'like', '%' . $searchQuery . '%');
                $query->orWhere('requests.specialty_type', 'LIKE', '%'.$searchQuery.'%');
                $query->orWhere('clinics.clinic_address', 'LIKE', '%'.$searchQuery.'%');
                $query->orWhere('clinics.detailed_clinic_address', 'LIKE', '%'.$searchQuery.'%');
            });
        }

        if(!empty($request->search_speciality_type))
        {
            $DoctorsQuery->where('requests.specialty_type','like','%'.$request->search_speciality_type.'%');
        }

        $search_by_location = 0;
        if(!empty($request->search_gov) && isset($request->search_gov))
        {
            $search_by_location = 1;
            $DoctorsQuery->where('clinics.clinic_address','LIKE', '%'.$request->search_gov.'%')->get();
        }

        if(!empty($request->search_city) && isset($request->search_city)) {
            $search_by_location = 1;
            if (($request->search_city[0]=='a' || $request->search_city[0]=='A' || $request->search_city[0]=='e' || $request->search_city[0]=='E') && ($request->search_city[1]=='l') || $request->search_city[1]=='L'){
                $alSearch = '';
                $elSearch = '';
                if($request->search_city[0]=='a' || $request->search_city[0]=='A'){
                    $alSearch = $request->search_city;
                    $elSearch = $alSearch;
                    $elSearch[0]='e';
                } else {
                    $elSearch = $request->search_city;
                    $alSearch = $elSearch;
                    $alSearch[0]='a';
                }

                $DoctorsQuery->where(function($query) use ($elSearch,$alSearch){
                    $query->where('clinics.detailed_clinic_address', 'LIKE', '%'.$elSearch.'%');
                    $query->orWhere('clinics.detailed_clinic_address', 'LIKE', '%'.$alSearch.'%');
                });
            } else{
                $DoctorsQuery->where('clinics.detailed_clinic_address','LIKE', '%'.$request->search_city.'%')->get();
            }
        }

        $cloneQuery = clone $DoctorsQuery;
        $cloneQueryResult = $cloneQuery->get();

        $count_doctors=count($cloneQueryResult);
        $pages=$count_doctors/10.0;
        $number_of_pages=ceil($pages);

        $currentPage = 1;
        if(isset($request->search_page) && !empty($request->search_page))
            $currentPage = $request->search_page;

        $Doctors = $DoctorsQuery->get();

        $Doctors->transform(function($value){

            $value->avg_rate = 0;
            $doctorRatesSum = Rate::select('rates.rate')->where('rates.doctor_id',$value->id)->sum('rates.rate');
            $doctorRatesCount = Rate::select('rates.rate')->where('rates.doctor_id',$value->id)->count('rates.rate');

            if($doctorRatesCount != 0)
            {
                $value->avg_rate = $doctorRatesSum/$doctorRatesCount;
            }

            return $value;
        });

        if(!empty($request->search_by_rating) && isset($request->search_by_rating) && $request->search_by_rating == 1)
            $Doctors = $Doctors->sortByDesc('avg_rate');

        $searchQuery = $request->searchQuery;
        $speciality_type = $request->search_speciality_type;
        $search_location = $request->search_location;
        $search_by_rating = $request->search_by_rating;
        $search_gov= $request->search_gov;
        $search_city= $request->search_city;
        $value_of_doctor_rates=[];

        foreach($Doctors as $Doctor) {
            $doctor_rates = Rate::where('doctor_id', '=', $Doctor->id)->get();
            $summation_of_doctor_rates = Rate::where('doctor_id', '=', $Doctor->id)->sum('rate');
            if($doctor_rates->count() > 0) {
                $value_of_doctor_rates[] = array('dr_id' => $Doctor->id, 'dr_rate' => $summation_of_doctor_rates / $doctor_rates->count());
            }
            else {
                $value_of_doctor_rates[] = array('dr_id'=> $Doctor->id, 'dr_rate' => 0);
            }
        }
        $Governorates=Governorate::all();
        $Cities = City::select('cities.id', 'cities.name','cities.governorate_id')->get();
        $Doctors = $Doctors->toArray();
        $numberOfUnset = ($currentPage-1)*10;
        $unsetCounter = 0;
        if($currentPage != 1) {
            foreach($Doctors as $key => $value) {
                if($unsetCounter != $numberOfUnset) {
                    unset($Doctors[$key]);
                }
                else
                    break;

                $unsetCounter++;
            }
        }

        $Doctors = array_slice($Doctors,0,10);
        return view ('Public-Views.result',compact('Doctors','searchQuery','speciality_type','search_location','Governorates','Cities', 'number_of_pages','search_by_rating','search_by_location','search_gov','search_city'),
                        ['value_of_doctor_rates' => $value_of_doctor_rates]);

    }

    public function SearchCity(Request $request)
    {
        $cities = City::select('cities.id','cities.name','cities.governorate_id','governorates.governorate_name')
        ->join('governorates','governorates.id','cities.governorate_id')
        ->where('governorate_id',$request->gov);

        if(isset($request->city) && !empty($request->city))
        {
            $cities = $cities->where('name','LIKE', '%'.$request->city.'%');
        }
        return response()->json($cities->get());
    }
}