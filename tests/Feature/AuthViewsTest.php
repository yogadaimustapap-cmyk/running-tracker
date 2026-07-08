<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthViewsTest extends TestCase
{
    /**
     * Test that the login page renders successfully.
     */
    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('Login - RunningTracker');
        $response->assertSee('Welcome back');
    }

    /**
     * Test that the register page renders successfully.
     */
    public function test_register_page_renders_successfully(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Register - RunningTracker');
        $response->assertSee('Create account');
    }
}
