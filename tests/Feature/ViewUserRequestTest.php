<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\MakerChecker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ViewUserRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $viewPath = '/api/v1/admin/view-user-requests';
    private $admin;
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
        $this->token = $this->admin->createToken('admin');
        Sanctum::actingAs($this->admin, ['*']);
    }

    public function testAdminFetchEmptyUserRequest()
    {
        $response = $this->getJson($this->viewPath);
        $response->assertStatus(200);
        $response->assertJson([
                "message" => "User requests fetched successfully",
                "success" => true,
                "data" => [
                    'userRequests' => []
                ]
            ]
        );
    }

    public function testAdminFetchUserRequestWithRecords()
    {
       $maker =  MakerChecker::factory()->create([
            'maker_id' => $this->admin->id
        ]);
       $requestData = $maker->request_data;
        $response = $this->getJson($this->viewPath);
        $response->assertStatus(200)
            ->assertJson([
                "success" => true,
                "data" => [
                    "userRequests" => [
                        [
                            "id" => $maker->id,
                            "request_data" => [
                                "email" => $requestData['email'],
                                "last_name" => $requestData['last_name'],
                                "first_name" => $requestData['first_name'],
                            ],
                            "request_type" => "create-user",
                            "status" => "pending"
                        ]
                    ]
                ],
                "message" => "User requests fetched successfully"
            ]);
    }
}
