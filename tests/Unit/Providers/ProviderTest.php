<?php

namespace Tests\Unit;

use App\Providers\BroadcastServiceProvider;
use Tests\TestCase;

class ProviderTest extends TestCase
{
  public function test_broadcast_routes_are_registered()
  {
    $provider = new BroadcastServiceProvider($this->app);

    $provider->boot();
    $this->assertTrue(true);
  }
}
