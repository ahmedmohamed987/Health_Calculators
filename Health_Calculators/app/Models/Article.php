<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    public $table = "articles";
    protected $fillable = ['admin_id', 'title', 'content', 'image'];

    public function getAdmin() {
        return $this->belongsTo('App\Models\Admin', 'admin_id');
    }

}
