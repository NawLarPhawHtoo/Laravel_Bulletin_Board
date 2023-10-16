<?php

namespace App\Dao\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserDao implements UserDaoInterface
{
  /**
   * To save user that from api request
   * @param array $validated Validated values from request
   * @return Object created user object
   */
  public function saveUser($validated)
  { 
    $type = $validated['type'] === 'User' ? 1 : 0;
    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->password = Hash::make($validated['password']);
    $user->profile = $validated['profile'];
    $user->type = $type;
    $user->phone = $validated['phone'];
    $user->dob = $validated['dob'];
    $user->address = $validated['address'];
    $user->created_user_id = Auth::user()->id ?? 1;
    $user->updated_user_id = Auth::user()->id ?? 1;
    $user->save();
    return $user;
  }

  /**
   * To get user by id
   * @param string $id user id
   * @return Object $user user object
   */
  public function getUserById($id)
  {
    $user = User::find($id);
    return $user;
  }

  public function getUserList()
  {
    // $name = request()->name;

    $users = User::latest()->paginate(5);
    //   $users = User::where([
    //     [function ($query) use ($request) {
    //         if (($s = $request->s)) {
    //             $query->orWhere('name', 'LIKE', '%' . $s . '%')
    //                 ->orWhere('email', 'LIKE', '%' . $s . '%')
    //                 ->get();
    //         }
    //     }]
    // ])->paginate(6);

    return $users;
  }

  /**
   * To Update User with values from request
   * @param Request $request request including inputs
   * @return Object updated user object
   */
  public function updateUser(Request $request)
  {
    $user = User::find(Auth::user()->id);
    $type = $request['type'] === 'User' ? 1 : 0;
    $user->name = $request['name'];
    $user->email = $request['email'];
    $user->profile = $request['profile'];
    $user->type = $type;
    $user->phone = $request['phone'];
    $user->dob = $request['dob'];
    $user->address = $request['address'];
    $user->updated_user_id = Auth::user()->id;
    $user->save();
    return $user;
  }

  public function update(Request $request,$id) {
    $user = User::find($id);
    $type = $request['type'] === 'User' ? 1 : 0;
    $user->name = $request['name'];
    $user->email = $request['email'];
    $user->profile = $request['profile'];
    $user->type = $type;
    $user->phone = $request['phone'];
    $user->dob = $request['dob'];
    $user->address = $request['address'];
    $user->updated_user_id = Auth::user()->id;
    $user->save();
    return $user;
  }

  public function changePassword($validated)
  {
    #Match The Old Password
    if (!Hash::check($validated['current_password'], auth()->user()->password)) {
      return back()->with("error", "Current Password Doesn't match!");
    }
    User::find(auth()->user()->id)
      ->update([
        'password' => Hash::make($validated['new_password']),
        'updated_user_id' => Auth::user()->id
      ]);
      return back()->with("status", "Password changed successfully!");
  }

  public function delete($id)
  {
    $user = User::find($id);
    $user->deleted_user_id = auth()->user()->id;
    $user->save();
    $user->delete();
  }
}
