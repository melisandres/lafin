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

session_start();

if (!is_writable(session_save_path())) {
    echo 'Session path "'.session_save_path().'" is not writable for PHP!'; 
}

$_SESSION['my_variable'] = 'try this next';

echo $_SESSION['my_variable'];


//This variable houses the mystery sentence
$ansStr = "Wait, don't do it!";
//This controles the number of wrong guesses you're allowed
$guessesLeft = 6;
//This is an array of guesses for testing 
$guesses = array("t", "z", "b"/*, "s", "n", "y", "a", "e", "m", "u", "l", "r"*/);
//This variable will house the display sentence, with underscores for unguessed characters.
$_SESSION['mysteryStr'] = "";
//$mysteryStr = "";
//Still unusued, this will eventually house the bad guesses, in a pile, under the hangman
$badAnswers = array();


//The first thing to do, is to convert the answer string into a display string. This string needs to be initialized, showing an underscore for each letter to be guessed, while retaining spaces between the words, as well as the punctuation.  

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

$_SESSION['mysteryStr'] = setBoard($ansStr, $_SESSION['mysteryStr'] );
//$mysteryStr = setBoard($ansStr, $mysteryStr);

//Let's show the empty board
echo "<div>".$_SESSION['mysteryStr'] ."</div>";


//A function to check just one character (would be the best way to do it with user input)
//First check if the player has any guesses left (or are they "game over"?)
//Set winFlag to false. Switch flag to true if the guess was good.
//Check to see if that flag has been set to true. If so, give a congratulations message.
//Else, trigger the guess manager (a function that handles messaging and guess decrementation)
function checkChar($guess, $ansKey, $disp, &$gLeft){
     if ($gLeft <=0){
        echo "<div class='message'>out of guesses char</div>";
        return;
     }
    $winFlag = false;
    for($i = 0; $i < strlen($ansKey); $i++){
        if(!strcasecmp($guess, $ansKey[$i])){
            $disp[$i] = $ansKey[$i];
            $winFlag = true;
        }
    }
    echo "<div>".$disp."</div>";
    if($winFlag){
        echo "<div class='message'>Yes, for: ".$guess."!</div>";
        $winFlag = false;       
    }
    else{
        gMessage($gLeft, $guess);
    }   
    return $disp;
}

//test the function with a character
$_SESSION['mysteryStr'] = checkChar("d", $ansStr, $_SESSION['mysteryStr'], $guessesLeft);
//$mysteryStr = checkChar("d", $ansStr, $mysteryStr, $guessesLeft);



//a function that does the same as the earlier function, but with an array of guesses. 
function checkChars($ans, $gue, $mys, &$gLeft){
    for($i = 0; $i < count($gue); $i++){
        if($gLeft <=0){
            echo "<div class='message'>out of guesses chars</div>";
            return;
        }
        $winFlag = false;
        for($j = 0; $j < strlen($ans); $j++){
            if(!strcasecmp($ans[$j], $gue[$i])){
                $mys[$j] = $ans[$j];
                $winFlag = true;
            }
        }
        echo "<div>$mys</div>";
        if($winFlag){
            echo "<div class='message'>Yes, for: ".$gue[$i]."!</div>";   
            $winFlag = false;    
        }
        else{
            gMessage($gLeft, $gue[$i]);
            //modify_global();
        }   
    }
    return $mys;
}

$_SESSION['mysteryStr'] = checkChars($ansStr, $guesses, $_SESSION['mysteryStr'], $guessesLeft);
//$mysteryStr = checkChars($ansStr, $guesses, $mysteryStr, $guessesLeft);


//make a full guess. A function that allows a player to guess the whole sentence.
function guess($str, $ans, &$gLeft){
    if($gLeft <=0){
        echo "<div class='message'>out of guesses guess</div>";
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


$fullGuess = "is this the sentence?";
guess($fullGuess, $ansStr, $guessesLeft);
$fullGuess = "Halt, don't do it!";
guess($fullGuess, $ansStr, $guessesLeft);
guess($ansStr, $ansStr, $guessesLeft);

//this function is called every time a guess is made... but it should only be called when a guess is made, and no match is found. Silly me. I need a nice message, when a match is found, and I could reiterate the guesses left. This means I need to send in a boolean to the function, that will handle whether I am taking out a guess, yes or no. And then I can send a generic success message, coupled with a... "still n guesses left." Technically a hangman is 6 guesses.  

//a function that manages the guesses: decreasing them each time one is used, displaying the number left, and eventually, displaying the hanged man. It is called from the checkChar and checkChars functions when a guess is made.  
function gMessage(&$gLeft, $guess){
    $gLeft--;
    if (strlen($guess)==1){
        echo "<div class='message'>No ".$guess."'s Guesses left: (".$gLeft.")</div>";
    }
    else {
        echo "<div class='message'> Bad guess: ".$guess." Guesses left: (".$gLeft.")</div>";
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

//do not accept any keys that are not alphabetic (but only in the character guesses... not in the full sentence guess)
echo "<div>".$guessesLeft."</div>";
$timer = 0;
While($timer < 1 && $guessesLeft == 0){
    $base = time();
    $timer += time() -$base;
    echo "yay!";
    $timer = 1;
}
//echo time();

 if(isset($_GET['character'])) {
    $character = $_GET['character'];
    $output = checkChar($character, $ansStr,  $_SESSION['mysteryStr'], $guessesLeft);
    //print_r(checkChar($character, $ansStr,  $_SESSION['mysteryStr'], $guessesLeft));
    //$mysteryStr = checkChar($character, $ansStr, $mysteryStr, $guessesLeft);
    $_SESSION['mysteryStr'] = $output;
    echo  $output;
  }


?>
<main>


    <!-- <section class = "guess">
        
        <form action="<?php /*echo $_SERVER['PHP_SELF'];*/ ?>" method="get">
            <label for="character">Enter one character:</label>
            <input type="text" id="character" name="character">
            <button type="submit">Submit</button>
        </form>

    </section> -->

    <form id="input-form" action="get">
        <label for="character">Enter one character:</label>
        <input type="text" id="character" name="character">
        <button type="submit">Submit</button>
    </form>

    <script>
        var form = document.getElementById("input-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault(); // prevent the form from submitting normally
            var input = document.getElementById("character").value;
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                // Response from PHP script
                document.getElementById("board").innerHTML = this.response;
            }
        };
        xmlhttp.open("GET", location.href + "?input=" + input, true);
        xmlhttp.send();
        document.getElementById("character").value = ""; // reset input field
        });
    </script>

    <section id = "board">
    
       <!-- <div id="output"></div>-->

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