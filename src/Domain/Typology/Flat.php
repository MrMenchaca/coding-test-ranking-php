<?php

namespace App\Domain\Typology;

use App\Domain\Ad;

/** 
 * Concrete Typology
*/
class Flat extends AbstractTypology {
    
    // ----------------------------- Atributes ----------------------------------------
    private ?int $houseSize;

    // ---------------------------- Constructors --------------------------------------
    public function __construct(int $houseSize = null)
    {
        $this->houseSize = $houseSize;
    }

    // ---------------------------- Methods -------------------------------------------
    /**
     * Returns the score by typology based on the number of words in the description.
     * Override the abstract method
     * 
     * @param int number of words
     * 
     * @return int Score to add
     */
    public function getScoreWithWordsCount(int $wordsCount): int{
        if($wordsCount >= 20 && $wordsCount <= 49){
            return 10;
        }
        else if ($wordsCount >= 50){
            return 30;
        }
        return 0;
    }

    /**
     * Get an amount to add if $ad is complete. For Flat, we check the following:
     *   1. $description not null and not empty
     *   2. $pictures > 0
     *   3. $houseSize not null
     * 
     * @param Ad Ad to check if it is complete
     * 
     * @return int Amount to add
     */
    public function isComplete(Ad $ad): bool{
        if((!is_null($ad->getDescription()) && !empty($ad->getDescription())) &&
        !empty($ad->getPictures()) &&
        !is_null($this->houseSize)){
            return true;
        }
        return false;
    }
}

?>