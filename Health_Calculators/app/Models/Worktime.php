<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worktime extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "worktimes";
    protected $fillable = ['clinic_id',	'start_time', 'end_time', 'day'];

    public function getClinic() {
        return $this->belongsTo('App\Models\Clinic', 'clinic_id');
    }

    public function getAppointment() {
        return $this->hasMany('App\Models\Appointment');
    }

}
