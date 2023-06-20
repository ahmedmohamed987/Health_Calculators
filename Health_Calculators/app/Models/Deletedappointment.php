<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deletedappointment extends Model
{
    use HasFactory;

    public $table = "deletedappointments";
    protected $fillable = ['appointment_id', 'reason'];

    public function getAppointment() {
        return $this->belongsTo('App\Models\Appointment', 'appointment_id');
    }

}
