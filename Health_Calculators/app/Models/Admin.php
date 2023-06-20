<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    public $table ='admins';
    protected $fillable = ['first_name', 'last_name', 'age', 'phone_number',
                            'profile_image', 'user_id', 'gender' ];

    public function getArticle() {
        return $this->hasMany('App\Models\Article');
    }

    public function getRequest() {
        return $this->hasMany('App\Models\Request');
    }

    public function getAllUser() {
        return $this->belongsTo('App\Models\Alluser', 'user_id');
    }
}
