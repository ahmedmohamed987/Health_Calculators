<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    public $table = "medicines";
    protected $fillable = ['prescription_id', 'name', 'dosage',
                            'period', 'time', 'notes'];

    public function getDigitalprescription() {
        return $this->belongsTo('App\Models\Digitalprescription', 'prescription_id');
    }

}
