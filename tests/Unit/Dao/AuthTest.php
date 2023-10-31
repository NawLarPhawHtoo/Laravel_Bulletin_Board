<?php

namespace Tests\Unit;

use App\Dao\Auth\AuthDao;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    
    public function test_register(): void
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
        $user = $authDao->saveUser($request);
        $this->assertNotNull($user);
    }
}
