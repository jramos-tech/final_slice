<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'power_level', 'rpg_character_id'];

    public function character()
    {
        return $this->belongsTo(RPGCharacters::class, 'rpg_character_id'); 
    }
}
