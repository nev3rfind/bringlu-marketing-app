<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\AdvertStatus;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdvertStatus>
 */
class AdvertStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     * Runs only for testing purpose
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "advertiser_id" => $this->faker->unique()->numberBetween(1,500),
            "advert_id" => $this->faker->unique()->numberBetween(1,500),
            "user_id" => $this->faker->unique()->numberBetween(1,500),
            "advert_status" => 'pending',
            "extra_details" => $this->faker->text(50),
            "last_actioned_at" => $this->faker->dateTime(),
        ];
    }
}
