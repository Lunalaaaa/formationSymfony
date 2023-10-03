<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WebTest extends WebTestCase
{
    private static $client;

    protected function setUp(): void {
        self::$client = static::createClient();
    }
    
    public function provideUrlAndResponse(): array{
        return [
            ['/hello/bou', 'Hello bou ! ✅'],
            ['/hello/blbl', 'Hello blbl ! ✅'],
            ['/hello', 'Hello ! ✅'],
        ];
    }

    public function testRecuperationNomDansTitre(): void
    {
        $crawler = self::$client->request('GET', '/hello/bou');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello bou ! ✅');
    }
    
    public function testTitreSansNom(): void
    {
        $crawler = self::$client->request('GET', '/hello');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello ! ✅');
    }
    
    /**
     * @dataProvider provideUrlAndResponse
     */
    public function testAvecProvidersPourTitre(string $route, string $expectedTitle){
        // permet de naviquer dans la page avcec des expressions CSS par exemple
        $crawler = self::$client->request('GET', $route);
        
        $this->assertResponseIsSuccessful();
        // utilise le crawler
        $this->assertSelectorTextContains('h1', $expectedTitle);
    }
}
