<?php

namespace App\Domain\Typology;

use App\Domain\Ad;

/** 
 * Concrete Typology
*/
class Garage extends AbstractTypology {
    
    // ----------------------------- Atributes ----------------------------------------

    // ---------------------------- Constructors --------------------------------------

    // ---------------------------- Methods -------------------------------------------
    /**
     * Get an amount to add if $ad is complete. For Garage, we check the following:
     *   1. $pictures > 0
     * 
     * @param Ad Ad to check if it is complete
     * 
     * @return int Amount to add
     */
    protected function isComplete(Ad $ad): bool{
        if(!empty($ad->getPictures())){
            return true;
        }
        return false;
    }
}

?>