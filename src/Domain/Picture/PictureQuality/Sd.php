<?php

namespace App\Domain\Picture\PictureQuality;

/**
 * Concrete Quality
 */
class Sd implements IPictureQuality {

    // ----------------------------- Atributes ----------------------------------------
    private static Sd $instance;

    // ---------------------------- Constructors --------------------------------------
    /**
     * Constructor must be private to prevent other classes from creating more instances
     */
    private function __construct() {}

    // ---------------------------- Methods ------------------------------------------
    /**
     * Returns a single instance of this class
     * 
     * @return Hd Instance of this class
     */
    public static function getInstance(): Sd {
        if (!isset(self::$instance)){
            self::$instance = new Sd();
        }
        return self::$instance;
    }

    /**
     * Returns the quality score
     * 
     * @return int Score
     */
    public function getScore(): int{
        return 10;
    }
}

?>