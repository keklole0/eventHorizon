<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
    public function events(){
        return $this->belongsToMany(Event::class, 'event_tag');
    }
}
