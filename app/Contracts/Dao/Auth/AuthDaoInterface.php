<?php

namespace App\Contracts\Dao\Auth;

use Illuminate\Http\Request;

interface AuthDaoInterface
{
  /**
   * To save User with values from request
   * @param Request $request request including inputs
   * @return Object created user object
   */
  public function saveUser(Request $request);
}