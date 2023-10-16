<?php

namespace App\Services\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Contracts\Services\Post\PostServiceInterface;
use App\Models\Post;
use Illuminate\Http\Request;

class PostService implements PostServiceInterface
{
  private $postDao;

  public function __construct(PostDaoInterface $postDao)
  {
    $this->postDao = $postDao;
  }

  public function store(Request $request)
  {
    $this->postDao->store($request);
  }

  public function show()
  {
    $post = $this->postDao->show();
    return $post;
  }

  public function detail($id)
  {
    $post = $this->postDao->detail($id);
    return $post;
  }

  public function update(Request $request, $id)
  {
    $post = $this->postDao->update($request, $id);
    return $post;
  }

  public function delete($id)
  {
    $post = $this->postDao->delete($id);
    return $post;
  }
}