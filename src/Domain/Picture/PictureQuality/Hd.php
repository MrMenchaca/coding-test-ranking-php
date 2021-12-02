<?php

namespace App\Domain\Picture\PictureQuality;

/**
 * Concrete Quality
 */
class Hd implements IPictureQuality {

    // ----------------------------- Atributes ----------------------------------------
    private static Hd $instance;

    // ---------------------------- Constructors --------------------------------------
    /**
     * Constructor must be private to prevent other classes from creating more instances
     */
    private function __construct() {}

    // ---------------------------- Methods -------------------------------------------
    /**
     * Returns a single instance of this class
     * 
     * @return Hd Instance of this class
     */
    public static function getInstance(): Hd {
        if (!isset(self::$instance)){
            self::$instance = new Hd();
        }
        return self::$instance;
    }

    /**
     * Returns the quality score
     * 
     * @return int Score
     */
    public function getScore(): int{
        return 20;
    }
}

?>