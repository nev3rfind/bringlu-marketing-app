<?php

namespace Tests\Feature\AdvertiserTests;

use Tests\TestCase;
use App\Models\Advert;
use App\Models\AdvertCategory;
use App\Models\AdvertType;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class RateLimitTest extends TestCase
{
    /**
     * Rate limit test for the advert show page (limiting to 5 requests/min)
     *
     * @return void
     */
    public function test_advert_show_request_limit()
    {
      // Create advert categories and advert media types seeders -> run them
      // Otherwise advert factory will fail, because there is no data in the tables
      // for foreign keys
      $advertCategoriesSeeder = new \Database\Seeders\AdvertCategorySeeder();
      $advertMediaSeeder = new \Database\Seeders\MediaTypeSeeder();
      $advertCategoriesSeeder->run();
      $advertMediaSeeder->run();

      // Creating user factory
      $user = User::factory()->create();
      // Creating advert factory based on the creared user id
      $advert = Advert::factory()->create(['user_id' => $user->id]);
      // Then make 5 advert show requests to the advert show route
      for ($i = 0; $i < 5; ++$i) {
        $this->followingRedirects()->actingAs($user)->get(route('advert.show', $advert->id))->assertSuccessful();
      }
      // Then on the 6th you would expect to see the throtteler to stop the request
      $this->actingAs($user)->get(route('advert.show', $advert->id))->assertStatus(429); 
    }
}
