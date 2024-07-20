#!/usr/bin/php -q
<?php
require_once "class.words.php";
require_once "class.TerminalColors.php";

define("WORD_LENGTH", 5);

// read in the word source
$wordsObject = new Words(WORD_LENGTH);

$tc = new TerminalColors();

echo "Cuorée's Word Guessing Game!\n";

// pick a word
$word = $wordsObject->selectRandomWord();
$word = strtolower($word);

for ($lcv = 0; $lcv <= 100; $lcv++) {
    // prompt user to guess the word
    $guess = readline("Guess the " . WORD_LENGTH . " letter word: ");
    $guess = strtolower($guess);
    if (strlen($guess) != WORD_LENGTH) {
        echo "Please select a " , WORD_LENGTH , " letter word.\n";
        continue;
    }

    // evaluate the word the user typed 
    $feedBack = $wordsObject->guessFeedback($guess, $word);
    for ($g = 0; $g < strlen($guess); $g++) {
        if ($feedBack[$g] == 2) {
            echo $tc->printf($guess[$g], "BLACK", "GREEN");
        } else if ($feedBack[$g] == 1) {
            echo $tc->printf($guess[$g], "BLACK", "YELLOW");
        } else if ($feedBack[$g] == 0) {
            echo $tc->printf($guess[$g], "BLACK", "RED");
        }
    }
    echo "\n";

    if ($guess == $word) {
        // if right, celebrate 
        echo "Correct!\n";
        break;
    }
}
