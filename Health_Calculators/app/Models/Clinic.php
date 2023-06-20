<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    public $table = "clinics";
    protected $fillable = ['name',	'clinic_address', 'phone_number',
                            'fees'];

    public function getDoctor() {
        return $this->hasMany('App\Models\Doctor');
    }

}
