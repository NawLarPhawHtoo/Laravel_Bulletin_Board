<?php

namespace Tests\Unit;

use App\Http\Requests\UserEditRequest;
use PHPUnit\Framework\TestCase;

class UserEditRequestTest extends TestCase
{
    public function test_authorize(): void
    {
        $request = new UserEditRequest();
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

        $request = new UserEditRequest();
        $response = $request->rules($profileRequest);
        $this->assertNotNull($response);
    }
}
