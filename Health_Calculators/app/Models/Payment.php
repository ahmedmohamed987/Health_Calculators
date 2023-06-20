<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['transaction_id', 'status'];

    public $table = "payments";

    public function getAppointment() {
        return $this->hasOne('App/Models/Appointment');
    }

}
