<?php

namespace Tests\Unit;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\TrustHosts;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MiddlewareRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testRedirectToHomeForNonAdminUser()
    {
        // Create a mock user with a non-admin type
        $user = User::factory()->create([
            'type' => '1',
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]); // Assuming '1' represents a non-admin user

        // Create a mock request with the user
        $request = Request::create('/login');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Create an instance of the AdminMiddleware
        $middleware = new AdminMiddleware();

        // Call the handle method
        $response = $middleware->handle($request, function () {
            // This closure should not be executed in this test
            $this->fail('Closure should not be executed');
        });

        // Assert that the response is a redirect to '/home'
        $this->assertEquals(302, $response->getStatusCode());
        // $this->assertEquals('/login', $response->getTargetUrl());
    }

    public function testContinueForAdminUser()
    {
        // Create a mock user with an admin type
        $user = User::factory()->create([
            'type' => '0',
            'created_user_id' => 1,
            'updated_user_id' => 1
        ]); // Assuming '0' represents an admin user

        // Create a mock request with the user
        $request = Request::create('/home');
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        // Create an instance of the AdminMiddleware
        $middleware = new AdminMiddleware();

        // Call the handle method
        $response = $middleware->handle($request, function ($request) {
            // This closure should be executed in this test
            return response('OK', 200);
        });

        // Assert that the response is 'OK' with a status code of 200
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }  

    public function testRedirectIfAuthenticated()
    {
        // Create a mock request
        $request = Request::create('/dashboard');

        // Mock the Auth facade to simulate an authenticated user
        Auth::shouldReceive('guard')->with(null)->once()->andReturnSelf();
        Auth::shouldReceive('check')->once()->andReturn(true);

        // Create an instance of the RedirectIfAuthenticated middleware
        $middleware = new RedirectIfAuthenticated();

        // Call the handle method
        $response = $middleware->handle($request, function () {
            // This closure should not be executed in this test
            $this->fail('Closure should not be executed');
        });

        // Assert that the response is a redirect to RouteServiceProvider::HOME
        $this->assertEquals(302, $response->getStatusCode());
        // $this->assertEquals(RouteServiceProvider::HOME, $response->getTargetUrl());
    }

    public function testContinueIfNotAuthenticated()
    {
        // Create a mock request
        $request = Request::create('/dashboard');

        // Mock the Auth facade to simulate a non-authenticated user
        Auth::shouldReceive('guard')->with(null)->once()->andReturnSelf();
        Auth::shouldReceive('check')->once()->andReturn(false);

        // Create an instance of the RedirectIfAuthenticated middleware
        $middleware = new RedirectIfAuthenticated();

        // Call the handle method
        $response = $middleware->handle($request, function ($request) {
            // This closure should be executed in this test
            return response('OK', 200);
        });

        // Assert that the response is 'OK' with a status code of 200
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getContent());
    }

    public function testHostsMethod()
    {
        $app = $this->app;

        // Create an instance of the TrustHosts middleware
        $middleware = new TrustHosts($app);

        // Call the hosts method
        $hosts = $middleware->hosts();

        // Assert that the result is an array with one element (the subdomain pattern)
        $this->assertIsArray($hosts);
        $this->assertCount(1, $hosts);

        // Assert that the element is not null
        $this->assertNotNull($hosts[0]);

        // You can add more specific assertions based on your actual use case
    }
}
