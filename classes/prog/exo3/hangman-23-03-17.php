<?php
/*set cookies before html tags--we can reset later*/
$cookieMysteryString = "cookieMystStr";
$cookieMysteryStringValue = "string";
setcookie($cookieMysteryString, $cookieMysteryStringValue);

$cookieGuessesLeft = "cookieGuessesLeft";
$cookieGuessesLeftValue = 100;
setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);

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
        }
        .message{
            font-size: 15px;
            letter-spacing: 3px;
        }
    </style>
</head>
<body>
    <h1>Hangman-o-gram</h1>
<?php
/*
* 582-11B-MA Exercice 3
* Etudiante Mélisandre Schofield : 2395207
*/




/***********INITIALIZE VARIABLES****************/





/********testing variables*********************/

$guesses = array("t", "z", "o", "s", "n", /*"y", "a", "e", "m", "u", "l", "r"*/);



/*********game variables*********************/

//The answer string
$answerStr = "Wait, don't do it!";

//Number of guesses allowed
$guessesLeft = 7;

//The mystery sentence updated with correct guesses
$mysteryStr = "";

//Still unusued associative array
//will be initialized while setting the board
//KEYS- all lower-case alphabetic chars
//VALUES unguessed:0, bad guess:1, correct guess:2
$badAnswers = array();


















/***********SET THE BOARD****************/

//The first thing to do, is to convert the answer string into a display string. This string needs to be initialized, showing an underscore for each letter to be guessed, while retaining spaces between the words, as well as the punctuation.  

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

    echo "<div>".$mys."</div> board initialization";
    return $mys;
}

$mysteryStr = setBoard($answerStr, $mysteryStr, $guessesLeft);




















/************CHECK CHARACTER**************/

//A function to check just one character (would be the best way to do it with user input)
//First check if the player has any guesses left (or are they "game over"?)
//Set winFlag to false. Switch flag to true if the guess was good.
//Check to see if that flag has been set to true. If so, give a congratulations message.
//Else, trigger the guess manager (a function that handles messaging and guess decrementation)


function checkChar($char, $ans, $mys, &$gLeft){
    //check if the player has any guesses left
     if ($gLeft <=0){
        echo "<div class='message'>out of guesses</div>";
        return;
     }
     //loop through the answer string, compare with the guess
     //add wining guesses to the display
    $winFlag = false;
    for($i = 0; $i < strlen($ans); $i++){
        if(!strcasecmp($char, $ans[$i])){
            $mys[$i] = $ans[$i];
            $winFlag = true;
        }
    }
    //show the updated display
    echo "<div>".$mys."</div>called by checkChar";

    //messaging if the guess was right
    if($winFlag){
        echo "<div class='message'>Yes, for: ".$char."!</div>";
        $winFlag = false;       
    }

    //call a function that manages bad guesses and 
    else{
        gMessage($gLeft, $char);
    }   

    //return the updated display to store it in $mysteryStr
    $cookieMysteryString = "cookieMystStr";
    $cookieMysteryStringValue = $mys;
    setcookie($cookieMysteryString, $cookieMysteryStringValue);

    $cookieGuessesLeft = "cookieGuessesLeft";
    $cookieGuessesLeftValue = $gLeft;
    setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);

    return $mys;
}


















/****************CHECK CHARACTER ARRAY****************/

//a function that does the same as the earlier function, but with an array of guesses. 
function checkChars($ans, $chars, $mys, &$gLeft){
    for($i = 0; $i < count($chars); $i++){
        if($gLeft <=0){
            echo "<div class='message'>out of guesses chars</div>";
            return;
        }
        $winFlag = false;
        for($j = 0; $j < strlen($ans); $j++){
            if(!strcasecmp($ans[$j], $chars[$i])){
                $mys[$j] = $ans[$j];
                $winFlag = true;
            }
        }
        echo "<div>$mys</div>";
        if($winFlag){
            echo "<div class='message'>Yes, for: ".$chars[$i]."!</div>";   
            $winFlag = false;    
        }
        else{
            gMessage($gLeft, $chars[$i]);
        }   
    }
    $cookieMysteryString = "cookieMystStr";
    $cookieMysteryStringValue = $mys;
    setcookie($cookieMysteryString, $cookieMysteryStringValue);
    return $mys;
}





















