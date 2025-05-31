<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CataloguePageTest extends WebTestCase
{
    public function testCataloguePageIsAccessible(): void
    {
        $client = static::createClient();
        $client->request('GET', '/articles');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Nos articles'); 
    }
}
