<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private string $createPath = '/api/v1/admin/create-user-request';

    public function testAdminTriesToAccessEndpointWithoutAccessToken()
    {
        $response = $this->postJson($this->createPath, [
            "request_type" => "delete-user",
            "request_data" => [
                "first_name" => "Arjen",
                "last_name" => "Samule",
                "email" => "salamikolweol4435@gmail.com"
            ],
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated',
            'success' => false,
            'data' => [
                'error' => 'User is not authenticated'
            ]
        ]);
    }
}
