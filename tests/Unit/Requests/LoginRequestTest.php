<?php

namespace Tests\Unit;

use App\Http\Requests\LoginAPIRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_authorize(): void
    {
        $request = new LoginAPIRequest();
        $response = $request->authorize();
        $this->assertNotNull($response);

    }

    public function test_request_rules(): void
    {
        $loginRequest = [
            'email' => 'user@example.com',
            'password' => 'password'
        ];

        $request = new LoginAPIRequest();
        $response = $request->rules($loginRequest);
        $this->assertNotNull($response);
    }

    public function testFailedValidation()
    {
        // Create an instance of LoginAPIRequest
        $request = new LoginAPIRequest();

        // Create a Validator instance
        $validator = Validator::make([], [
            'email' => 'required',
            'password' => 'required',
        ]);

        // Simulate validation failure by manually setting errors
        $validator->errors()->add('email', 'The email field is required.');
        $validator->errors()->add('password', 'The password field is required.');

        // Expect that the ValidationException is thrown
        $this->expectException(HttpResponseException::class);

        // Call the failedValidation method with the Validator instance
        $request->failedValidation($validator);
    }
}
