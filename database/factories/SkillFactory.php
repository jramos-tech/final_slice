<?php

namespace Database\Factories;

use App\Models\RPGCharacters;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    public function definition(): array
    {
        return [
            'rpg_character_id' => RPGCharacters::factory(),
            'name' => $this->faker->randomElement(['Fireball', 'Heal', 'Stealth', 'Berserk']),
            'description' => $this->faker->sentence,
            'power_level' => $this->faker->numberBetween(1, 100),
        ];
    }
}