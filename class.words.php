<?php
class Words {
    private $dictionaryOfWords;

    function __construct($wordLength = 0) {
        $words = file("words.txt");
        $this->dictionaryOfWords = [];
        foreach ($words as $word) {
            $word = trim($word);
            // if no word $wordLength was specified (zero), add the word -or-
            // if a $wordLength was specified, add if the word is the same length
            if ($wordLength == 0 || strlen($word) == $wordLength) {
                $this->dictionaryOfWords[] = $word;
            }
        }
    }

    // getWordsFromLetterPool returns words from the $dictionaryOfWords if the word can be created from the specified $letterPool.
    function getWordsFromLetterPool($letterPool) {
        if (strlen($letterPool) < 3) {
            echo "Must provide at least 3 letters.\n";
            return [];
        }

        $results = [];

        foreach ($this->dictionaryOfWords as $word) {
            if (!$this->letterPoolCanCreateWord($letterPool, $word)) {
                continue;
            }

            // results should be grouped by word length
            $results[] = $word;
        
            // stop if there are too many results
            if (count($results) >= 10000) {
                break;
            }
        }

        return $results;
    }

    // letterPoolCanCreateWord returns true if all the letters in $word can be found in $letterPool.
    function letterPoolCanCreateWord($letterPool, $word) {
        if (strlen($word) < 3) {
            return false;
        }

        // iterate through each letter in the $word
        for ($position = 0; $position < strlen($word); $position++) {
            // find the first position of the desired letter in the $letterPool
            $letterPosition = strpos($letterPool, $word[$position]);
            // if the letter wasn't found in the $letterPool, return false...
            // ... the word can't be made from the given letters
            if ($letterPosition === false) {
                return false;
            }
            // remove the letter (at the specific position) from the letter pool
            $letterPool = substr_replace($letterPool, '', $letterPosition,  1);
        }

        return true;
    }
    
    // letterFrequency returns an array of the frequency of each letter in the dictionary of words.
    function letterFrequency() {
        $letterFrequency = [];
        
        // this loop initializes the empty result structure
        foreach (range('a', 'z') as $letter) {
            $letterFrequency[$letter] = 0;
        }
        
        // this loop iterates over the words in the $dictionaryOfWords
        foreach ($this->dictionaryOfWords as $word) {
            for ($position = 0; $position < strlen($word); $position++) {
                $letter = $word[$position];
                $letterFrequency[$letter]++;
            }
        }

        return $letterFrequency;
    }

    // wordLengthFrequency returns an array of the frequency of each word length in the $dictionaryOfWords.
    function wordLengthFrequency() {
        $wordLengthFrequency = [];

        foreach ($this->dictionaryOfWords as $word) {
            $letterCount = strlen($word);
            if (!array_key_exists($letterCount, $wordLengthFrequency)) {
                $wordLengthFrequency[$letterCount] = 0;
            }
            $wordLengthFrequency[$letterCount]++;
        }
        ksort($wordLengthFrequency);

        return $wordLengthFrequency;
    }

    // selectRandomWord returns a random word from the $dictionaryOfWords.
    function selectRandomWord() {
        $index = rand(0, sizeof($this->dictionaryOfWords) - 1);
        $randomWord = $this->dictionaryOfWords[$index];

        return $randomWord;
    }

    // guessFeedback compares the guess to the word.
    // Returns an array for each letter in the guess.
    // The array element will contain...
    // 2 if the letter is in the word in the correct place.
    // 1 if the letter is in the word, but in the wrong place.
    // 0 if the letter is not in the word.
    // Example:
    //   If $word = cello, $guess = leave
    //   Return [1, 2, 0, 0, 0]
    function guessFeedback($guess, $word) {
        $result = array_fill(0, strlen($word), 0); // [0, 0, 0, 0, 0]

        for ($w = 0; $w < strlen($word); $w++) {
            // set the result, remove the letter, continue
            if ($guess[$w] == $word[$w]) {
                $result[$w] = 2;
                $guess[$w] = "_";
                continue;
            }

            for ($g = 0; $g < strlen($guess); $g++) {
                if ($guess[$g] == $word[$w]) {
                    $result[$g] = 1;
                    $guess[$g] = "_";
                    break;
                }
            }    
        }
    
        return $result;
    }
}
