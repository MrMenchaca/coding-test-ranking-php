<?php

namespace App\Domain\Picture\PictureQuality;

/**
 * Interface declaring quality-related funcionality
 */
interface IPictureQuality {
    
    /**
     * Returns the quality score
     * 
     * @return int Score
     */
    public function getScore(): int;
}

?>