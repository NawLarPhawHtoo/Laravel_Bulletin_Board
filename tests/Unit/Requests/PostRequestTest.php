<?php

namespace Tests\Unit;

use App\Http\Requests\PostRequest;
use Tests\TestCase;

class PostRequestTest extends TestCase
{
    public function test_authorize(): void
    {
        $request = new PostRequest();
        $response = $request->authorize();
        $this->assertNotNull($response);
    }

    public function test_rules(): void
    {
        $postRequest = [
            'title' => 'Post Title',
            'description' => 'Post Description'
        ];

        $request = new PostRequest();
        $response = $request->rules($postRequest);
        $this->assertNotNull($response);
    }
}
