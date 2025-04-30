<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RPGCharacters extends Model
{
    use HasFactory;

    protected $fillable = ['class_name', 'description', 'abilities', 'rarity'];

    public function skills()
    {
        return $this->hasMany(Skill::class, 'rpg_character_id'); 
    }
}