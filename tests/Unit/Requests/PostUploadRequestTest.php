<?php

namespace Tests\Unit;

use App\Http\Requests\PostUploadRequest;
use Tests\TestCase;

class PostUploadRequestTest extends TestCase
{
    public function test_authorize(): void
    {
        $request = new PostUploadRequest();
        $response = $request->authorize();
        $this->assertNotNull($response);
    }

    public function test_rules(): void
    {
        $uploadRequest = [
            'file' => 'post.xlsx'
        ];

        $request = new PostUploadRequest();
        $response = $request->rules($uploadRequest);
        $this->assertNotNull($response);
    }
}
