<?php

namespace App\Contracts\Dao\User;

use Illuminate\Http\Request;

interface UserDaoInterface
{
  /**
   * To save user that from api request
   * @param array $validated  Validated values from request
   * @return Object created user object
   */
  public function saveUser($validated);

  /**
   * To get user by id
   * @param string $id user id
   * @return Object $user user object
   */
  public function getUserById($id);
  /**
   * To get User List
   * @return array $userlist  list of users
   */
  public function getUserList();

  /**
   * To Update User with values from request
   * @param Request $request request including inputs
   * @return Object updated user object
   */
  public function updateUser(Request $request);

  public function update(Request $request, $id);
  /**
   * To change user password
   * @param array $validated Validated values from request
   * @return Object $user user object
   */
  public function changePassword($validated);

  public function delete($id);

}