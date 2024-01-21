<?php

namespace Tests\Feature\SocialTests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GitHubTest extends TestCase
{
    /**
     * Test to check if guest can be redirected to GitHub OAuth page
     *
     * @return void
     */
    public function test_it_redirects_to_github()
    {
        $response = $this->call('GET', 'auth/github');
        // Works only on 9+ versions of PHPUnit
        $this->assertStringContainsStringIgnoringCase('github.com/login/oauth', $response->getTargetUrl());
    }
}
