<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    public function testNoArticlesAreReturned(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/articles');

        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertEquals(json_encode([
            'articles' => [],
            'articlesCount' => 0,
        ]), $response->getContent());
        $this->assertResponseHasHeader('Content-Type', 'application/json');
    }
}
