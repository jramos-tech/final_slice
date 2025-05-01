<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RPGCharacters extends Model
{
    use HasFactory;

    protected $table = 'r_p_g_characters';

    protected $fillable = ['class_name', 'description', 'abilities', 'image', 'rarity', 'battles_won', 'total_battles'];

    public function skills()
    {
        return $this->hasMany(Skill::class, 'rpg_character_id'); 
    }

    public function getPowerLevelAttribute()
    {
        \Log::info('Skills for Character ' . $this->id . ': ' . $this->skills->pluck('power_level'));
        return $this->skills->sum('power_level');
    }
  
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}