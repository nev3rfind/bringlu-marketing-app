<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Advert;
use App\Models\AdvertCategory;
use App\Models\AdvertType;
use Carbon\Carbon;

class BusinessDeleteTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test if business customer can delete adverts and that record was succesfully deleted
     *
     * @return void
     */
    public function test_business_can_delete_advert()
    {
        $user = User::factory()->create(['account_type' => 2]);
        $advertCategoriesSeeder = new \Database\Seeders\AdvertCategorySeeder();
        $advertMediaSeeder = new \Database\Seeders\MediaTypeSeeder();
        $advertCategoriesSeeder->run();
        $advert = Advert::factory()->create(['user_id' => $user->id]);
        // Trying to delete
        $response = $this->actingAs($user)->call('DELETE', '/business/{$advert->id}');
        $this->assertEquals(302, $response->getStatusCode());
    }
}
