<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreatedUserModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_created_user_model(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        $createdUser = $user->createdUser;

        // Assertions
        $this->assertInstanceOf(User::class, $createdUser);
        $this->assertEquals($user->id, $createdUser->id);
    }
}
