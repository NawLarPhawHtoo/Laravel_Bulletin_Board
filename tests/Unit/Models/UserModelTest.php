<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_model(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $post1 = Post::factory()->create(['created_user_id' => $user->id,'updated_user_id' => $user->id]);
        $post2 = Post::factory()->create(['created_user_id' => $user->id, 'updated_user_id' => $user->id]);
        $user = User::find(1);
        $userPosts = $user->posts->toArray();
        // Assert that the user has the correct number of posts
        $this->assertCount(2, $userPosts);
        // Optionally, you can assert specific attributes of the posts
        $this->assertTrue($userPosts[0]['created_user_id'] == $post1->created_user_id);
        $this->assertTrue($userPosts[1]['created_user_id'] == $post2->created_user_id);
    }
}