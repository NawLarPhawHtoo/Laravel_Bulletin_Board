<?php

namespace Tests\Unit;

use App\Http\Requests\UserRegisterRequest;
use PHPUnit\Framework\TestCase;

class UserRegisterRequestTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }public function test_authorize(): void
    {
        $request = new UserRegisterRequest();
        $response = $request->authorize();
        $this->assertNotNull($response);

    }
    
    public function test_request_rules(): void
    {
        $profileRequest = [
            'name' => 'Update User',
            'email' => 'user@example.com',
            'profile' => 'profile.jpg',
            'type' => 1,
            'phone' => '9876543210',
            'dob' => '1995-01-01',
            'address' => '456 New Street'
        ];

        $request = new UserRegisterRequest();
        $response = $request->rules($profileRequest);
        $this->assertNotNull($response);
    }
}
