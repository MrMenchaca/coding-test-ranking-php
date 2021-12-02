<?php

namespace App\Controller;


use App\Services\AdService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller {

    private AdService $service;
    /**
     * Endpoint that returns relevant ads ordered by score 
     * 
     * @Route("/getAllAdsByScore")
     */
    public function getAllAdsByScore(): Response
    {
        $this->service = new AdService();  //* Not necessary in real app *

        $ads = $this->service->getAllAdsByScore();
        
        return new Response(
                '<html><body>Se obtuvieron: '.sizeof($ads).'</body></html>'
        );
    }

    /**
     * Endpoint that update the score of all the ads in database and prints a message 
     * based on if it works properly or not
     * 
     * @Route("/updateAdsScore")
     */
    public function updateAdsScore(): Response
    {
        $this->service = new AdService();  // * Not necessary in real app *

        $updateSuccesfull = $this->service->updateAdsScore();

        return new Response(
                '<html><body>'.$updateSuccesfull ? 'Éxito' : 'Error'.'</body></html>'
        );
    }

    /**
     * Endpoint that returns irrelevants ads with the date they became irrelevant
     * 
     * @Route("/getIrrelevantAds")
     */
    public function getIrrelevantAds(): Response
    {
        $this->service = new AdService();  //* Not necessary in real app *

        $ads = $this->service->getIrrelevantAds();

        return new Response(
                '<html><body>Se obtuvieron: '.sizeof($ads).'</body></html>'
        );
    }
}

?>
