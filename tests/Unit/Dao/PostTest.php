<?php

namespace Tests\Unit;

use App\Dao\Post\PostDao;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_post(): void
    {
        $user = User::factory()->create(
            [
                'created_user_id' => 1,
                'updated_user_id' => 1
            ]
        );
        $userId = $user->id;
        $requestData = [
            'title' => 'Example Title',
            'description' => 'Example Description',
            'created_user_id' => $userId,
            'updated_user_id' => $userId
        ];

        $request = new Request($requestData);
        $postDao = new PostDao();
        $post = $postDao->store($request, $userId);
        $this->assertNotNull($post);
    }

    public function test_show_post(): void
    {
        $postDao = new PostDao();
        $posts = $postDao->show();
        $this->assertNotNull($posts);
    }

    public function test_detail_post(): void
    {
        $post = Post::factory()->create();
        $postDao = new PostDao();
        $postDetail = $postDao->detail($post->id);
        $this->assertNotNull($postDetail);
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
                'title' => 'Update Title',
                'description' => 'Update Description',
                'created_user_id' => $user->id,
                'updated_user_id' => $user->id
            ];

            $request = new Request($requestData);

            $postDao = new PostDao();
            $updatedPost = $postDao->update($request, $post->id);

            if ($updatedPost) {
                $updatedPost->refresh();
                $this->assertNotNull($updatedPost);
            } else {
                $this->fail('Post update failed');
            }
        } else {
            $this->fail('Post not found');
        }
    }

    public function test_delete_post():void
    {
        $post = Post::factory()->create();
        if($post) {
            $postDao = new PostDao();
            $postDao->delete($post->id);
            $deletedPost = Post::find($post->id);
            $this->assertNull($deletedPost);
        }
    }
}
