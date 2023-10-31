<?php

namespace Tests\Unit;

use App\Http\Requests\PostEditRequest;
use Tests\TestCase;

class PostEditRequestTest extends TestCase
{
    public function test_authorize(): void
    {
        $request = new PostEditRequest();
        $response = $request->authorize();
        $this->assertNotNull($response);
    }

    public function test_rules(): void
    {
        $postRequest = [
            'title' => 'Post Title',
            'description' => 'Post Description'
        ];

        $request = new PostEditRequest();
        $response = $request->rules($postRequest);
        $this->assertNotNull($response);
    }
}
