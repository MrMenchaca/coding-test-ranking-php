<?php

namespace App\Domain\Typology;

use App\Domain\Ad;

/**
 * Abstract class that implements ITyplogy.
 * Define default behavior of concrete typologys.
 */
abstract class AbstractTypology implements ITypology {

    /**
     * Returns the score by typology based on the number of words in the description.
     * Defines the skeleton and the default behavior.
     * 
     * @param String Description to count words
     * 
     * @return int Score to add
     */
    public function getDescriptionScore(String $description): int{
        $wordsCount = str_word_count($description);
        $score = $this->getScoreWithWordsCount($wordsCount);
        return $score;
    }
    
    /**
     * Returns the score by typology based on the number of words in the description.
     * Method to override.
     * Defines the default behavior.
     * 
     * @param int number of words
     * 
     * @return int Score to add
     */
    protected function getScoreWithWordsCount(int $wordsCount): int{
        return 0;
    }

    /**
     * Get an amount to add if $ad is complete. Whether it is complete, depends on 
     * each concrete typology.
     * Defines the skeleton and the default behavior.
     * 
     * @param Ad Ad to check if it is complete
     * 
     * @return int Amount to add
     */
    public function getIsCompleteScore(Ad $ad): int{
        if($this->isComplete($ad)){
            return 40;
        }
        return 0;
    }

    /**
     * Get an amount to add if $ad is complete. Whether it is complete, depends on 
     * each concrete typology.
     * Defines the default behavior.
     * 
     * @param Ad Ad to check if it is complete
     * 
     * @return int Amount to add
     */
    protected function isComplete(Ad $ad): bool{
        return false;
    }
}

?>