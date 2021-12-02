<?php

declare(strict_types=1);

namespace App\Domain;

use DateTimeImmutable;
use App\Domain\Picture\Picture;
use App\Domain\Typology\ITypology;

/**
 * Domain class
 */
final class Ad {

    // ----------------------------- Atributes ----------------------------------------
    private int $id;
    private ITypology $typology;
    private String $description;
    private array $pictures;
    private ?int $score = null;
    private ?DateTimeImmutable $irrelevantSince = null;

    // ---------------------------- Constructors --------------------------------------
    public function __construct(
        int $id,
        ITypology $typology,
        String $description,
        array $pictures,
        ?int $score = null,
        ?DateTimeImmutable $irrelevantSince = null,
    ) {
        $this->id = $id;
        $this->typology = $typology;
        $this->description = $description;
        $this->pictures = $pictures;
        $this->score = $score;
        $this->irrelevantSince = $irrelevantSince;
    }

    // ---------------------------- Methods -------------------------------------------
    
    #region Update Score
    /**
     * Calculates and update the new score based on three parameters:
     *   1. Quality pictures
     *   2. Description
     *   3. IsComplete
     * 
     * Additionally:
     *   1. Score can't be greater than 0 and less than 100 (0 <= score <= 100)
     *   2. Ads with score lower than 40 will be "irrelevant" and update date will be saved
     */     
    public function updateScore(): void{
        $sum = 0;
        $sum += $this->calculatePicturesScore();
        $sum += $this->calculateDescriptionScore();
        $sum += $this->calculateIfIsComplete();
        $sum = $this->checkLimits($sum);
        $this->checkIfIrrelevant($sum);

        //Set score
        $this->score = $sum;
    }

    /**
     * Sum the scores of $pictures and return the total sum. If $pictures is empty, 
     * returns -10 
     * 
     * @return int Amount to add
     */
    private function calculatePicturesScore(): int{
        $sum = 0;
        if(!empty($this->pictures)){
            foreach($this->pictures as $pic){
                $sum += $pic->getQualityScore();
            }
        }
        else{
            $sum -= 10;
        }
        return $sum;
    }

    /**
     * Sum the description score based on three points:
     *   1. It is not empty or null 
     *   2. Length and Typology 
     *   3. Contains some word from an array
     * 
     * @return int Amount to add
     */
    private function calculateDescriptionScore(): int{
        $sum = 0;
        if(!is_null($this->description) && !empty($this->description)){
            $sum += 5;
            $sum += $this->typology->getDescriptionScore($this->description);
            $sum += $this->calculateWordsArray();
        }
        return $sum;
    }

    /**
     * Add for each word in array that contains $description. Not case sensitive
     * 
     * @return int Amount to add
     */
    private function calculateWordsArray(): int{
        $wordsArray = ['Luminoso', 'Nuevo', 'Céntrico', 'Reformado', 'Ático'];
        $sum = 0;
        foreach($wordsArray as $word){
            if(str_contains(strtolower($this->description), strtolower($word))){
                $sum += 5;
            }
        }
        return $sum;
    }

    /**
     * Check if $score is out of domain limits and if not, it is modified
     * 
     * @param int Score to check
     * 
     * @return int Score modified to be within limits
     */
    private function checkLimits(int $score): int{
        if ($score > 100){
            $score = 100;
        }
        else if ($score < 0){
            $score = 0;
        }
        return $score;
    }

    /**
     * Get an amount to add if the Ad ($this) is complete. Whether it is complete, depends on 
     * each typology
     * 
     * @return int Amount to add
     */
    private function calculateIfIsComplete(): int {   
        return $this->typology->getIsCompleteScore($this);
    }

    /**
     * Check if $score is lower than 40 and if its is, save the current date
     * 
     * @param int Score to check
     */
    private function checkIfIrrelevant(int $score): void{
        if($score < 40){
            $this->irrelevantSince = new DateTimeImmutable();
        }
    } 

    #endregion

    /**
     * Add a picture to $pictures array
     * 
     * @param Picture Picture to add
     */
    public function addPicture(Picture $picture): void {
        array_push($this->pictures, $picture);
    }

    #region Gets

    /**
     * Get $description
     * 
     * @return String Description
     */
    public function getDescription(): String{
        return $this->description;
    }

    /**
     * Get $pictures
     * 
     * @return array Pictures
     */
    public function getPictures(): array{
        return $this->pictures;
    }

    /**
     * Get $irrelevantSince
     * 
     * @return DateTimeImmutable IrrelevantSince
     */
    public function getIrrelevantSince(): ?DateTimeImmutable{
        return $this->irrelevantSince;
    }
    
    #endregion
}
