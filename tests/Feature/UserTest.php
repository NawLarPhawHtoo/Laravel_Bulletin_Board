<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(302);
    }

    // public function testCreateUser()
    // {
    //     $user = User::factory()->make(); // Use Laravel's model factory to create a user
    //     $response = $this->post('/user/create', $user->toArray());

    //     $response->assertStatus(201); // Ensure the user was created successfully
    // }

    // public function testReadUser()
    // {
    //     $user = User::factory()->create(); // Create a user using the model factory
    //     $response = $this->get("/users/{$user->id}");

    //     $response->assertStatus(200); // Ensure you can read the user
    // }

    // public function testUpdateUser()
    // {
    //     $user = User::factory()->create();
    //     $newUserData = ['name' => 'Updated Name'];
    //     $response = $this->put("/users/{$user->id}", $newUserData);

    //     $response->assertStatus(200); // Ensure the user was updated
    //     $this->assertDatabaseHas('users', $newUserData); // Ensure the user's data is updated in the database
    // }

    // public function testDeleteUser()
    // {
    //     $user = User::factory()->create();
    //     $response = $this->delete("/users/{$user->id}");

    //     $response->assertStatus(204); // Ensure the user was deleted
    //     $this->assertDatabaseMissing('users', ['id' => $user->id]); // Ensure the user is not in the database
    // }
}
