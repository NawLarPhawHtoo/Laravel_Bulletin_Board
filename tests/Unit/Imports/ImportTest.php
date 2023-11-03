<?php

namespace Tests\Unit;

use App\Dao\Post\PostDao;
use App\Http\Controllers\Post\PostController;
use App\Http\Requests\PostUploadRequest;
use App\Imports\ImportPost;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ImportTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_import_post_model(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $this->actingAs($user);
        $post = [
            'title' => 'Post Title',
            'description' => 'Post Description',
            'status' => 1,
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id
        ];

        $result = new ImportPost();
        $response = $result->model($post);
        $this->assertNotNull($response);
    }

    public function test_import_post()
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $this->actingAs($user);
        // Use the Storage facade to get the file path
        $filePath = storage_path('app/posts.xlsx');

        if (file_exists($filePath)) {
            $file = new UploadedFile(
                $filePath,
                'posts.xlsx',
                'xlsx',
                null,
                true
            );

            Excel::fake();

            $result = $this->post('/post/upload', ['file' => $file]);
            $this->assertNotNull($result);
            // Excel::assertImported('posts.xlsx');
            // Excel::assertImported('posts.xlsx', function (ImportPost $import) {
            //     return true;
            // });
        } else {
            $this->fail('The "posts.xlsx" file does not exist in the specified path.');
        }
    }

    public function test_import_post_with_failures()
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $this->actingAs($user);

        $post = Post::factory()->create([
            'title' => 'Title One',
            'description' => 'Description One',
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id
        ]);
        // Use the Storage facade to get the file path
        $filePath = storage_path('app/fail_posts.xlsx');

        if (file_exists($filePath)) {
            $file = new UploadedFile(
                $filePath,
                'fail_posts.xlsx',
                'xlsx',
                null,
                true
            );

            Excel::fake();

            $result = $this->post('/post/upload', ['file' => $file]);
            $this->assertNotNull($result);
            // Excel::assertImported('posts.xlsx');
            Excel::assertImported('fail_posts.xlsx', function (ImportPost $import) {
                return true;
            });
        } else {
            $this->fail('The "fail_posts.xlsx" file does not exist in the specified path.');
        }
    }
}

// public function test_import_post()
    // {
    //     $user = User::factory()->create([
    //         'created_user_id' => 1,
    //         'updated_user_id' => 1
    //     ]);

    //     // $post = Post::factory()->create([
    //     //     'title' => 'Title One',
    //     //     'description' => 'Description One',
    //     //     'created_user_id' => 1,
    //     //     'updated_user_id' => 1
    //     // ]);

    //     $this->actingAs($user);
    //     $testFile = new UploadedFile(
    //         storage_path('app/posts.xlsx'),
    //         'posts.xlsx',
    //         null,
    //         true
    //     );

    //     // Excel::fake();


    //     $response = $this->post('/post/upload', ['file' => $testFile]);
    //     // dd(session('errors'));
    //     // $sesionErrors = session('errors');
    //     // $this->assertNotNull($sesionErrors);
    //     // $this->assertTrue($sesionErrors->has('file'));
    //     $postDao = new PostDao();
    //     $postService = new PostService($postDao);
    //     $postController = new PostController($postService);
    //     $response = $postController->importExcel(new PostUploadRequest(), $response);
    //     // $response->assertStatus(422);
    //     $this->assertNotNull($response);
    //     // $response->assertStatus(302);

    //     // Excel::assertImported('posts.xlsx', 'imports');

    //     // Excel::assertImported('posts.xlsx', 'imports', function (ImportPost $import) {
    //     //     return true;
    //     // });

    //     // // When passing the callback as 2nd param, the disk will be the default disk.
    //     // Excel::assertImported('posts.xlsx', function (ImportPost $import) {
    //     //     return true;
    //     // });
    // }

    
