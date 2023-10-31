<?php

namespace Tests\Unit;

use App\Http\Controllers\HomeController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_home_index(): void
    {
        $homeController = new HomeController();
        $response = $homeController->index();
        $this->assertNotNull($response);
    }
}
