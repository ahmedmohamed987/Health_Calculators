<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    public $table="doctors";
    protected $fillable = ['request_id', 'profile_image', 'bio', 'phone_number', 'clinic_id'];

    public function getRequest() {
        return $this->belongsTo('App\Models\Request', 'request_id');
    }

    public function getAnswer() {
        return $this->hasMany('App\Models\Answer');
    }

    public function getRate() {
        return $this->hasMany('App\Models\Rate');
    }

    public function getClinic() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id');
    }

    public function getDigitalPrescription() {
        return $this->hasMany('App\Models\Digitalprescription');
    }


}
