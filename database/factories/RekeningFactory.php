<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rekening>
 */
class RekeningFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_rekening' => $this->faker->name,
            'nama_bank' => $this->faker->randomElement(['Bank A', 'Bank B', 'Bank C']),
            'no_rekening' => $this->faker->bankAccountNumber,
        ];
    }
}
