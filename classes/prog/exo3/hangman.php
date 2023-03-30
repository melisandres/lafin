<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        div{
           font-size: 35px; 
           font-family: monospace;
           letter-spacing: 5px;   
        }
        .message{
            font-size: 15px;
            letter-spacing: 3px;
        }
    </style>
</head>
<body>
<?php

$ansStr = "Don't be a hero.";
$guessesLeft = 6;
$guesses = array("t", "e", "s", "s", "n", "y" );
$mysteryStr = "";

//the answer is stored in an answer string. Another string displays the mystery sentence to the player. This string will be updated to show correct guesses. But first, this string needs to be initialized, showing spaces between words as well as the punctuation, while showing just a line for each character.  

function setBoard($ans, $mys){
    for($i =0; $i < strlen($ans); $i++){
        if ($ans[$i] == " "){
            $mys .=" ";
        }
        elseif(ctype_punct( $ans[$i] )){
            $mys .="$ans[$i]";
        }
        else{
            $mys .="_";
        }
    }
    return $mys;
}

$mysteryStr = setBoard($ansStr, $mysteryStr);


//show the board
echo "<div>".$mysteryStr."</div>";


//a function to check one character (would be the best way to do it with user input)
function checkChar($guess, $ansKey, $disp, &$gLeft){
     if ($gLeft <=0){
         echo "<div class='message'>out of guesses</div>";
         return;
     }
    for($i = 0; $i < strlen($ansKey); $i++)
        if(!strcasecmp($guess, $ansKey[$i])){
            $disp[$i] = $ansKey[$i];
        }
    $gLeft--;
    gMessage($gLeft);
    return $disp;
}

$mysteryStr = checkChar("c", $ansStr, $mysteryStr, $guessesLeft);

echo "<div>".$mysteryStr."</div>";
echo $guessesLeft;

//a function to check an array of guesses, and run through them. 
function checkChars($ans, $gue, $mys, &$gLeft){
    for($i = 0; $i < count($gue); $i++){
        if($gLeft <=0){
            echo "<div class='message'>out of guesses</div>";
            return;
        }
        for($j = 0; $j < strlen($ans); $j++){
            if(!strcasecmp($ans[$j], $gue[$i])){
                $mys[$j] = $ans[$j];
            }
        }
        echo "<div>$mys</div>";
        gMessage($gLeft);
    }
    return $mys;
}

$mysteryStr = checkChars($ansStr, $guesses, $mysteryStr, $guessesLeft);


//show the board
echo "<div>".$mysteryStr."</div>";


//make a full guess
function guess($str, $ans){
    if (strlen($str)!= strlen($ans)){
        echo "<div class='message'> error: you have not entered the right number of characters.</div>";
    }
    elseif ($str == $ans){
        echo "<div class='message'>".$ans."</br> YES, you got it!</div>";
    }
    else{
        echo "<div class='message'> NOPE, that is not the answer!</div>";
    }
}


$fullGuess = "is this the sentence?";
guess($fullGuess, $ansStr);
guess($ansStr, $ansStr);

//this function is called every time a guess is made... but it should only be called when a guess is made, and no match is found. Silly me. I need a nice message, when a match is found, and I could reiterate the guesses left. This means I need to send in a boolean to the function, that will handle whether I am taking out a guess, yes or no. And then I can send a generic success message, coupled with a... "still n guesses left." Technically a hangman is 6 guesses.  

//a function that manages the guesses: decreasing them each time one is used, displaying the number left, and eventually, displaying the hanged man. It is called from the checkChar and checkChars functions when a guess is made.  
function gMessage(&$gLeft){
    $gLeft--;
    if ($gLeft >4){
        echo "<div class='message'>Don't worry. You have many (".$gLeft.") guesses left</div>";
        return;
    }
    switch ($gLeft){
        case 4:
            echo "<div class='message'>You have ".$gLeft." guesses left</div>";
            break;
        case 3:
            echo "<div class='message'>Woop... choose wisely, only ".$gLeft." guesses left</div>";
            break;
        case 2:
            echo "<div class='message'>Watch out, you have ".$gLeft." guesses left</div>";
            break;
        case 1:
            echo "<div class='message'>DANGER, you have ".$gLeft." guess left</div>";
            break;
        case 0:
            echo "<div class='message'>Too bad. You have no guesses left</div>";
            break;
        default:
            echo "<div class='message'>something's not right here. error, error, error</div>";
            break;
    }

}

//do not accept any keys that are not alphabetic (but only in the character guesses... not in the full sentence guess)
?>
    
</body>
</html>