<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = ['name', 'author', 'publishing', 'description', 'img_src','section_id'];

    // public function phone()
    // {
    //   return $this->hasOne('App\Section');
    // }
}
