<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetIrrelevantAdsEndpointTest extends WebTestCase
{
    public function test(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request to /getIrrelevantAds
        $crawler = $client->request('GET', '/getIrrelevantAds');

        // Validate response is ok
        $this->assertResponseIsSuccessful();
        // Validate HTML
        $this->assertSelectorTextContains('body', 'Anuncios irrelevantesLos anuncios irrelevantes son los siguientes:El anuncio con id: 3, que tiene score: 30El anuncio con id: 6, que tiene score: 0');
        
    }
}
?>