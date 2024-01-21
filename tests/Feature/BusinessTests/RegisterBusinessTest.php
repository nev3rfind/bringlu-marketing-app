<?php

namespace Tests\Feature;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterBusinessTest extends TestCase
{
    // Refresh databse everytime after each test
    use RefreshDatabase;

    /**
     * Users can register as a business
     *
     * @return void
     */
    public function test_new_users_can_register_as_businesses()
    {
        $response = $this->post('/register', [
            'first_name' => 'Donatas',
            'last_name' => 'Business',
            'email' => 'business@gmail.com',
            'phone' => '07745648976',
            'password' => 'password',
            'password_confirmation' => 'password',
            'account_type' => 2
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::BUSINESS);
    }
}
