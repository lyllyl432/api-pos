<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Warehouse>
 */
class WarehouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'warehouse_name' => fake()->company(),
            'warehouse_phone' => fake()->phoneNumber(),
            'warehouse_country' => fake()->country(),
            'warehouse_email' => fake()->companyEmail(),
            'warehouse_zipcode' => fake()->buildingNumber,
            'warehouse_city' => fake()->country()
        ];
    }
}
