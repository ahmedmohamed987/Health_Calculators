<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    // public $table = "requests";
    // protected $fillable = ['request_status', 'first_name', 'last_name',
    //                     	'email', 'password', 'registration_number',
    //                         'registration_date', 'last_year_of_payment',
    //                         'expiry_date', 'specialty_type', 'gulid_card_image',
    //                         'admin_id','role'];

    // public function getAdmin() {
    //     return $this->belongsTo('App\Models\Admin', 'admin_id');
    // }

    // public function getDoctor() {
    //     return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    // }
}
