<?php

namespace Tests\Unit\Services\User;

use App\Http\Controllers\UserController;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userService = new UserService();
    }

    public function test_get_users_for_data_table()
    {
        $response = $this->userService->getUsersForDataTable();

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
    }


    public function test_add_new_user()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('secret')
        ];

        $response = $this->actingAs($user)
            ->postJson('/users', $payload);

        $response->assertStatus(302); //302 because redirect 
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['email' => $payload['email']]);
    }

    public function test_trash_user_route()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/trash/user');

        $response->assertStatus(200); 
    }

    public function test_restore_user_route()
    {
        $user = User::factory()->create();
        $trashedUser = User::factory()->trashed()->create();

        $response = $this->actingAs($user)
            ->post("/user/{$trashedUser->id}/restore");

        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['id' => $trashedUser->id]);
    }

    public function test_permanent_delete_route()
    {
        $user = User::factory()->create();
        $trashedUser = User::factory()->trashed()->create();

        $response = $this->actingAs($user)
            ->delete("/user/{$trashedUser->id}/permanent-delete");

        $response->assertStatus(302); //302 because redirect 
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseMissing('users', ['id' => $trashedUser->id]);
    }
}
