<?php

namespace App\Domain\Typology;

use App\Domain\Ad;

/**
 * Interface that declaring typology-related funcionality
 */
interface ITypology {
    
    /**
     * Returns the score by typology based on the number of words in the description
     * 
     * @param String Description to count words
     * 
     * @return int Amount to add
     */
    public function getDescriptionScore(String $description): int;

    /**
     * Get an amount to add if $ad is complete. Whether it is complete, depends on 
     * each typology
     * 
     * @param Ad Ad to check if it is complete
     * 
     * @return int Amount to add
     */
    public function getIsCompleteScore(Ad $ad): int;
}

?>