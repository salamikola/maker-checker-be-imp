<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateUserRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $loginPath = '/api/v1/admin/create-user-request';
    private $admin;
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
        $this->token = $this->admin->createToken('admin');
        Sanctum::actingAs($this->admin, ['*']); // allow all abilities
    }


    public function testAdminTriesToCreateUserWithNoPayload()
    {
        $response = $this->postJson($this->loginPath, []);
        $response->assertStatus(442);
        $response->assertJson([
                "message" => "Validation Error",
                "success" => false,
                "data" => [
                    "error_bag" => [
                        "request_type" => [
                            "The request type field is required."
                        ]
                    ],
                    "error" => [
                        "The request type field is required."
                    ]
                ]
            ]
        );
    }


    public function testAdminTriesToCreateUserWithTheRightPayload()
    {
        $response = $this->postJson($this->loginPath, [
            "request_type" => "create-user",
            "request_data" => [
                "first_name" => "Arjen",
                "last_name" => "Samule",
                "email" => "salamikolweol4435@gmail.com"
            ],
        ]);
        $response->assertStatus(201);
        $response->assertJson([
                "message" => "User request was submitted successfully",
                "success" => true,
                "data" => [
                    'created' => true
                ]
            ]
        );
    }
}
