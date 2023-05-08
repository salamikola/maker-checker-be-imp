<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\MakerChecker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AcceptUserRequestTest extends TestCase
{
    use RefreshDatabase;

    private string $acceptPath = '/api/v1/admin/accept-user-request';
    private $admin;
    private $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = Admin::factory()->create();
        $this->token = $this->admin->createToken('admin');
        Sanctum::actingAs($this->admin, ['*']);
    }

    public function testAdminTriesToAcceptAnInvalidRequest()
    {
        $response = $this->postJson($this->acceptPath, [
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

    public function testAdminTriesToAcceptRequestCreatedViaHisAccount()
    {
        $maker = MakerChecker::factory()->create(['maker_id' => $this->admin->id]);
        $response = $this->postJson($this->acceptPath, [
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

    public function testAdminTriesToAcceptAValidCreateRequestUser()
    {
        $admin = Admin::factory()->create(['email' => 'valid@gmail.com']);
        $maker = MakerChecker::factory()->create(['maker_id' => $admin->id]);
        $response = $this->postJson($this->acceptPath, [
            "maker_checker_id" => $maker->id
        ]);
        $response->assertStatus(200);
        $response->assertJson([
                "message" => "Request was accepted successfully",
                "success" => true,
                "data" => []
            ]
        );
    }

    public function testAdminTriesToAcceptAValidUpdateUserRequest()
    {
        $admin = Admin::factory()->create(['email' => 'valid@gmail.com']);
        $user = User::factory()->create(['email'=>'new@gmail.com']);
        $maker = MakerChecker::factory()->create(
            [
                'maker_id' => $admin->id,
                'request_type'=>'update-user',
                'checkable_id'=>$user->id
            ]
        );
        $response = $this->postJson($this->acceptPath, [
            "maker_checker_id" => $maker->id
        ]);
        $response->assertStatus(200);
        $response->assertJson([
                "message" => "Request was accepted successfully",
                "success" => true,
                "data" => []
            ]
        );
    }

    public function testAdminTriesToAcceptAValidDeleteUserRequest()
    {
        $admin = Admin::factory()->create(['email' => 'valid@gmail.com']);
        $user = User::factory()->create(['email'=>'new@gmail.com']);
        $maker = MakerChecker::factory()->create(
            [
                'maker_id' => $admin->id,
                'request_type'=>'delete-user',
                'checkable_id'=>$user->id
            ]
        );
        $response = $this->postJson($this->acceptPath, [
            "maker_checker_id" => $maker->id
        ]);
        $response->assertStatus(200);
        $response->assertJson([
                "message" => "Request was accepted successfully",
                "success" => true,
                "data" => []
            ]
        );
    }
}
