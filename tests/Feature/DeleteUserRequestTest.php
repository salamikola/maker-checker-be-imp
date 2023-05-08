<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteUserRequestTest extends TestCase
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


    public function testAdminTriesToDeleteUserThatDoesNotExist()
    {
        $response = $this->postJson($this->createPath, [
            "request_type" => "delete-user",
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


    public function testAdminTriesToDeleteUserWithRightPayload()
    {
        $user = User::factory()->create();
        $response = $this->postJson($this->createPath, [
            "request_type" => "delete-user",
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
