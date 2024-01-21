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

class BusinessUpdateTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * Test if business user can update advert campaign 
     *
     * @return void
     */
    public function test_business_can_update_advert()
    {
        $user = User::factory()->create(['account_type' => 2]);
        $advertCategoriesSeeder = new \Database\Seeders\AdvertCategorySeeder();
        $advertMediaSeeder = new \Database\Seeders\MediaTypeSeeder();
        $advertCategoriesSeeder->run();
        $advertMediaSeeder->run();
        $advert = Advert::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->put( url('/business', $advert->id), [
            'advert_media_id' => 1,
            'advert_category_id' => 2,
            'advert_name' => 'Updated advert name',
            'industry' => 'Updated industry name',
            'start_date' => Carbon::parse('2022-05-25 00:00'),
            'end_date' => Carbon::parse('2022-07-25 00:00'),
            'description' => 'Updated description',
            'priority_level' => 1,
            'comments' => 'Updated comment',
            'web_url' => 'https://test.com',
            'max_advertisers_count' => 2,
            'current_status' => 1,
            'creator_ip_address' => '88:245:4:0',
        ]);
        
        $advert = Advert::latest()->first();
        $this->assertEquals('Updated advert name', $advert->advert_name);
        $this->assertEquals(2, $advert->max_advertisers_count);
    }
}
