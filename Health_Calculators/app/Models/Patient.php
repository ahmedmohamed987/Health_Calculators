<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    public $table = "patients";
    protected $fillable = ['first_name', 'last_name',
                            'age', 'gender', 'address',
                            'phone_number', 'profile_image', 'user_id'];

    public function getAppointment() {
        return $this->hasMany('App\Models\Appointment');
    }

    public function getCreditcard() {
        return $this->hasOne('App\Models\Creditcard');
    }

    public function getQuestion() {
        return $this->hasMany('App\Models\Question');
    }

    public function getRate() {
        return $this->hasMany('App\Models\Rate');
    }

    public function getAllUser() {
        return $this->belongsTo('App\Models\Alluser', 'user_id');
    }

    public function getAnswer() {
        return $this->hasMany('App\Models\Answer');
    }


}
