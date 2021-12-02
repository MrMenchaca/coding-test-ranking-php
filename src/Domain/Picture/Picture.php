<?php

declare(strict_types=1);

namespace App\Domain\Picture;

use App\Domain\Picture\PictureQuality\IPictureQuality;

/**
 * Domain class
 */
final class Picture
{
    // ----------------------------- Attributes ---------------------------------
    private int $id;
    private String $url;
    private IPictureQuality $quality;

    // --------------------------- Constructors ---------------------------------
    public function __construct(
        int $id,
        String $url,
        IPictureQuality $quality,
    ) {
        $this->id = $id;
        $this->url = $url;
        $this->quality = $quality;
    }

    // ---------------------------- Methods -------------------------------------   
    /**
     * Returns score based on the quality picture
     * 
     * @return int Score
     */
    public function getQualityScore(): int {
        return $this->quality->getScore();
    }
}
