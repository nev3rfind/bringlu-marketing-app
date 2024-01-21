<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Advert;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advert>
 */
class AdvertFactory extends Factory
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
                "user_id" => $this->faker->unique()->numberBetween(1,500),
                "advert_category_id" => $this->faker->numberBetween(1,5),
                "advert_media_id" => $this->faker->numberBetween(1,7),
                "advert_name" => $this->faker->text(10),
                "industry" => $this->faker->text(10),
                "start_date" => $this->faker->dateTime(),
                "end_date" => $this->faker->dateTime(),
                "description" => $this->faker->text(50),
                "current_status" => $this->faker->numberBetween(1,2),
                "priority_level" => $this->faker->numberBetween(1,3),
                "web_url" => $this->faker->url(),
                "max_advertisers_count" => $this->faker->numberBetween(1,10),
                "comments" => $this->faker->text(50),
                "creator_ip_address" => $this->faker->ipv4()
        ];
    }
}
