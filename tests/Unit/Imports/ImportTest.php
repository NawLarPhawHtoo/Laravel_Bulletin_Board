<?php

namespace Tests\Unit;

use App\Imports\ImportPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_model(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $this->actingAs($user);
        $post = [
            'title' => 'Test Post',
            'description' => 'This is a test post.',
            'status' => 1,
            'created_user_id' => 1,
            'updated_user_id' => 1,
        ];
        $export = new ImportPost();
        $result = $export->model($post);
        $this->assertNotNull($result);
    }

    public function test_rule(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $this->actingAs($user);
        $rule = [
            'title' => 'Post Title',
            'created_user_id' => $user->id,
        ];

        $request = new ImportPost($user->id);
        $response = $request->rules($rule);
        $this->assertNotNull($response);
    }
}
