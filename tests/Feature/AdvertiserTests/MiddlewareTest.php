<?php

namespace Tests\Feature\AdvertiserTests;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\AuthoriseAdvertiser;
use App\Http\Middleware\CorsMiddleware;

class MiddlewareTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test if advertisers can be redirected to their route '/advertisers'
     *
     * @return void
     */
    public function test_advertisers_are_not_redirected()
    {
        $user = User::factory()->create(['account_type' => 1]);

        $this->actingAs($user);

        $request = Request::create('/advertiser', 'GET');

        $middleware = new AuthoriseAdvertiser;

        $response = $middleware->handle($request, function () {} );
        // Getting a 301 redirect and null response
        $this->assertEquals($response, null);
    }

    /**
     * Test if business accounts cannot access advertiser route
     *
     * @return void
     */
    public function test_business_are_redirected()
    {
        $user = User::factory()->create(['account_type' => 2]);

        $this->actingAs($user);

        $request = Request::create('/advertiser', 'GET');

        $middleware = new AuthoriseAdvertiser;

        $response = $middleware->handle($request, function () {} );

        $this->assertEquals($response->getStatusCode(), 302);
    }
}
