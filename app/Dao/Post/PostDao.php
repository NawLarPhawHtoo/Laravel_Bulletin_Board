<?php

namespace App\Dao\Post;

use App\Contracts\Dao\Post\PostDaoInterface;
use App\Models\Post;
use Illuminate\Http\Request;

class PostDao implements PostDaoInterface
{
  public function store(Request $request)
  {
    $post = new Post();
    $post->title = $request['title'];
    $post->description = $request['description'];
    $post->created_user_id = auth()->user()->id;
    $post->updated_user_id = auth()->user()->id;
    $post->save();
    return $post;
  }

  public function show()
  {
    $posts = Post::all();
    return $posts;
  }

  public function detail($id)
  {
    $post = Post::find($id);
    return $post;
  }

  public function update(Request $request, $id)
  {
    $post = Post::find($id);
    $post->title = $request['title'];
    $post->description = $request['description'];
    $post->status = $request['status'] ? 1 : 0;
    $post->created_user_id = auth()->user()->id;
    $post->updated_user_id = auth()->user()->id;
    $post->save();
    return $post;
  }

  public function delete($id)
  {
    $post = Post::find($id);
    // $post->deleted_user_id = auth()->user()->id;
    // $post->save();
    $post->delete();
  }
}
