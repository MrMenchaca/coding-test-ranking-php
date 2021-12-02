<?php

namespace App\Services;

use App\Database\InFileSystemPersistence;
use Exception;

class AdService {
    
    // ----------------------------- Atributes ----------------------------------------
    private InFileSystemPersistence $database;
    
    // ---------------------------- Constructors --------------------------------------
    public function __construct(){
        $this->database = InFileSystemPersistence::getInstance();
    }

    // ---------------------------- Methods -------------------------------------------
    /**
     * Return irrelevant orders
     * 
     * @return array Ad array 
     */
    public function getIrrelevantAds(): array {
        $this->updateAdsScore(); // * Not necessary in real app  *
        return $this->database->getIrrelevantAds();
    }

    /**
     * Method that update the score of all the ads in database
     * 
     * @return bool If it works properly returns true, false if not
     */
    public function updateAdsScore(): bool {
        $this->database = InFileSystemPersistence::getInstance(); // * Not necessary in real app * 
        
        try{
            $ads = $this->database->getAllAds();
            $this->calculateAdsScores($ads);
            $this->database->updateAds($ads); // * Not necessary in real app *
        }
        catch(Exception $e){
            return false;
        }
        return true;
    }

    /**
     * Auxiliary method to go through all ads
     * 
     * @param array Ad array
     */
    private function calculateAdsScores(array $ads): void{
        foreach($ads as $ad){
            $ad->updateScore();
        }
    }
}

?>