/**************CHECK A FULL SENTENCE**************/

//make a full guess. A function that allows a player to guess the whole sentence.
function guess($str, $ans, &$gLeft){
    if($gLeft <=0){
        echo "<div class='message'>out of guesses</div>";
        return;
    }
    elseif (strlen($str)!= strlen($ans)){
        echo "<div class='message'> error: you have not entered the right number of characters.</div>";
    }
    elseif ($str == $ans){
        echo "<div class='message'>You entered: '".$ans."'.... YES, you got it!</div>";
    }
    else{
        gMessage($gLeft, $str);
    }
}



















/***************BAD GUESS MANAGEMENT*************/ 

//a function that manages the guesses: decreasing them each time one is used, displaying the number left, and eventually, displaying the hanged man. It is called from the checkChar and checkChars functions when a guess is made.  
function gMessage(&$gLeft, $char){
    $gLeft--;
    $cookieGuessesLeft = "cookieGuessesLeft";
    $cookieGuessesLeftValue = $gLeft;
    setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);

    if (strlen($char)==1){
        echo "<div class='message'>No ".$char."'s Guesses left: (".$gLeft.")</div>";
    }
    else {
        echo "<div class='message'> Bad guess: ".$char." Guesses left: (".$gLeft.")</div>";
    }
    /*add a line here that will grab an image from an array of images to display the hanged man with $gLeft as the index of this array */
    /*switch ($gLeft){
        case 4:
            echo "<div class='message'>No ".$guess."'s Guesses left: (".$gLeft.")</div>";
            break;
        case 3:
            echo "<div class='message'>No ".$guess."'s Guesses left: (".$gLeft.")</div>";
            break;
        case 2:
            echo "<div class='message'>No ".$guess."'s Guesses left: (".$gLeft.")</div>";
            break;
        case 1:
            echo "<div class='message'>No ".$guess."'s Guesses left: (".$gLeft.")</div>";
            break;
        case 0:
            echo "<div class='message'>No ".$guess."'s Guesses left: (".$gLeft.")</div>";
            break;
        default:
            echo "<div class='message'>something's not right here. error, error, error</div>";
            break;
    }*/

}
















/**********TIMER AND WHILE LOOP**********/


//
$timer = 0;
While($timer < 1 && $guessesLeft == 2){
    $base = time();
    $timer += time() -$base;
    echo "hurry up and guess!";
    $timer = 1;
}

















/********TESTING THE FUNCTTIONS*************/

//Let's show the empty board
//echo "<div>".$mysteryStr."</div>";


//test the function with a character
//$mysteryStr = checkChar("d", $answerStr, $mysteryStr, $guessesLeft);


//test the function with an array of characters
//$mysteryStr = checkChars($answerStr, $guesses, $mysteryStr, $guessesLeft);
//echo "<div>".$guessesLeft."</div>";

//$fullGuess = "is this the sentence?";
//guess($fullGuess, $ansStr, $guessesLeft);
//$fullGuess = "Halt, don't do it!";
//guess($fullGuess, $ansStr, $guessesLeft);
//guess($ansStr, $ansStr, $guessesLeft);














/************POST IMPLEMENTATION************/


    
    if( isset($_POST['character'])) {
        $character = $_POST['character'];
        $mysteryStr =  $_COOKIE[$cookieMysteryString]; 
        $guessesLeft =  $_COOKIE[$cookieGuessesLeft];
        $mysteryStr = checkChar($character, $answerStr, $mysteryStr, $guessesLeft);
    }   

    //$guessesLeft = $_POST['guessesLeft'];
    
    //print_r(checkChar($character, $ansStr,  $_SESSION['mysteryStr'], $guessesLeft));
    //$mysteryStr = checkChar($character, $ansStr, $mysteryStr, $guessesLeft);
 // }

 
?>
<main>
    <section class = "board">

    </section>

    <section class = "guess">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="character">Enter one character:</label>
        <input type="text" id="character" name="character" >
        <button type="submit">Submit</button>
    </form>


    </section>

    <section class = "message">

    </section>

    <section class = "hangman">

    </section>

    <section class = "badLetters">

    </section>
</main>
    
</body>
</html>