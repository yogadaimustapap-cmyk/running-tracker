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
        $response->assertSee('Masuk - RunningTracker');
        $response->assertSee('Selamat datang kembali');
    }

    /**
     * Test that the register page renders successfully.
     */
    public function test_register_page_renders_successfully(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Daftar - RunningTracker');
        $response->assertSee('Daftar akun');
    }
}
