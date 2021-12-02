<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UpdateAdsScoreEndpointTest extends WebTestCase
{
    public function test(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request to /updateAdsScore
        $crawler = $client->request('POST', '/updateAdsScore');

        // Validate response is ok
        $this->assertResponseIsSuccessful();
        // Validate message 'Éxito' is printed
        $this->assertSelectorTextContains('h1', 'Éxito');
    }
}
?>