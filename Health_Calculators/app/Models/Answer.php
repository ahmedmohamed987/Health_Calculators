<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    public $table = "answers";
    protected $fillable = ['doctor_id',	'question_id', 'answer', 'patient_id'];

    public function getDoctor() {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }

    public function getQuestion() {
        return $this->belongsTo('App\Models\Question', 'question_id');
    }

    public function getPatient() {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
}
