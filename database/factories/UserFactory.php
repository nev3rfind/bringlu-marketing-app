<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Faker\Generator as Faker;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     * Runs only for testing purpose
     *
     * @return array<string, mixed>
     */
    public function definition() {
            return [
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'phone' => $this->faker->phoneNumber,
                'email' => $this->faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'account_type' => $this->faker->numberBetween(1,2)
            ];
    }
}

    
