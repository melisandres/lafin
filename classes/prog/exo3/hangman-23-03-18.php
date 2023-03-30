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


    echo "<div class='emptyBoard firstLoad'>".$mys."</div> board initialization";
    return $mys;
}

$mysteryStr = setBoard($answerStr, $mysteryStr, $guessesLeft);















//some parts I only want to load once! these parts I can put in a while loop, initiate a variable that I stock in a cookie, and whose value I change from within the while loop, as soon as the code contained has executed once. I could also consider evenListeners--figure out what these are, and how they work. 

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

//A function to check just one character (would be the best way to do it with user input)
//First check if the player has any guesses left (or are they "game over"?)
//Set goodGuessFlag to false. Switch flag to true if the guess was good.
//Check to see if that flag has been set to true. If so, give a congratulations message.
//Else, trigger the guess manager (a function that handles messaging and guess decrementation)


function checkChar($char, $ans, $mys, &$gLeft, $alphaP){
    //check if the player has any guesses left
     if ($gLeft <=0){
        echo "<div class='message'>out of guesses</div>";
        return;
     }
     //check if the value submitted is an alphabetical character 
     //prevent  resubmits with no value, or with the previous value (like on refreshing the page)
     if ($char == "" || $alphaP[$char] !== "unguessed"){
        echo "<div class='message'>you already guessed that</div>";
        return;
     }

     //loop through the answer string, compare with the guess
     //add wining guesses to the sentence display, to the alphabetPool, and to the cookieAlphabetPool
    $goodGuessFlag = false;

    for($i = 0; $i < strlen($ans); $i++){
        if($char == iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', strtolower($ans[$i]))){
            $mys[$i] = $ans[$i];
            $goodGuessFlag = true;
            $alphaP[$char] = "goodGuess";
        }
    }
    //show the updated display
    echo "<div>".$mys."</div>";

    //messaging if the guess was right. This needs to happen out of the loop, because there can be more than one character match
    if($goodGuessFlag){
        echo "<div class='message'>Yes, for: ".$char."!</div>";
        $goodGuessFlag = false;       
    }

    //call a function that manages bad guesses and 
    else{
        $alphaP[$char] = "badGuess";
        $gLeft --;
        echo "<div class='message'>No ".$char."'s Guesses left: (".$gLeft.")</div>";
    }  
    
    //now that the $alphaP has been updated, we can update the buttons:
    //resetButtons($ans, $gLeft, $alphaP);


    //update your cookies
    $cookieMysteryString = "cookieMystStr";
    $cookieMysteryStringValue = $mys;
    setcookie($cookieMysteryString, $cookieMysteryStringValue);

    $cookieGuessesLeft = "cookieGuessesLeft";
    $cookieGuessesLeftValue = $gLeft;
    setcookie($cookieGuessesLeft, $cookieGuessesLeftValue);


    /*the value of my alphabetPool cookie is not being updated here, clearly 
    However, the values in the alphabet pool, and the values resulting from 
    the cookiefy are right*/

    //echo "this is cookiefy alpha, before passing the value to cookie: ".cookiefy($alphaP);
    //echo "this is uncookified alpha".var_dump(uncookiefy(cookiefy($alphaP)));
    $cookieAlphabetPool = "cookieAlphabetPool";
    $cookieAlphabetPoolValue = cookiefy($alphaP);
    setcookie($cookieAlphabetPool, $cookieAlphabetPoolValue);
    //echo "THIS IS COOKIE ALPHABETPOOL IN CHECK CHAR, after Passing it the value:  ".$_COOKIE[$cookieAlphabetPool]."     <br>";


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
        //here... using the previous value of $alphabetPool might bug the system. We may have to debug that? Or the initial structure will be intact? check the logic when your brain starts to work again
        $alphabetPool = uncookiefy($_COOKIE[$cookieAlphabetPool]);
        echo "this is alphacookie IN POST: ".$_COOKIE[$cookieAlphabetPool];

        //$alphabetPool = $_COOKIE[$cookieAlphabelPool];
        //echo "1this is my alphabetpool".var_dump($alphabetPool);


        $returnArr = checkChar($character, $answerStr, $mysteryStr, $guessesLeft, $alphabetPool);
        $mysteryStr = $returnArr[0];
        $alphabetPool = $returnArr[1];
        //echo var_dump($alphabetPool); //this is where alpha has the right value

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