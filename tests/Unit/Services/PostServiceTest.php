<?php

namespace Tests\Unit;

use App\Dao\Post\PostDao;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class PostServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_post(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        $requestData = [
            'title' => 'Create a new post',
            'description' => 'Create a new post description'
        ];
        $request = new Request($requestData);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $post = $postService->store($request, $user->id);
        $this->assertNotNull($post);

    }

    public function test_show_post(): void
    {
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $post = $postService->show();
        $this->assertNotNull($post);
    }

    public function test_detail_post(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $post = Post::factory()->create([
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id
        ]);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postData = $postService->detail($post->id);
        $this->assertNotNull($postData);
    }

    public function test_update_post(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $this->actingAs($user);

        $post = Post::factory()->create();

        if ($post) {
            $requestData = [
                'title' => 'Update post',
                'description' => 'Update post description',
                'created_user_id' => $user->id,
                'updated_user_id' => $user->id
            ];

            $request = new Request($requestData);
            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $updatedPost = $postService->update($request, $post->id);
            $this->assertNotNull($updatedPost);
        }
    }

    public function test_delete_post(): void
    {
        $post = Post::factory()->create();
        if($post) {
            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $postService->delete($post->id);
            $deletedPost = Post::find($post->id);
            $this->assertNull($deletedPost);
        }
    }
}
