<?php
/*set cookies before html tags--we can reset later*/
$cookieMysteryString = "cookieMystStr";
$cookieMysteryStringValue = "string";
setcookie($cookieMysteryString, $cookieMysteryStringValue);

$cookieGuessesLeft = "cookieGuessesLeft";
$cookieGuessesLeftValue = 100;
setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);

$cookieAlphabetPool = "cookieAlphabetPool";
$cookieAlphabetPoolValue = "";
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
            font-size: 25px;
            letter-spacing: 3px;
        }
        .emptyBoard{
            font-size: 35px; 
            font-family: monospace;
            letter-spacing: 5px;  
        }
        .endBoard{
            color: grey;
        }
        /* .unguessed{
           color: black;
        }
        .goodGuess{
            background-color:green;
        }
        .badGuess{
            background-color: red;
        }

        .firstLoad{
            /*place code here to make it invisible after */
        } */

    </style>
</head>
<body>
    <h1>Hangman-o-gram</h1>
<?php
/*
* 582-11B-MA Exercice 3
* Etudiante Mélisandre Schofield : 2395207
*/




/***********  INITIALIZE VARIABLES  ****************/





/********  testing variables  *********************/

$guesses = array("t", "z", "o", "s", "n", /*"y", "a", "e", "m", "u", "l", "r"*/);



/*********  game variables  *********************/

//The answer string
$answerStr = "Everything is comming up Roses!";

//Number of guesses allowed
$guessesLeft = 7;

//The mystery sentence updated with correct guesses
$mysteryStr = "";

//associative array, initialized while setting the board
//KEYS- all lower-case alphabetic chars
//VALUES unguessed:"unguessed", bad guess: "badGuess", correct guess: "goodGuess"
$alphabetPool = array();



















/***********  SET THE BOARD  ****************/

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


    echo "<div class='emptyBoard firstLoad'>".$mys."</div> board initialization";
    return $mys;
}

$mysteryStr = setBoard($answerStr, $mysteryStr, $guessesLeft);













/*******************  SET THE BUTTONS *****************/



//Create buttons for each letter of the alphabet
//Initialize alphabetPool, an associative array to track guesses.
//values in alphabetPool will be: "unguessed", "goodGuess", or "badGuess"
//EVENTUALLY: each button's class will be updated to it's id's alphabetPool value

function setButtons($ans, $gLeft, $alphaP){

    echo "<section class='firstLoad alphaButtons'>";
    /* Use htmlspecialchars to prevent XSS attacks (advice and the following line from chat gpt)*/
    $action_url = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES);
    echo '<form name="form1" method="post" action="' .$action_url. '">';

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

$alphabetPool = setButtons($answerStr, $guessesLeft, $alphabetPool);



/*THIS RESET BUTTONS FUNCTION IS SOMEHOW BREAKING THE SCRIPT*/

// function resetButtons($ans, $gLeft, $alphaP){

//     echo "<section class='alphaButtons'>";
//     /* Use htmlspecialchars to prevent XSS attacks (advice and the following line from chat gpt)*/
//     $action_url = htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES);
//     echo '<form name="form1" method="post" action="'.$action_url.'">';
//     echo "<label for='character'>you have (".$gLeft.") guesses left:<br></label>";

//     foreach (range('a', 'z') as $letter) {
//         echo "<button class=".$alphaP[$letter]." id=".$letter." name='character' value=".$letter.">".$letter."</button>";
//     }
//     echo "</form>";
//     echo "</section>";

//     $cookieAlphabetPool = "cookieAlphabetPool";
//     $cookieAlphabetPoolValue = cookiefy($alphaP);
//     setcookie($cookieAlphabetPool, $cookieAlphabetPoolValue);

//     return $alphaP;
// }












/************CHECK CHARACTER**************/


//1. Does the player have only one guess left? message: Unfortunately, you lost. no board update,
//2. Has this character already been guessed? message: You already guessed that. 
//3. Is the input null (ie a page refresh with no entry) Error message. 
//4. Is this character within the mystery string? message: Good guess! update board, show # of guesses left.
//5. None of the above? message: bad guess,  show # of guesses left. 



