<?php

/*
* 582-11B-MA Exercice 3
* Etudiante Mélisandre Schofield : 2395207
*/

/*set cookies before html tags--we reset them later*/
$cookieMysteryString = "cookieMystStr";
$cookieMysteryStringValue = "string";
setcookie($cookieMysteryString, $cookieMysteryStringValue);

$cookieGuessesLeft = "cookieGuessesLeft";
$cookieGuessesLeftValue = 100;
setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);

$cookieAlphabetPool = "cookieAlphabetPool";
$cookieAlphabetPoolValue = "-";
setcookie($cookieAlphabetPool, $cookieAlphabetPoolValue);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta author="melisandre schofield">
    <title>hangman-o-gram</title>
    <style>
        h1{
            font-size: 25px; 
            font-family: monospace;
        }
        div{
           font-size: 35px; 
           font-family: monospace;
           letter-spacing: 5px;   
           word-spacing: 10px;
        }
        .message{
            font-size: 15px;
            letter-spacing: 3px;
        }
        label{
            font-size: 15px;
            letter-spacing: 3px;
        }
        button{
            font-size: 40px;
            font-family:monospace;
            letter-spacing: 3px;
        }
        .emptyBoard{
            font-size: 35px; 
            font-family: monospace;
            letter-spacing: 5px;  
        }
        .endBoard{
            color: lightgrey;
        }
        .warning{
            color: hotpink;
            font-size: 50px;

        }
        .pastGuesses{
            position: fixed;
            bottom: 0;
            font-size: 20px;
        }

    </style>
</head>
<body>
    <header>
        <h1>Hangman-o-gram</h1>
    </header>
<main>
<?php





/***********  INITIALIZE VARIABLES  ****************/



//The answer string
$answerStr = "De-Coding (and coding) are both fun!";

//Number of guesses allowed
$guessesLeft = 7;

//The mystery sentence updated with correct guesses
$mysteryStr = "";

//associative array, initialized while setting the board
//KEYS- all lower-case alphabetic chars
//VALUES unguessed:"unguessed", bad guess: "badGuess", correct guess: "goodGuess"
$alphabetPool = array();





/************  INITIALIZE THE GAME  ***************/

//This calls the SetBoard and the SetButtons functions
//once these are called, all further code is executed on POST

function initializeGame($ans, $mys, $gLeft, $alphaP){
    
    $mys = setBoard($ans, $mys, $gLeft);
    $alphaP = setButtons($ans, $gLeft, $alphaP);

    $returnArr = array($mys, $alphaP);
    return $returnArr;
}


$returnArr = array(initializeGame($answerStr, $mysteryStr, $guessesLeft, $alphabetPool));
$mysteryStr = $returnArr[0][0];
$alphabetPool = $returnArr[0][1];











/**************  SET THE BOARD  ****************/

//Convert the answer string into a display string. 
//Initialize the string with an underscore for each letter to be guessed.
//Retain spaces between the words, as well as punctuation in the display.
//Update your cookies

function setBoard($ans, $mys, $gLeft){
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

    $cookieMysteryString = "cookieMystStr";
    $cookieMysteryStringValue = $mys;
    setcookie($cookieMysteryString, $cookieMysteryStringValue);

    $cookieGuessesLeft = "cookieGuessesLeft";
    $cookieGuessesLeftValue = $gLeft;
    setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);


    echo "<div class='emptyBoard firstLoad'>".$mys."</div>";
    return $mys;
}

//$mysteryStr = setBoard($answerStr, $mysteryStr, $guessesLeft);













/*******************  SET THE BUTTONS *****************/



//Create buttons for each letter of the alphabet
//Initialize alphabetPool, an associative array to track guesses.
//values in alphabetPool will be: "unguessed", "goodGuess", or "badGuess"
//EVENTUALLY: each button's class will be updated to it's id's alphabetPool value

