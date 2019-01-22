<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlsRequestTest extends TestCase
{

    public function testUrlApiNews()
    {
        $response = $this->get('/api/news');
        $response->assertStatus(200);
    }

    public function testUrlApiNewsById()
    {
        $response = $this->get('/api/news/1');
        $response->assertStatus(200);
    }

    public function testUrlApiNewsByIdNotExisted()
    {
        $response = $this->get('/api/news/51');
        $response->assertStatus(403);
    }

    public function testUrlApiNewsByPage()
    {
        $response = $this->get('/api/news/page/1');
        $response->assertStatus(200);
    }

    public function testUrlApiNewsByPageNotExisted()
    {
        $response = $this->get('/api/news/page/10');
        $response->assertStatus(403);
    }

    
}
