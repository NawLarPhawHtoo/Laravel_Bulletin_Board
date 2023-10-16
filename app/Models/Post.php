<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  // use SoftDeletes;
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'status',
    'created_user_id',
    'updated_user_id',
  ];

  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function user()
  {
    return $this->belongsTo("App\Models\User", 'created_user_id');
  }
}
