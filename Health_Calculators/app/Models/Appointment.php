<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Appointment extends Model
{
    use HasFactory;
    use  SoftDeletes;

    public $table = "appointments";
    protected $dates = ['deleted_at'];
    protected $fillable = ['patient_id', 'worktime_id',	'date',
                            'payment_type',	'appointment_fees', 'slot_id', 'payment_id'];


    public function getWorktime() {
        return $this->belongsTo('App\Models\Worktime', 'worktime_id');
    }

    public function getPatient() {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }

    public function getDigitalprescription() {
        return $this->hasOne('App\Models\Digitalprescription');
    }

    public function getDeletedAppment() {
        return $this->hasOne('App\Models\Deletedappointment');
    }

    public function getPayment() {
        return $this->belongsTo('App\Models\Payment', 'payment_id');
    }

}
