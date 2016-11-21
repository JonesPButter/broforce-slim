<?php

namespace Tests\Functional;

class HomepageTest extends BaseTestCase
{
    /**
     * Test that the /greeting Route answers with "Hello, World!"
     */
    public function testGetHomepageWithoutName()
    {
        $response = $this->runApp('GET', '/greeting');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello, World!', (string)$response->getBody());
    }

    /**
     * Test that the / route with optional name argument returns a rendered greeting
     */
    public function testGetHomepageWithGreeting()
    {
        $response = $this->runApp('GET', '/name');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Hello name!', (string)$response->getBody());
    }

    /**
     * Test that the index route won't accept a post request
     */
    public function testPostHomepageNotAllowed()
    {
        $response = $this->runApp('POST', '/', ['test']);

        $this->assertEquals(405, $response->getStatusCode());
        $this->assertContains('Method not allowed', (string)$response->getBody());
    }
}