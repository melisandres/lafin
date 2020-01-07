<?php 

// Get the contents of the JSON file 
$datas = file_get_contents("../info.json");
$datas = json_decode($datas, TRUE);

//the index number of the icon clicked
//is passed on through .get, as "newIndex"
$newIndex = $_GET["newIndex"];

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

//this function is already in c-text. It's the 
//function that displays the selected archive.

$onDisplay = resetOnDisplay($newIndex, $datas);
include "c-text.php";
include "c-image";

?>