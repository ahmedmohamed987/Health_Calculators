<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alluser extends Model
{
    use HasFactory;
    protected $fillable = ['role', 'email', 'password'];

    public function getAdmin() {
        return $this->hasOne('App\Models\Admin');
    }

    public function getPatient() {
        return $this->hasOne('App\Models\Patient');
    }

    public function getRequest() {
        return $this->hasOne('App\Models\Req');
    }
}
