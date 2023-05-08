<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\MakerChecker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RejectUserRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $rejectPath = '/api/v1/admin/reject-user-request';
    private $admin;
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
        $this->token = $this->admin->createToken('admin');
        Sanctum::actingAs($this->admin, ['*']);
    }

    public function testAdminTriesToRejectAnInvalidRequest()
    {
        $response = $this->postJson($this->rejectPath, [
            "maker_checker_id" => "786"
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

    public function testAdminTriesToRejectRequestCreatedViaHisAccount()
    {
        $maker = MakerChecker::factory()->create(['maker_id'=>$this->admin->id]);
        $response = $this->postJson($this->rejectPath, [
            "maker_checker_id" => $maker->id
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

    public function testAdminTriesToRejectAValidRequest()
    {
        $admin = Admin::factory()->create(['email'=>'valid@gmail.com']);
        $maker = MakerChecker::factory()->create(['maker_id'=>$admin->id]);
        $response = $this->postJson($this->rejectPath, [
            "maker_checker_id" => $maker->id
        ]);
        $response->assertStatus(200);
        $response->assertJson([
                "message" => "Request was rejected successfully",
                "success" => true,
                "data" => []
            ]
        );
    }
}
