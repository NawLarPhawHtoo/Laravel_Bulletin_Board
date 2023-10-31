<?php

namespace Tests\Unit;

use App\Http\Requests\PasswordChangeRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordChangeRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_authorize(): void
    {
        $request = new PasswordChangeRequest();
        $response = $request->authorize();
        $this->assertNotNull($response);
    }

    public function test_rules(): void
    {
        $passwordRequest = [
            'current_password' => 'current_password',
            'new_password' => 'new_password',
            'new_password_confirmation' => 'new_password'
        ];

        $request = new PasswordChangeRequest();
        $response = $request->rules($passwordRequest);
        $this->assertNotNull($response);
    }
}
