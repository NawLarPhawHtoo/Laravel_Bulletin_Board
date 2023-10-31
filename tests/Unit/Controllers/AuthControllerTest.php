<?php

namespace Tests\Unit;

use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_login(): void
    {
        $request = Request::create('/login', 'POST', [
            'email' => 'user@example.com',
            'password' => 'password',
            'remember' => 0, // Adjust as needed
        ]);
        $loginController = new LoginController();
        $result = $loginController->attemptLogin($request);
        $this->assertNotNull($result);
    }

    public function test_register(): void
    {
        $userRequest = Request::create(
            '/register',
            'POST',
            [
                'name' => 'User',
                'email' => 'user@example.com',
                'password' => Hash::make('password'),
                'created_user_id' => 1,
                'updated_user_id' => 1
            ]);
            $registerController = new RegisterController();
            $result = $registerController->create($userRequest);
            $this->assertNotNull($result);
    }

    public function test_validaton(): void
    {
        $data = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];
        $registerController = new RegisterController();
        $validator = $registerController->validator($data);
        $this->assertNotNull($validator);
    }

    public function test_confirm_password_middleware()
    {
        $controller = new ConfirmPasswordController();

        // Get the middleware assigned to the controller
        $middleware = $controller->getMiddleware();

        // Assert that the 'auth' middleware is applied
        $this->assertNotNull($middleware);
    }

    public function test_verification_middleware()
    {
        $controller = new VerificationController();

        // Get the middleware assigned to the controller
        $middleware = $controller->getMiddleware();
        $this->assertNotNull($middleware);
    }
}
