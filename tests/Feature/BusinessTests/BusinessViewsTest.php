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

class BusinessViewsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if business user can access his index (/business) page
     *
     * @return void
     */
    public function test_business_can_view_index()
    {
        $user = User::factory()->create(['account_type' => 2]);

        $this->actingAs($user);

        $response = $this->get('/business');

        $response->assertStatus(200);
    }

    /**
     * Test if business user can create advert campaign and it is creating the exactly one
     *
     * @return void
     */
    public function test_business_can_create_advert()
    {
        $user = User::factory()->create(['account_type' => 2]);
        // Create advert categories and advert media types seeders -> run them
        // Otherwise advert factory will fail, because there is no data in the tables
        // for foreign keys
        $advertCategoriesSeeder = new \Database\Seeders\AdvertCategorySeeder();
        $advertMediaSeeder = new \Database\Seeders\MediaTypeSeeder();
        $advertCategoriesSeeder->run();
        $advertMediaSeeder->run();

        $response = $this->actingAs($user)->post('/business',[
            'advert_media_id' => 1,
            'advert_category_id' => 2,
            'advert_name' => 'Testing advert name',
            'industry' => 'Testing industry name',
            'start_date' => Carbon::parse('2022-05-25 00:00'),
            'end_date' => Carbon::parse('2022-07-25 00:00'),
            'description' => 'Testing description',
            'priority_level' => 1,
            'comments' => 'Testing comment',
            'web_url' => 'https://test.com',
            'max_advertisers_count' => 4,
            'current_status' => 1,
            'creator_ip_address' => '88:245:4:0',
        ]);
        
        $advert = Advert::latest()->first();
        $this->assertEquals('Testing advert name', $advert->advert_name);
        $this->assertEquals(4, $advert->max_advertisers_count);
    }
}
