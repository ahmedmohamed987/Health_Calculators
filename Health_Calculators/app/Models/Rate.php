<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    public $table = "rates";
    protected $fillable = ['patient_id', 'doctor_id', 'rate'];

    public function getDoctor() {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }

    public function getPatient() {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }

}
