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
        

        // * Not necessary in real app *
        $aux = '<h1>Anuncios relevantes ordenados</h1><p>Los anuncios relevantes que verá el cliente son los siguientes:</p><ul>';
        foreach($ads as $ad){
            $aux .= '<li>El anuncio con id: ' . $ad->getId() . ', que tiene score: ' . $ad->getScore() . '</li>';
        }
        $aux .= '</ul>';

        
        return new Response(
                '<html><body>'. $aux .'</body></html>'
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
                '<html><body>'.$updateSuccesfull ? '<h1>Éxito</h1>' : '<h1>Error</h1>'.'</body></html>'
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
        

        // * Not necessary in real app *
        $aux = '<h1>Anuncios irrelevantes</h1><p>Los anuncios irrelevantes son los siguientes:</p><ul>';
        foreach($ads as $ad){
            $aux .= '<li>El anuncio con id: ' . $ad->getId() . ', que tiene score: ' . $ad->getScore() . '</li>';
        }
        $aux .= '</ul>';


        return new Response(
                '<html><body>' . $aux . '</body></html>'
        );
    }
}

?>
