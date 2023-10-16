<?php

namespace App\Http\Controllers\Post;

use App\Contracts\Services\Post\PostServiceInterface;
use App\Exports\ExportPost;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostEditRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUploadRequest;
use App\Imports\ImportPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PostController extends Controller
{
  private $postInterface;

  public function __construct(PostServiceInterface $postServiceInterface)
  {
    $this->postInterface = $postServiceInterface;
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index(Request $request)
  {
    $user_type = auth()->user()->type;
    $search = $request->search;

    $perPage = $request->input('perPage', 6);

    if ($search !== "") {
      $posts = Post::where(function ($query) use ($search) {
        $query->where('title', 'LIKE', '%' . $search . '%')
          ->orWhere('description', 'LIKE', '%' . $search . '%');
      });

      // Add a condition based on the user's role to set the status.
      if ($user_type == 1) {
        $posts->where('status', 1);
      }

      $posts = $posts->orderBy('id', 'DESC')->paginate($perPage);
      $posts->appends(['search' => $search]);
    } else {
      $posts = $this->postInterface->show();
      if ($user_type == 1) {
        $posts->where('status', 1);
      }
    }
    session(['exportAll' => true]);
    return view('posts.index', compact('posts'));
  }

  public function ownpost(Request $request)
  {
    $userId = auth()->user()->id;
    $search = $request->search;
    $perPage = $request->input('perPage', 6);

    if ($search !== "") {
      $posts = Post::where(function ($query) use ($search) {
        $query->where('title', 'LIKE', '%' . $search . '%')
          ->orWhere('description', 'LIKE', '%' . $search . '%');
      })
        ->where('created_user_id', $userId) // Add this line to filter by user_id
        ->orderBy('id', 'DESC')
        ->paginate(6);

      $posts->appends(['search' => $search]);
    } else {
      $posts = Post::where('created_user_id', $userId) // Add this line to filter by user_id
        ->orderBy('id', 'DESC')
        ->paginate($perPage);
    }
    session(['exportAll' => false]);
    return view('posts.index', compact('posts'));
  }

  /**
   * Show form for creating a new post
   */
  public function create()
  {
    return view('posts.create');
  }

  public function confirmPostCreate(PostRequest $request)
  {
    $validated = $request->validated();
    return redirect()->route('posts.view-create-confirm')->withInput();
  }

  /**
   * To show post create confirm view
   *
   * @return View post create confirm view
   */
  public function showPostConfirm()
  {
    if (old()) {
      return view('posts.create-confirm');
    }
    return redirect()->route('posts.search');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(PostRequest $request)
  {
    $this->postInterface->store($request);
    return redirect()->route('posts.search')->withStatus('Post has been created successfully.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request)
  {
    $post = $this->postInterface->show($request);
    return view('posts.detail', compact('post'));
  }

  public function edit($id)
  {
    $post = $this->postInterface->detail($id);
    return view('posts.edit', compact('post'));
  }

  public function confirmPostEdit(PostEditRequest $request, $id)
  {
    $validated = $request->validated();
    return redirect()->route('posts.view-edit-confirm', [$id])->withInput();
  }

  public function showEditConfirm($id)
  {
    if (old()) {
      return view('posts.edit-confirm',  compact('id'));
    }
    return redirect()->route('posts.search');
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(PostEditRequest $request, $id)
  {
    $this->postInterface->update($request, $id);
    return redirect()->route('posts.search')->withStatus('Post has been updated successfully.');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $this->postInterface->delete($id);
    return redirect()->route('posts.search')->withSatus('Post has been deleted successfully.');
  }

  public function upload()
  {
    return view('posts.upload');
  }

  public function importExcel(PostUploadRequest $request)
  {
    $file = $request->file('file');
    $import = new ImportPost;
    $import->import($file);
    if ($import->failures()->isNotEmpty()) {
      return back()->withFailures($import->failures());
    }
    return back()->withStatus('Post Imported Successfully.');
  }

  public function export(Request $request)
  {
    $exportAll = session('exportAll', true);
    $userId = auth()->user()->id;
    $filter = $request->input('search');
    
    $export = new ExportPost($exportAll, $userId, $filter);
    return Excel::download($export, 'posts.xlsx');
  }
}
