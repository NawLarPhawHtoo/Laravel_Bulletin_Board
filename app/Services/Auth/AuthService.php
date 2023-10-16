<?php

namespace App\Services\Auth;

use App\Contracts\Dao\Auth\AuthDaoInterface;
use App\Contracts\Services\Auth\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthService implements AuthServiceInterface
{
  private $authDao;

  /**
   * Class constructor
   * @param AuthDaoInterface
   * @return
   */
  public function __construct(AuthDaoInterface $authDao)
  {
    $this->authDao = $authDao;
  }

  /**
   * To save User with values from request
   * @param Request $request
   * @return Object created user object
   */
  public function saveUser(Request $request)
  {
    $user = $this->authDao->saveUser($request);
    return $user; 
  }
}