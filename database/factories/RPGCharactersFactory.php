<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RPGCharactersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'class_name' => $this->faker->randomElement(['Warrior', 'Mage', 'Rogue', 'Cleric']),
            'description' => $this->faker->paragraph,
            'abilities' => $this->faker->sentence,
            'rarity' => $this->faker->randomElement(['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary']),
            'battles_won' => $this->faker->numberBetween(0, 100),
            'total_battles' => $this->faker->numberBetween(1, 100),
        ];
    }
}