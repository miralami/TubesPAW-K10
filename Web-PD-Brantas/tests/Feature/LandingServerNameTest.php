<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class LandingServerNameTest extends TestCase
{
    public function test_landing_page_shows_configured_server_name(): void
    {
        Config::set('app.server_name', 'vm-1');

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Server: vm-1');
    }
}
