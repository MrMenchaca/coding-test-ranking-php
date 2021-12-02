<?php

namespace App\Controller;


use App\Services\AdService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Controller {

    private AdService $service;

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
}

?>
