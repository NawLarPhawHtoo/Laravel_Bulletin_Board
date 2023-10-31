<?php

namespace Tests\Unit;

use App\Dao\Post\PostDao;
use App\Http\Controllers\Post\PostController;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUploadRequest;
use App\Imports\ImportPost;
use App\Models\Post;
use App\Models\User;
use App\Services\Post\PostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Mockery;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_search_posts(): void
    {
        $request = Request::create('/posts', 'GET', ['search' => 'your-search', 'perPage' => 10]);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->index($request);
        $this->assertNotNull($posts);
    }

    public function test_posts(): void
    {
        $request = Request::create('/posts', 'GET', ['search' => '', 'perPage' => 10]);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->index($request);
        $this->assertNotNull($posts);
    }

    public function test_search_own_posts(): void
    {
        $request = Request::create('/posts/my-posts', 'GET', ['search' => 'your-search', 'perPage' => 10]);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->ownpost($request);
        $this->assertNotNull($posts);
    }

    public function test_own_posts(): void
    {
        $request = Request::create('/posts/my-posts', 'GET', ['search' => '', 'perPage' => 10]);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->ownpost($request);
        $this->assertNotNull($posts);
    }

    public function test_view_create_post(): void
    {
        $request = Request::create('/post/create', 'GET');
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->create($request);
        $this->assertNotNull($posts);
    }

    public function test_confirm_create_post(): void
    {
        $postRequest = [
            'title' => 'Post Title',
            'description' => 'Post Description'
        ];
        $request = PostRequest::create('/post/create', 'POST', $postRequest);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->confirmPostCreate($request);
        $this->assertNotNull($posts);
    }

    public function test_show_create_confirm_post_with_old_data(): void
    {
        $this->withSession(['_old_input' => ['title' => 'Old Title', 'description' => 'Old Description']]);
        $response = $this->get('/post/create/confirm');
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->showPostConfirm($response);
        $this->assertNotNull($posts);
    }

    public function test_show_create_confirm_post_without_old_data(): void
    {
        $request = Request::create('post/create/confirm', 'GET');
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->showPostConfirm($request);
        $this->assertNotNull($posts);
    }

    public function test_store_post(): void
    {
        $user = User::factory()->create(
            [
                'created_user_id' => 1,
                'updated_user_id' => 1
            ]
        );
        $userId = $user->id;
        $postRequest = [
            'title' => 'Example Title',
            'description' => 'Example Description',
            'created_user_id' => $userId,
            'updated_user_id' => $userId
        ];
        $request = PostRequest::create('/post/create/confirm', 'POST', $postRequest);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->store($request);
        $this->assertNotNull($posts);
    }

    public function test_edit_post(): void
    {
        $post = Post::factory()->create();

        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $posts = $postController->edit($post->id);
        $this->assertNotNull($posts);
    }

    public function test_confirm_edit_post(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        $post = Post::factory()->create();
        if ($post) {
            $requestData = [
                'title' => 'Update Title',
                'description' => 'Update Description',
                'created_user_id' => $user->id,
                'updated_user_id' => $user->id
            ];

            $request = new PostEditRequest($requestData);

            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $postController = new PostController($postService);
            $posts = $postController->confirmPostEdit($request, $post->id);
            $this->assertNotNull($posts);
        }
    }

    public function test_show_edit_post_with_old_data(): void
    {
        $post = Post::factory()->create();
        if ($post) {
            $this->withSession(['_old_input' => ['title' => 'Old Title', 'description' => 'Old Description']]);
            $response = $this->get('/post/edit-confirm/{post->id}');
            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $postController = new PostController($postService);
            $posts = $postController->showEditConfirm($response);
            $this->assertNotNull($posts);
        }
    }

    public function test_show_edit_post_without_old_data(): void
    {
        $post = Post::factory()->create();
        if ($post) {
            $response = $this->get('/post/edit-confirm/{post->id}');
            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $postController = new PostController($postService);
            $posts = $postController->showEditConfirm($response);
            $this->assertNotNull($posts);
        }
    }

    public function test_update_post(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        $post = Post::factory()->create();
        if ($post) {
            $requestData = [
                'title' => 'Update Title',
                'description' => 'Update Description',
                'created_user_id' => $user->id,
                'updated_user_id' => $user->id
            ];

            $request = new PostEditRequest($requestData);
            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $postController = new PostController($postService);
            $posts = $postController->update($request, $post->id);
            $this->assertNotNull($posts);
        }
    }

    public function test_delete_post(): void
    {
        $post = Post::factory()->create();
        if ($post) {
            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $postController = new PostController($postService);
            $posts = $postController->destroy($post->id);
            $this->assertNotNull($posts);
        }
    }

    public function test_upload_post(): void
    {
        $post = Post::factory()->create();
        if ($post) {
            $postDao = new PostDao();
            $postService = new PostService($postDao);
            $postController = new PostController($postService);
            $posts = $postController->upload();
            $this->assertNotNull($posts);
        }
    }

    // public function test_import_post(): void
    // {
    //     // $file = UploadedFile::fake()->create('posts.xlsx', 500);
    //     $testFile = new UploadedFile(
    //                 path: storage_path('app/posts.xlsx'),
    //                 originalName:'posts.xlsx',
    //             );
    //     $request = Mockery::mock(PostUploadRequest::class);
    //     $request->shouldReceive('file')->once()->with('file')->andReturn($testFile);

    //     $postDao = new PostDao();
    //     $postService = new PostService($postDao);
    //     $postController = new PostController($postService);
    //     $response = $postController->importExcel($request);
    //     $this->assertNotNull($response);
    // }
    public function test_import_post()
    {
        // Storage::fake('imports');
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        $this->actingAs($user);
        $testFile = new UploadedFile(
            storage_path('app/posts.xlsx'),
            'posts.xlsx',
            null,
            true
        );

        // Excel::fake();

       
        $response = $this->post('/post/upload', ['file' => $testFile]);
        $postDao = new PostDao();
        $postService = new PostService($postDao);
        $postController = new PostController($postService);
        $response = $postController->importExcel(new PostUploadRequest(), $response);
        $this->assertNotNull($response);
        // $response->assertStatus(302);

        // Excel::assertImported('posts.xlsx', 'imports');

        // Excel::assertImported('posts.xlsx', 'imports', function (ImportPost $import) {
        //     return true;
        // });

        // // When passing the callback as 2nd param, the disk will be the default disk.
        // Excel::assertImported('posts.xlsx', function (ImportPost $import) {
        //     return true;
        // });
    }
}
