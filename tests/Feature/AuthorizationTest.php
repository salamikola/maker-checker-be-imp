<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    private string $createPath = '/api/v1/admin/create-user-request';
    private $user;
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('user');
        Sanctum::actingAs($this->user, ['*']); // allow all abilities
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAdminTriesToAccessAdminEndpointWithUserToken()
    {
        $response = $this->postJson($this->createPath, [
            "request_type" => "delete-user",
            "request_data" => [
                "first_name" => "Arjen",
                "last_name" => "Samule",
                "email" => "salamikolweol4435@gmail.com"
            ],
        ]);

        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'Unauthorized',
            'success' => false,
            'data' => [
                'error' => 'Unauthorized user'
            ]
        ]);
    }
}
