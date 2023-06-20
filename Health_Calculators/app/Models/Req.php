<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Req extends Model
{
    use HasFactory;
    public $table = "requests";
    protected $fillable = ['request_status', 'first_name', 'last_name',
                            'registration_number',
                            'registration_date', 'last_year_of_payment',
                            'expiry_date', 'specialty_type', 'gulid_card_image',
                            'age', 'gender', 'address', 'phone_number',
                            'user_id'];

    public function getAdmin() {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }

    public function getDoctor() {
        return $this->hasOne('App\Models\Doctor');
    }

    public function getAllUser() {
        return $this->belongsTo('App\Models\Alluser', 'user_id');
    }

    public function getMail() {
        return $this->hasOne('App\Models\Mail');
    }

}
