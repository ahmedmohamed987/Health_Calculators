<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digitalprescription extends Model
{
    use HasFactory;

    public $table = "digitalprescriptions";
    protected $fillable = ['doctor_id', 'appointment_id'];

    public function getAppointment() {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id');
    }

    public function getDoctor() {
        return $this->belongsTo('App\Models\Doctor', 'doctor-id');
    }

    public function getMedicine() {
        return $this->hasMany('App\Models\Medicine');
    }

}
