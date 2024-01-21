<?php

namespace Tests\Feature\AdvertiserTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AdvertiserViewsTest extends TestCase
{
    /**
     * Test if advertiser user can access his index (/advertiser) page
     *
     * @return void
     */
    public function test_advertiser_can_view_index()
    {
        $user = User::factory()->create(['account_type' => 1]);

        $this->actingAs($user);

        $response = $this->get('/advertiser');

        $response->assertStatus(200);
    }
}
