<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creditcard extends Model
{
    use HasFactory;

    public $table = "creditcards";
    protected $fillable = ['patient_id', 'card_number', 'card_name',
                            'cvv','expiry_date'];

    public function getPatient() {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
    
}
