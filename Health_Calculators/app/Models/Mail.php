<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'request_id'];

    public function getRequest() {
        return $this->belongsTo('App\Models\Req', 'request_id');
    }

}
