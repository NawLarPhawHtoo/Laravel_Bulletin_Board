<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class UserService implements UserServiceInterface
{
  private $userDao;

  /**
   * Class constructor
   * @param UserDaoInterface
   * @return
   */
  public function __construct(UserDaoInterface $userDao)
  {
    $this->userDao = $userDao;
  }

  /**
   * To save user that from api request
   * @param array $validated Validated value from request
   * @return Object created user object
   */
  public function saveUser($validated)
  {
    $user = $this->userDao->saveUser($validated);
    return $user;
  }

  /**
   * To get user by id
   * @param string $id user id
   * @return Object $user user object
   */
  public function getUserById($id)
  {
    return $this->userDao->getUserById($id);
  }

  public function  getUserList()
  {
    return $this->userDao->getUserList();
  }

  public function updateUser(Request $request)
  {
    $user = $this->userDao->updateUser($request);
    // if ($request['profile']) {
    //   Storage::move(
    //     config('path.public_tmp') . $request['profile'],
    //     config('path.profile') . Auth::user()->id . config('path.separator') . $request['profile']
    //   );
    // }
    return $user;
  }

  public function update(Request $request, $id)
  {
    $user = $this->userDao->update($request, $id);
    return $user;
  }

  public function changePassword($validated)
  {
    return $this->userDao->changePassword($validated);
  }


  public function delete($id)
  {
    $user = $this->userDao->delete($id);
    return $user;
  }
}
