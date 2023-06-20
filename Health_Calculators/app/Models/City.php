<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $table = 'cities';

    protected $fillable = ['governorate_id', 'name'];

    public function getGoveronrate() {
        return $this->belongsTo('App\Models\Governorate', 'governorate_id');
    }
    
}
