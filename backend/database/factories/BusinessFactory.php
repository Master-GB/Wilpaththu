<?php

namespace Database\Factories;

use App\Enums\BusinessType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BusinessFactory extends Factory
{
    public function definition(): array
    {
        return [

            'owner_id' => User::factory(),

            'business_name' => fake()->company(),

            'description' => fake()->paragraph(),

            'registration_number' => fake()->unique()->bothify('REG-#####'),

            'business_type' => fake()->randomElement([
                BusinessType::JEEP,
                BusinessType::TRANSPORT,
            ]),

            'contact_number' => fake()->phoneNumber(),

            'email' => fake()->companyEmail(),

            'address' => fake()->address(),

            'district' => fake()->city(),

            'is_verified' => false,

            'verified_at' => null,

            'is_active' => true,
        ];
    }

    public function verified(): static
    {
        return $this->state(fn () => [
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }
}
