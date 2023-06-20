<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $table = "questions";
    protected $fillable = ['patient_id', 'question'];

    public function getPatient() {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }

}
