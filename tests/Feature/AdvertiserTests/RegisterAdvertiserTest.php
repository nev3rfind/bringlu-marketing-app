<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterAdvertiserTest extends TestCase
{
     /**
     * Users can register as a advertiser
     *
     * @return void
     */
    public function test_new_users_can_register_as_advertisers()
    {
        $response = $this->post('/register', [
            'first_name' => 'Donatas',
            'last_name' => 'Advertiser',
            'email' => 'advertiser@gmail.com',
            'phone' => '07745648976',
            'password' => 'password',
            'password_confirmation' => 'password',
            'account_type' => 1
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::ADVERTISER);
    }
}
