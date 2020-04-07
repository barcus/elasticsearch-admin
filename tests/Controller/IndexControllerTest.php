<?php

namespace App\Tests\Controller;

use App\Tests\Controller;

class IndexControllerTest extends AbstractAppControllerTest
{
    public function testIndex()
    {
        $this->client->request('GET', '/admin/indices');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testReindex()
    {
        $this->client->request('GET', '/admin/indices/reindex');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testCreate()
    {
        $this->client->request('GET', '/admin/indices/create');

        $this->assertResponseStatusCodeSame(200);
    }

    public function testRead404()
    {
        $this->client->request('GET', '/admin/indices/'.uniqid());

        $this->assertResponseStatusCodeSame(404);
    }

    public function testUpdate404()
    {
        $this->client->request('GET', '/admin/indices/'.uniqid().'/update');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testSettings404()
    {
        $this->client->request('GET', '/admin/indices/'.uniqid().'/settings');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testMappings404()
    {
        $this->client->request('GET', '/admin/indices/'.uniqid().'/mappings');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testShards404()
    {
        $this->client->request('GET', '/admin/indices/'.uniqid().'/shards');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testDocuments404()
    {
        $this->client->request('GET', '/admin/indices/'.uniqid().'/documents');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testAliases404()
    {
        $this->client->request('GET', '/admin/indices/'.uniqid().'/aliases');

        $this->assertResponseStatusCodeSame(404);
    }
}
