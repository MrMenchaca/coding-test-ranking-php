<?php

declare(strict_types=1);

namespace App\Database;

use App\Domain\Ad;
use App\Domain\Picture\Picture;
use App\Domain\Picture\PictureQuality\Hd;
use App\Domain\Picture\PictureQuality\Sd;
use App\Domain\Typology\Chalet;
use App\Domain\Typology\Flat;
use App\Domain\Typology\Garage;
use Exception;

final class InFileSystemPersistence {

    // ----------------------------- Atributes ----------------------------------------
    private static InFileSystemPersistence $instance; 

    private array $ads = [];
    private array $pictures = [];

    // ---------------------------- Constructors --------------------------------------
    public function __construct()
    {
        array_push($this->ads, new Ad(1, new Chalet(300, 100), 'Este piso es una ganga, compra, compra, COMPRA!!!!!', [], null, null));
        array_push($this->ads, new Ad(2, new Flat(100), 'Nuevo Ático céntrico recién reformado. No deje pasar la oportunidad y adquiera este ático de lujo', [], null, null));
        array_push($this->ads, new Ad(3, new Chalet(300, null), '', [], null, null));
        array_push($this->ads, new Ad(4, new Flat(null), 'Ático céntrico muy luminoso y recién reformado, parece nuevo', [], null, null));
        array_push($this->ads, new Ad(5, new Flat(null), 'Pisazo,', [], null, null));
        array_push($this->ads, new Ad(6, new Garage(), '', [], null, null));
        array_push($this->ads, new Ad(7, new Garage(), 'Garaje en el centro de Albacete', [], null, null));
        array_push($this->ads, new Ad(8, new Garage(), 'Maravilloso chalet situado en lAs afueras de un pequeño pueblo rural. El entorno es espectacular, las vistas magníficas. ¡Cómprelo ahora!', [], null, null));

        array_push($this->pictures, new Picture(1, 'https://www.idealista.com/pictures/1', Sd::getInstance()));
        array_push($this->pictures, new Picture(2, 'https://www.idealista.com/pictures/2', Hd::getInstance()));
        array_push($this->pictures, new Picture(3, 'https://www.idealista.com/pictures/3', Sd::getInstance()));
        array_push($this->pictures, new Picture(4, 'https://www.idealista.com/pictures/4', Hd::getInstance()));
        array_push($this->pictures, new Picture(5, 'https://www.idealista.com/pictures/5', Sd::getInstance()));
        array_push($this->pictures, new Picture(6, 'https://www.idealista.com/pictures/6', Sd::getInstance()));
        array_push($this->pictures, new Picture(7, 'https://www.idealista.com/pictures/7', Sd::getInstance()));
        array_push($this->pictures, new Picture(8, 'https://www.idealista.com/pictures/8', Hd::getInstance()));

        $this->ads[0]->addPicture($this->pictures[0]);
        $this->ads[0]->addPicture($this->pictures[1]);
        $this->ads[0]->addPicture($this->pictures[2]);
        $this->ads[0]->addPicture($this->pictures[3]);

        $this->ads[1]->addPicture($this->pictures[4]);
        $this->ads[1]->addPicture($this->pictures[5]);
        $this->ads[1]->addPicture($this->pictures[6]);

        $this->ads[2]->addPicture($this->pictures[0]);
        $this->ads[2]->addPicture($this->pictures[1]);
    }

    // ---------------------------- Methods -------------------------------------------
    /**
     * Returns a single instance of this class
     * 
     * @return InFileSystemPersistence Instance of this class
     */
    public static function getInstance(): InFileSystemPersistence {
        if (!isset(self::$instance)){
            self::$instance = new InFileSystemPersistence();
        }
        return self::$instance;
    }

    /**
     * Method that updates ads in database
     * 
     * @param array Ad array to update
     * 
     * @return bool If it works properly returns true, false if not
     */
    public function updateAds(array $adsUpdated): bool{
        try{
            $this->ads = $adsUpdated;
        }
        catch(Exception $e){
            return false;
        }
        return true;
    }

    /**
     * Return irrelevant orders
     * 
     * @return array Ad array
     */
    public function getIrrelevantAds(): array{
        $ads = [];
        foreach($this->ads as $ad){
            if(!is_null($ad->getIrrelevantSince())){
                array_push($ads, $ad);
            }
        }
        return $ads;
    }

     /**
     * Return the ads in server
     * 
     * @return array Ad array
     */
    public function getAllAds(): array{
        return $this->ads;
    }
}
