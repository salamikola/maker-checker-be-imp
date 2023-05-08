<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateUserRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $createPath = '/api/v1/admin/create-user-request';
    private $admin;
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
        $this->token = $this->admin->createToken('admin');
        Sanctum::actingAs($this->admin, ['*']);
    }


    public function testAdminTriesToUpdateUserThatDoesNotExist()
    {
        $response = $this->postJson($this->createPath, [
            "request_type" => "update-user",
            "request_data" => [
                "first_name" => "Arjen",
                "last_name" => "Samule",
                "email" => "salamikolweol4435@gmail.com"
            ],
            "user_id"=>'100'
        ]);
        $response->assertStatus(400);
        $response->assertJson([
                "message" => "Invalid operation",
                "success" => false,
                "data" => [
                    'error' => 'Invalid operation'
                ]
            ]
        );
    }


    public function testAdminTriesToUpdateUserWithRightPayload()
    {
        $user = User::factory()->create();
        $response = $this->postJson($this->createPath, [
            "request_type" => "update-user",
            "request_data" => [
                "first_name" => "Arjen",
                "last_name" => "Samule",
                "email" => "salamikolweol4435@gmail.com"
            ],
            "user_id"=>$user->id
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
