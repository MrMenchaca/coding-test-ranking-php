<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetAllAdsByScoreEndpointTest extends WebTestCase
{
    public function test(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request to /getAllAdsByScore
        $crawler = $client->request('GET', '/getAllAdsByScore');

        // Validate response is ok
        $this->assertResponseIsSuccessful();
        // Validate HTML
        $this->assertSelectorTextContains('body', 'Anuncios relevantes ordenadosLos anuncios relevantes que verá el cliente son los siguientes:El anuncio con id: 1, que tiene score: 100El anuncio con id: 5, que tiene score: 100El anuncio con id: 2, que tiene score: 95El anuncio con id: 7, que tiene score: 95El anuncio con id: 4, que tiene score: 90El anuncio con id: 8, que tiene score: 65');
        
    }
}
?>