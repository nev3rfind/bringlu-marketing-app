<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'first_name' => 'Donatas',
            'last_name' => 'Stankevicius',
            'email' => 'test@gmail.com',
            'phone' => '0774562413',
            'password' => 'password',
            'password_confirmation' => 'password',
            'account_type' => '1'
        ]);

        $this->assertAuthenticated();
    }
}
