<?php

namespace App\Http\Controllers\User;

use App\Contracts\Services\Auth\AuthServiceInterface;
use App\Contracts\Services\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileEditRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  // private $authInterface;
  private $userInterface;

  /**
   * Create a new controller instance.
   * @param UserServiceInterface
   * @return void
   */
  public function __construct(UserServiceInterface $userServiceInterface)
  {
    $this->middleware('auth');
    $this->userInterface = $userServiceInterface;
  }

  /**
   * To show registration view
   * @return View registration form
   */
  protected function showRegistrationView()
  {
    return view('auth.register');
  }

  /**
   * To check register form is valid or not
   *
   * @param UserRegisterRequest $request
   * @return View registration confirm
   */
  protected function submitRegistrationView(UserRegisterRequest $request)
  {
    $validated = $request->validated();
    return redirect()
      ->route('register.confirm')
      ->withInput();
  }


  /**
   * To show registration view
   * @return View registration confirm view
   */
  protected function showRegistrationConfirmView()
  {
    if (old()) {
      return view('auth.register-confirm');
    }
    return redirect()
      ->route('userlist');
  }

  /**
   * To submit register confirm and save user info to DB
   * @return View user list
   */
  protected function submitRegistrationConfirmView(Request $request)
  {
    $user = $this->userInterface->saveUser($request);
    return redirect()->route('userlist')->withStatus('New User has been created Successfully.');
  }

  public function showUserList()
  {
    $users = $this->userInterface->getUserList();
    return view('users.index', compact('users'));
  }

  public function search(Request $request)
  {
    // Retrieve the search parameters from the request
    $name = $request->input('name');
    $email = $request->input('email');
    $fromDate = $request->input('fromDate');
    $toDate = $request->input('toDate');

    $perPage = $request->input('perPage', 5);

    // Perform the search based on the criteria
    $users = User::query()
      ->when($name, function ($query) use ($name) {
        return $query->where('name', 'like', "%$name%");
      })
      ->when($email, function ($query) use ($email) {
        return $query->where('email', 'like', "%$email%");
      })
      ->when($fromDate, function ($query) use ($fromDate) {
        return $query->whereDate('created_at', '>=', $fromDate);
      })
      ->when($toDate, function ($query) use ($toDate) {
        return $query->whereDate('created_at', '<=', $toDate);
      })
      ->paginate($perPage);

    // Return the view with the search results
    return view('users.index', compact('users'));
  }


  public function showCreateView()
  {
    return view('users.create');
  }

  public function confirmUserCreate(UserRegisterRequest $request)
  {
    $validated = $request->validated();
    $profileName = time() . '.' . $validated['profile']->extension();
    $validated['profile']->move(public_path('profiles'), $profileName);
    return redirect()->route('users.view-create-confirm')->withInput()
      ->with('profile', $profileName);
  }

  /**
   * To show post create confirm view
   *
   * @return View post create confirm view
   */
  public function showUserConfirm()
  {
    if (old()) {
      return view('users.create-confirm');
    }
    return redirect()->route('userlist');
  }

  public function showProfile()
  {
    $userId = Auth::user()->id;
    $user = $this->userInterface->getUserById($userId);
    return view('users.profile', compact('user'));
  }

  public function showProfileEdit()
  {
    $userId = Auth::user()->id;
    $user = $this->userInterface->getUserById($userId);
    return view('users.profile-edit', compact('user'));
  }

  public function submitProfileEdit(ProfileEditRequest $request)
  {
    $validated = $request->validated();
    if ($request->hasFile('profile')) {
      $profileName = time() . '.' . $validated['profile']->extension();
      $validated['profile']->move(public_path('profiles'), $profileName);
    } else {
      $profileName = $request->user()->profile;
    }

    return redirect()->route('profile.edit.confirm')->withInput()
      ->with('profile', $profileName);
  }

  /**
   * To show profile edit confirm view
   *
   * @return View profile edit confirm view
   */
  public function showProfileEditConfirm()
  {
    if (old()) {
      return view('users.profile-edit-confirm');
    }
    return redirect()->route('users.profile');
  }

  public function submitProfileEditConfirm(Request $request)
  {
    $user = $this->userInterface->updateUser($request);
    return redirect()->route('users.profile')->withStatus('Profile has been updated Successfully.');
  }


  public function editUser($id)
  {
    $user = $this->userInterface->getUserById($id);
    return view('users.edit', compact('user'));
  }

  public function confirmUserEdit(UserEditRequest $request, $id)
  {
    $validated = $request->validated();
    $user = User::find($id);
    if ($request->hasFile('profile')) {
      $profileName = time() . '.' . $validated['profile']->extension();
      $validated['profile']->move(public_path('profiles'), $profileName);

      $user->profile = $profileName;
      $user->save();
    } else {
      $profileName = $user->profile;
    }
    return redirect()->route('users.view-edit-confirm', [$id])->withInput()->with('profile', $profileName);
  }

  public function showEditConfirm($id)
  {
    if (old()) {
      return view('users.edit-confirm',  compact('id'));
    }
    return redirect()->route('userlist');
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $this->userInterface->update($request, $id);
    return redirect()->route('userlist')->withStatus('User has been updated successfully.');
  }


  /**
   * To Show the application dashboard.
   *
   * @return View change password view
   */
  public function showChangePassword()
  {
    return view('users.change-password');
  }

  public function savePassword(PasswordChangeRequest $request)
  {
    $validated = $request->validated();
    $user = $this->userInterface->changePassword($validated);
    return redirect()->route('users.profile')->withStatus('Change Password Successfully.');
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $this->userInterface->delete($id);
    return redirect()->route('userlist')->withStatus('User has been deleted successfully.');
  }
}
