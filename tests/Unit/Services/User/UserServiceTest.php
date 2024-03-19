<?php

namespace Tests\Unit\Services\User;
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

    public function testGetUser()
    {
        $response = $this->userService->getUsersForDataTable();

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
    }


    public function testAddUser()
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

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $updatedUserData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];

        $response = $this->actingAs($user)
            ->putJson("/users/{$user->id}", $updatedUserData);

        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updatedUserData['name'],
            'email' => $updatedUserData['email'],
        ]);
    }

    public function testTrashUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get('/trash/user');

        $response->assertStatus(200); 
    }

    public function testRestoreUser()
    {
        $user = User::factory()->create();
        $trashedUser = User::factory()->trashed()->create();

        $response = $this->actingAs($user)
            ->post("/user/{$trashedUser->id}/restore");

        $response->assertStatus(302);
        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', ['id' => $trashedUser->id]);
    }

    public function testPermanentDeleteUser()
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