function setButtons($ans, $gLeft, $alphaP){

    echo "<section class='alphaButtons'>";
    /* Use htmlspecialchars to prevent XSS attacks (advice and the following line from chat gpt)*/
    $action_url = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES);
    echo "<form name='form1' method='post' action='" .$action_url. "'>";

    foreach (range('a', 'z') as $letter) {
        $alphaP[$letter] = "unguessed";
        echo "<button class=".$alphaP[$letter]." id=".$letter." name='character' value=".$letter.">".$letter."</button>";
    }

    echo "</form>";
    echo "</section>";

    $cookieAlphabetPool = "cookieAlphabetPool";
    $cookieAlphabetPoolValue = cookiefy($alphaP);
    setcookie($cookieAlphabetPool, $cookieAlphabetPoolValue);

    return $alphaP;
}

//$alphabetPool = setButtons($answerStr, $guessesLeft, $alphabetPool);



















/************CHECK CHARACTER**************/


// On button press, its value ($character) is sent by POST.
// This function submits $character to a number of conditions,
// to determine whether the $character is in the answerString
// and whether the player wins or looses.



function checkChar($char, $ans, $mys, &$gLeft, $alphaP){
    //check if the player has any guesses left
    if ($gLeft <=0){
        echo "<div class='endBoard'>".$mys."</div>";
        echo "<div class='message'>We appreciate that you want to keep playing, but you must accept your loss.</div>";
    }


    //check if the value was submitted previously (but also ensures the player has not won)
    elseif ($alphaP[$char] !== "unguessed" && $ans != $mys){
        echo "<div class='board'>".$mys."</div>";
        echo "<div class='message'>You already guessed  ".$char.". Guesses Left: (".$gLeft.")</div>";
    }


    //prevent a resubmission with no value (like in refreshing the browser)
    elseif ($char == ""){
        echo "<div class='board'>".$mys."</div>";
        echo "<div class='message'>No character submitted. Guesses Left: (".$gLeft.")</div>";
    }

    //Compare the guessed character to the answer string (with a loop)
    //Add wining guesses to the sentence display and the alphabetPool array (with "goodGuess" as a value)
    else{
        $goodGuessFlag = false;
        for($i = 0; $i < strlen($ans); $i++){
            if($char == iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', strtolower($ans[$i]))){
                $mys[$i] = $ans[$i];
                $goodGuessFlag = true;
                $alphaP[$char] = "goodGuess";
            }
        }  
        
        //check if the player has won the game
        if ($ans == $mys){
            echo "<div class='endBoard'>".$mys."</div>";
            echo "<div class='endMessage'>Congratulations! You win!</div>"; 
        }

        //messaging if it was a good guess
        elseif($goodGuessFlag){
            echo "<div class='message'>Yes, for: ".$char."!  Guesses Left: (".$gLeft.")</div>";
            $goodGuessFlag = false;  
            echo "<div class='board'>".$mys."</div>";     
        }

        //if the guess was wrong
        //set that character's value (in alphabetPool) to "badGuess"
        //decrease the number of guesses left
        //send a message with the number of guesses left
        //show the board (greyed out if there are no guesses left)
        //if there are no guesses left, display a YOU LOSE message

        else{
            $alphaP[$char] = "badGuess";
            $gLeft --;
            echo "<div class='message'>No ".$char."'s Guesses left: (".$gLeft.")</div>";
            if($gLeft >0){
                echo "<div class='board'>".$mys."</div>";
            }
            else{
                echo "<div class='endBoard'>".$mys."</div>";
                echo "<div class='endMessage'>Unfortunately, you've lost.</div>";
            }
        }  
    }

    //update your cookies
    $cookieMysteryString = "cookieMystStr";
    $cookieMysteryStringValue = $mys;
    setcookie($cookieMysteryString, $cookieMysteryStringValue);

    $cookieGuessesLeft = "cookieGuessesLeft";
    $cookieGuessesLeftValue = $gLeft;
    setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);

    $cookieAlphabetPool = "cookieAlphabetPool";
    $cookieAlphabetPoolValue = cookiefy($alphaP);
    setcookie($cookieAlphabetPool, $cookieAlphabetPoolValue);
    
    //call the timer
    timedMessage($gLeft);

    //return the updated $mysteryStr and $alphabetPool:
    $returnArr = array($mys, $alphaP);
    return $returnArr;
}















