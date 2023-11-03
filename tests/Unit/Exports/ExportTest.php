<?php

namespace Tests\Unit;

use App\Dao\Post\PostDao;
use App\Exports\ExportPost;
use App\Http\Controllers\Post\PostController;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ExportTest extends TestCase
{
  use RefreshDatabase;

  public function test_export_post(): void
  {
    $user = User::factory()->create([
      'created_user_id' => 1,
      'updated_user_id' => 1
    ]);
    $this->actingAs($user);
    $response = $this->get('/posts/download');
    $response->assertStatus(200);
  }

  // public function test_export_post_without_loginUser(): void
  // {
  //   $response = $this->get('/posts/download');
  //   $response->assertStatus(302);
  // }

  public function test_map_method_correctly_transforms_post()
  {
    $post = new Post();
    $post->id = 1;
    $post->title = 'Test Post';
    $post->description = 'This is a test post.';
    $post->status = 1;
    $post->created_user_id = 1;
    $post->updated_user_id = 1;
    $post->created_at = now();
    $post->updated_at = now();
    $export = new ExportPost();
    $result = $export->map($post);
    $expectedResult = [
      1,
      'Test Post',
      'This is a test post.',
      'Active',
      1,
      1,
      Date::dateTimeToExcel($post->created_at),
      Date::dateTimeToExcel($post->updated_at),
    ];
    $this->assertEquals($expectedResult, $result);
  }
}
