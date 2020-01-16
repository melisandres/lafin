<?php 

// Get the contents of the JSON file 
$datas = file_get_contents("../info.json");
$datas = json_decode($datas, TRUE);

//the index number of the icon clicked
//is passed on through .get, as "newIndex"
$newIndex = $_POST["newIndex"];


//this code can be reused to refresh image & text...
//however, as they need to each be loaded in different
//places... I'm sending over a variable from the jqueery
//script that acts like a toggle.

$refresh = $_POST["refresh"];

//a function that searches through all the Json
//data stored in $datas, finds the clicked index
//and sets the corresponding archive as $newDisplay
function resetOnDisplay($index, $data){
    $newDisplay = array ();
    foreach($data as $value){
        if ($index==$value[index]){
            $newDisplay = $value; 
        }
    }
    return $newDisplay;
}

//In c-text.php and in c-image.php, functions
//display the $onDisplay variable. So... I reset it, 
//before calling these scripts. 
$onDisplay = resetOnDisplay($newIndex, $datas);

function showNewDisplay($im, $onD){
    $onDisplay = $onD;
    if ($im == "text"){
       include 'c-text.php';
    }
    elseif ($im == "image") {
        include "c-image.php";
    }
    else {
        echo "error at aside-left.php?, sending neither text nor image";
    }
}

//I'll be calling this whole script two times, I guess.
showNewDisplay($refresh, $onDisplay);
?>