<?php

namespace Tests\Unit;

use App\Http\Requests\ProfileEditRequest;
use Tests\TestCase;

class ProfileEditRequestTest extends TestCase
{
    public function test_authorize(): void
    {
        $request = new ProfileEditRequest();
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

        $request = new ProfileEditRequest();
        $response = $request->rules($profileRequest);
        $this->assertNotNull($response);
    }
}
