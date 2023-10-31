<?php

namespace Tests\Unit;

use App\Dao\Auth\AuthDao;
use App\Services\Auth\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function test_save_user(): void
    {
        $requestData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'type' => 1,
            'created_user_id' => 1,
            'updated_user_id' => 1
        ];

        $request = new Request($requestData);

        $authDao = new AuthDao();
        $authService = new AuthService($authDao);
        $user = $authService->saveUser($request);
        $this->assertNotNull($user);
    }
}
