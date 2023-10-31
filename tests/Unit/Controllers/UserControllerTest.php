<?php

namespace Tests\Unit;

use App\Dao\User\UserDao;
use App\Http\Controllers\User\UserController;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Requests\ProfileEditRequest;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_show_register(): void
    {
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showRegistrationView();
        $this->assertNotNull($response);
    }

    public function test_save_user(): void
    {
        $userRequest = [
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => 'password',
            'confirm_password' => 'password',
        ];
        $request = new UserRegisterRequest($userRequest);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->submitRegistrationConfirmView($request);
        $this->assertNotNull($response);
    }

    public function test_show_users(): void
    {
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showUserList();
        $this->assertNotNull($response);
    }

    public function test_search_user_name(): void
    {
        $request = Request::create('/users', 'GET', ['name' => 'your-search', 'perPage' => 10]);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->search($request);
        $this->assertNotNull($response);
    }

    public function test_search_user_email(): void
    {
        $request = Request::create('/users', 'GET', ['email' => 'your-search', 'perPage' => 10]);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->search($request);
        $this->assertNotNull($response);
    }

    public function test_search_user_from_date(): void
    {
        $request = Request::create('/users', 'GET', ['fromDate' => 'your-search', 'perPage' => 10]);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->search($request);
        $this->assertNotNull($response);
    }

    public function test_search_user_to_date(): void
    {
        $request = Request::create('/users', 'GET', ['toDate' => 'your-search', 'perPage' => 10]);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->search($request);
        $this->assertNotNull($response);
    }

    public function test_show_crear_user(): void
    {
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showCreateView();
        $this->assertNotNull($response);
    }

    public function test_confirm_create_user(): void
    {
        // Create a fake uploaded file
        $file = UploadedFile::fake()->create('profile.jpg', 200);

        $user = [
            'name' => 'Create User',
            'email' => 'user@example.com',
            'profile' => $file,
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
        ];

        $request = new UserRegisterRequest();
        $request->merge($user);

        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->confirmUserCreate($request);

        $this->assertNotNull($response);
    }

    public function test_show_confirm_user_with_old_data(): void
    {
        $this->withSession(['_old_input' => [
            'name' => 'Old User',
            'email' => 'user@example.com',
            'profile' => 'profile.png',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
        ]]);
        $response = $this->get('/user/create/confirm');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->showUserConfirm($response);

        $this->assertNotNull($response);
    }

    public function test_show_confirm_user_without_old_data(): void
    {
        $this->withSession([]);
        $response = $this->get('/user/create/confirm');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->showUserConfirm($response);

        $this->assertNotNull($response);
    }

    public function test_show_profile(): void
    {
        $response = $this->get('/user/profile');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->showProfile($response);

        $this->assertNotNull($response);
    }

    public function test_show_profile_edit(): void
    {
        $response = $this->get('/user/profile/edit');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->showProfileEdit($response);

        $this->assertNotNull($response);
    }

    public function test_submit_profile_edit_with_new_profile(): void
    {
        $file = UploadedFile::fake()->image('new_profile.jpg');

        $request = new ProfileEditRequest();
        $request->files->add([
            'profile' => $file,
        ]);

        // Mock the user method to return a user with a profile attribute
        $user = User::factory()->create([
            'name' => 'Update User',
            'email' => 'user@example.com',
            'profile' => 'existing_profile.jpg',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Mock the storage facade
        // Storage::fake('public');

        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->submitProfileEdit($request);

        $this->assertNotNull($response);
    }

    public function test_submit_profile_edit_without_new_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'Update User',
            'email' => 'user@example.com',
            'profile' => 'existing_profile.jpg',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $request = new ProfileEditRequest();
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->submitProfileEdit($request);

        $this->assertNotNull($response);
    }

    public function test_show_profile_edit_confirm_with_old_data(): void
    {
        $this->withSession(['_old_input' => [
            'name' => 'Old User',
            'email' => 'user@example.com',
            'profile' => 'oldprofile.png',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
        ]]);
        $response = $this->get('/user/profile/edit/confirm');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showProfileEditConfirm($response);
        $this->assertNotNull($response);
    }

    public function test_show_profile_edit_confirm_without_old_data(): void
    {
        $this->withSession([]);
        $response = $this->get('/user/profile/edit/confirm');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showProfileEditConfirm($response);
        $this->assertNotNull($response);
    }

    public function test_submit_profile_edit_confirm(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $userRequest = [
            'name' => 'Update User',
            'email' => 'user@example.com',
            'profile' => 'existing_profile.jpg',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id
        ];
        $request = new Request($userRequest);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->submitProfileEditConfirm($request);
        $this->assertNotNull($response);
    }

    public function test_edit_user(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->editUser($user->id);
        $this->assertNotNull($response);
    }

    public function test_confirm_user_edit_with_new_profile(): void
    {
        $file = UploadedFile::fake()->image('new_profile.jpg');

        $request = new UserEditRequest();
        $request->files->add([
            'profile' => $file,
        ]);
        $user = User::factory()->create([
            'name' => 'Update User',
            'email' => 'user@example.com',
            'profile' => 'existing_profile.jpg',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->confirmUserEdit($request, $user->id);

        $this->assertNotNull($response);
    }

    public function test_confirm_user_edit_without_new_profile(): void
    {
        $user = User::factory()->create([
            'name' => 'Update User',
            'email' => 'user@example.com',
            'profile' => 'existing_profile.jpg',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $request = new UserEditRequest();
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);

        $response = $userController->confirmUserEdit($request, $user->id);

        $this->assertNotNull($response);
    }

    public function test_show_user_edit_confirm_with_old_data(): void
    {
        $this->withSession(['_old_input' => [
            'name' => 'Old User',
            'email' => 'user@example.com',
            'profile' => 'oldprofile.png',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
        ]]);

        $response = $this->get('/user/edit-confirm/{$user->id}');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showEditConfirm($response);
        $this->assertNotNull($response);
    }

    public function test_show_user_edit_confirm_without_old_data(): void
    {
        $this->withSession([]);

        $response = $this->get('/user/edit-confirm/{$user->id}');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showEditConfirm($response);
        $this->assertNotNull($response);
    }

    public function test_update_user(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $userRequest = [
            'name' => 'Update User',
            'email' => 'user@example.com',
            'profile' => 'existing_profile.jpg',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street',
            'created_user_id' => $user->id,
            'updated_user_id' => $user->id
        ];
        $request = new Request($userRequest);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->update($request, $user->id);
        $this->assertNotNull($response);
    }

    public function test_show_change_password(): void
    {
        $response = $this->get('/user/change-password');
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $userController = new UserController($userService);
        $response = $userController->showChangePassword($response);
        $this->assertNotNull($response);
    }

    public function test_save_password(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        if($user) {

            $requestPassword = [
                'current_password' => 'current_password',
                'new_password' => 'new_password',
                'new_password_confirmation' => 'new_password'
            ];
            $request = new PasswordChangeRequest($requestPassword);
            $userDao = new UserDao();
            $userService = new UserService($userDao);
            $userController = new UserController($userService);
            $response = $userController->savePassword($request);
            $this->assertNotNull($response);
        }
    }

    public function test_delete_user(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        if($user) {
            $userDao = new UserDao();
            $userService = new UserService($userDao);
            $userController = new UserController($userService);
            $response = $userController->destroy($user->id);
            $this->assertNotNull($response);
        }

    }
}