function checkChar($char, $ans, $mys, &$gLeft, $alphaP){
    //check if the player has any guesses left
    if ($gLeft <=0){
        echo "<div class='message'>Out of guesses</div>";
        return;
    }

    //check if the value submitted is an alphabetical character 
    //prevent  resubmits with no value, or with the previous value (like on refreshing the page)
    elseif ($alphaP[$char] !== "unguessed"){
        echo "<div>".$mys."</div>";
        echo "<div class='message'>You already guessed  ".$char.". Guesses Left: (".$gLeft.")</div>";
    }

    elseif ($char == ""){
        echo "<div>".$mys."</div>";
        echo "<div class='message'>No character submitted. Guesses Left: (".$gLeft.")</div>";
    }

    //loop through the answer string, compare with the guess
    //add wining guesses to the sentence display, to the alphabetPool, and to the cookieAlphabetPool
    
    else{
        $goodGuessFlag = false;
        for($i = 0; $i < strlen($ans); $i++){
            if($char == iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', strtolower($ans[$i]))){
                $mys[$i] = $ans[$i];
                $goodGuessFlag = true;
                $alphaP[$char] = "goodGuess";
            }
        }   


        //messaging if the guess was right. This needs to happen out of the loop, because there can be more than one character match
        if($goodGuessFlag){
            echo "<div class='message'>Yes, for: ".$char."!  Guesses Left: (".$gLeft.")</div>";
            $goodGuessFlag = false;  
            //show the updated display
            echo "<div>".$mys."</div>";     
        }

        //call a function that manages bad guesses and 
        else{
            $alphaP[$char] = "badGuess";
            $gLeft --;
            echo "<div class='message'>No ".$char."'s Guesses left: (".$gLeft.")</div>";
            if($gLeft >0){
                echo "<div>".$mys."</div>";
            }
            else{
                echo "<div class='endBoard'>".$mys."</div>";
                echo "<div>Unfortunately, you lost this round.</div>";
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

    //return the updated $mysteryStr and $alphabetPool:
    $returnArr = [$mys, $alphaP];
    return $returnArr;
}










/************  COOKIEFY & UNCOOKIEFY (for $alphabetPool)  ******************/


function cookiefy($alphaP){
    $cookiefied = "-";
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


function uncookiefy($cookie){
    $alphaP = array();
    foreach (range('a', 'z') as $letter) {
        $alphaP[$letter] = "unguessed";
    }
    $status = "goodGuess";
    for($i = 0; $i < strlen($cookie) ; $i++){
        switch ($status){
            case "goodGuess":
                if ($cookie[$i] == "-"){
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
                echo "error: uncookiefy switch case is falling through to default";
                break;      
        }
    }
    return $alphaP;
}


// $var = uncookiefy("abc-zxy");
// $var = var_dump($var);
// echo "TEST UNCOOKIEFY WITH THE STRING ABC-XZY ".$var."WHY IS THE VAR DUMP APPEARING BEFORE THIS MESSAGE?";

















/****************CHECK CHARACTER ARRAY****************/

//a function that does the same as the earlier function, but with an array of guesses. 
function checkChars($ans, $chars, $mys, &$gLeft, $alphaP){
    for($i = 0; $i < count($chars); $i++){
        if($gLeft <=0){
            echo "<div class='message'>out of guesses chars</div>";
            return;
        }
        $goodGuessFlag = false;
        for($j = 0; $j < strlen($ans); $j++){
            if(!strcasecmp($ans[$j], $chars[$i])){
                $mys[$j] = $ans[$j];
                $goodGuessFlag = true;
            }
        }
        echo "<div>$mys</div>";
        if($goodGuessFlag){
            echo "<div class='message'>Yes, for: ".$chars[$i]."!</div>";   
            $goodGuessFlag = false;    
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
// function gMessage(&$gLeft, $char){
//     $gLeft--;
//     //$cookieGuessesLeft = "cookieGuessesLeft";
//     //$cookieGuessesLeftValue = $gLeft;
//     //setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);

//     if (strlen($char)==1){
//         echo "<div class='message'>No ".$char."'s Guesses left: (".$gLeft.")</div>";
//     }
//     else {
//         echo "<div class='message'> Bad guess: ".$char." Guesses left: (".$gLeft.")</div>";
//     }
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

// }
















/**********TIMER AND WHILE LOOP**********/


//
$timer = 0;
While($timer < 5 && $guessesLeft == 0){
    $startTime = time();
    $timer += time() -$startTime;
    if (timer == 4.5){
        echo "hurry up and guess!";
        $timer = 5;
    }
}

















/********TESTING THE FUNCTTIONS*************/

//Let's show the empty board
//echo "<div>".$mysteryStr."</div>";


//test the function with a character
//$mysteryStr = checkChar("d", $answerStr, $mysteryStr, $guessesLeft, $alphabetPool);


//test the function with an array of characters
//$mysteryStr = checkChars($answerStr, $guesses, $mysteryStr, $guessesLeft, $alphabetPool);
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
        $alphabetPool = uncookiefy($_COOKIE[$cookieAlphabetPool]);

        //check the input, and do all the things
        $returnArr = checkChar($character, $answerStr, $mysteryStr, $guessesLeft, $alphabetPool);
        $mysteryStr = $returnArr[0];
        $alphabetPool = $returnArr[1];
        echo "Correct guesses on this side -->".cookiefy($alphabetPool)."<-- incorrect guesses on this side";
    }   



 
?>
<main>
    <section class = "board">

    </section>

    <section class = "guess">
        <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="character">Enter one character:</label>
            <input type="text" id="character" name="character" maxlength="1"required>
            <button type="submit">Submit</button>
        </form> -->


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