<?php

namespace Tests\Unit;

use App\Dao\User\UserDao;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_create_user(): void
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'profile' => '123456789.png',
            'type' => 1,
            'phone' => '1234567890',
            'dob' => '1990-01-01',
            'address' => '123 Test Street',
        ];
        $request = new Request($userData);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $user = $userService->saveUser($request);
        $this->assertNotNull($user);
    }

    public function test_detail_user(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $user = $userService->getUserById($user->id);
        $this->assertNotNull($user);
    }

    public function test_get_users(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        $userDao = new UserDao();
        $userService = new UserService($userDao);
        $users = $userService->getUserList();
        $this->assertNotNull($users);
    }

    public function test_update_profile(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        if ($user) {
            $requestData = [
                'name' => 'Updated User',
                'email' => 'updated@example.com',
                'profile' => 'Updated Profile',
                'type' => 1, // You can change this to 'Admin' for testing the type condition
                'phone' => '9876543210',
                'dob' => '1995-01-01',
                'address' => '456 New Street',
            ];
            $request = new Request($requestData);
            $userDao = new UserDao();
            $userService = new UserService($userDao);
            $users = $userService->updateUser($request);
            $this->assertNotNull($users);
        }
    }

    public function test_update_user(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        if ($user) {
            $requestData = [
                'name' => 'Updated User',
                'email' => 'updated@example.com',
                'profile' => 'Updated Profile',
                'type' => 1, // You can change this to 'Admin' for testing the type condition
                'phone' => '9876543210',
                'dob' => '1995-01-01',
                'address' => '456 New Street',
            ];

            $request = new Request($requestData);

            $userDao = new UserDao();
            $userService = new UserService($userDao);
            $updatedUser = $userService->update($request, $user->id);
            $this->assertNotNull($updatedUser);
        }
    }

    // public function test_change_password_error(): void
    // {
    //     // Create a test user with a known password
    //     $user = User::factory()->create([
    //         'name' => 'Test User',
    //         'email' => 'test@example.com',
    //         'password' => Hash::make('old_password'),
    //         'created_user_id' => 1,
    //         'updated_user_id' => 1
    //     ]);

    //     if ($user) {
    //         $requestData = [
    //             'current_password' => 'password',
    //             'new_password' => 'new_password',
    //         ];
    //         $request = new Request($requestData);

    //         $userDao = new UserDao();
    //         $userService = new UserService($userDao);
    //         $user = $userService->changePassword($request);
    //         $this->assertNotNull($user);
    //     }
    // }

    public function test_change_password(): void
    {
        // Create a test user with a known password
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('old_password'),
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);

        if ($user) {
            $requestData = [
                'current_password' => 'old_password',
                'new_password' => 'new_password',
            ];
            $request = new Request($requestData);

            $userDao = new UserDao();
            $userService = new UserService($userDao);
            $user = $userService->changePassword($request);
            $this->assertNotNull($user);
        }
    }

    public function test_delete_user(): void
    {
        $user = User::factory()->create([
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]);
        if ($user) {
            $userDao = new UserDao();
            $userService = new UserService($userDao);
            $userService->delete($user->id);
            $deletedUser = User::find($user->id);
            $this->assertNull($deletedUser);
        }
    }
}
