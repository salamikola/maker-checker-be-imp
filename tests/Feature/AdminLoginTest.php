<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    private string $loginPath = '/api/v1/admin/login';

    /**
     * Test case for invalid email/password.
     *
     * @return void
     */
    public function testInvalidEmailPassword()
    {
        $response = $this->postJson($this->loginPath, [
            'email' => 'wrong-email@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Invalid email/password',
            'success' => false,
            'data' => [
                'error' => 'Invalid email/password'
            ]
        ]);
    }

    /**
     * Test case for correct email but wrong password.
     *
     * @return void
     */
    public function testCorrectEmailWrongPassword()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@admin1.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson($this->loginPath, [
            'email' => 'admin@admin1.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'Invalid email/password',
            'success' => false,
            'data' => [
                'error' => 'Invalid email/password'
            ]
        ]);
    }

    /**
     * Test case for correct email and password.
     *
     * @return void
     */
    public function testCorrectEmailPassword()
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@admin1.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->postJson($this->loginPath, [
            'email' => 'admin@admin1.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Login Successfully',
            'success' => true,
            'data' => [
                "userData" => [
                    "hasVerifiedEmail" => true,
                    "firstName" => $admin->first_name,
                    "lastName" => $admin->last_name
                ]
            ]
        ]);
        $response->assertJsonStructure([
            'data' => [
                "userData" => [
                    "accessToken"
                ]
            ]
        ]);
    }
}
