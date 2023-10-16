<?php

namespace App\Contracts\Dao\Post;

use App\Models\Post;
use Illuminate\Http\Request;

interface PostDaoInterface
{
  public function store(Request $request);

  public function show();

  public function detail($id);

  public function update(Request $request, $id);

  public function delete($id);
}