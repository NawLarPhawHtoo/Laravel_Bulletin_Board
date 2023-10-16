<?php

namespace App\Contracts\Services\Auth;

use Illuminate\Http\Request;

interface AuthServiceInterface
{
  /**
   * To save User with values from request
   * @param Request $request
   * @return Object created user object
   */
  public function saveUser(Request $request);
}