/************  COOKIEFY (for $alphabetPool)  ******************/



//COOKIEFY takes alphabetPool array, and makes a string 
//good guesses are stored on the left side of a dividing symbol (/)
//bad guesses are stored on the right side of the symbol

//UNCOOKIEFY reverses the process, recreating the associative array.

function cookiefy($alphaP){
    $cookiefied = "/";
    foreach ($alphaP as $char => $value){
        switch ($value){
            case "goodGuess":
                $cookiefied = $char.$cookiefied;
                break;
            case "badGuess":
                $cookiefied .= $char;
                break;
            default:
                break;
        }
    }
    return $cookiefied;
}




/************  UNCOOKIEFY (for $alphabetPool)  ******************/


function uncookiefy($cookie){
    $alphaP = array();
    foreach (range('a', 'z') as $letter) {
        $alphaP[$letter] = "unguessed";
    }
    $status = "goodGuess";
    for($i = 0; $i < strlen($cookie) ; $i++){
        switch ($status){
            case "goodGuess":
                if ($cookie[$i] == "/"){
                    $status = "badGuess";   
                }
                else{
                    $alphaP[$cookie[$i]] = "goodGuess";
                }
                break;

            case "badGuess":
                $alphaP[$cookie[$i]] = "badGuess";
                break;

            default:
                echo "<div class='errorMessage'>error: uncookiefy switch case is falling through to default</div>";
                break;      
        }
    }
    return $alphaP;
}

























/**********TIMER AND WHILE LOOP**********/

//this timer doesn't work as intended, because, the page does not get loaded in
//parts, rather, the entire script must be executed, and then the page can load.
//Also, anything out here in the script does not get called if its  conditions
//are met at a time other than the first loading of the page. So I've wrapped  
//it in a function that gets called from the checkChar function, which is why
//when a player has 5 guesses left, the computer seems particularly slow at loading.
//and if message are echoed at the start and end of the timer, they will appear 
//on the screen at once. The funny thing is that the message: "hurry up 
//and guess" is displayed after the cumputer has spent a particularly long time 
//"thinking"/lagging and not quite responding to user input. This will be called
//multiple times, if the player has five guesses left over multiple turns. 

function timedMessage($gLeft){
    $firstTime = true;
    $timer = 0;
    $startTime = 0;
    While($timer < 3 && $gLeft == 5){
        if ($firstTime){
            $startTime = time();
            $firstTime = false;
            //echo "<div class='warning'>this timer started!</div>";
        }
        $timer = time() - $startTime;
        if ($timer > 2){
            //echo "<br>Timer2 is equal to: ".$timer;
            echo "<div class='warning'>hurry up and guess!</div>";
            $timer = 3;
        }
    }
}

















/***************  TESTING THE CODE FROM HERE  *************/

/*  checkChar("a", $answerStr, $mysteryStr, $guessesLeft, $alphabetPool);
    checkChar("", $answerStr, $mysteryStr, $guessesLeft, $alphabetPool);
    checkChar("a", $answerStr, $mysteryStr, $guessesLeft, $alphabetPool);
    checkChar("z", $answerStr, $mysteryStr, $guessesLeft, $alphabetPool);
 */





















/************  POST IMPLEMENTATION  ************/


    
    if( isset($_POST['character'])) {
        $character = $_POST['character'];
        $mysteryStr =  $_COOKIE[$cookieMysteryString]; 
        $guessesLeft =  $_COOKIE[$cookieGuessesLeft];
        $alphabetPool = uncookiefy($_COOKIE[$cookieAlphabetPool]);

        //check the input, and do all the things
        $returnArr = array(checkChar($character, $answerStr, $mysteryStr, $guessesLeft, $alphabetPool));
        $mysteryStr = $returnArr[0][0];
        $alphabetPool = $returnArr[0][1];
        echo "<div class='pastGuesses'>Correct guesses  --> ".cookiefy($alphabetPool)." <--  Incorrect guesses</div>";
    }  




 
?>
</main>   
</body>
</html>