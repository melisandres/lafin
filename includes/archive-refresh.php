<?php 

// Get the contents of the JSON file 
$datas = file_get_contents("../info.json");
$datas = json_decode($datas, TRUE);

$newIndex = $_GET["newIndex"];

function resetOnDisplay($index, $data){
    $newDisplay = array ();
    foreach($data as $value){
        if ($index==$value[index]){
            $newDisplay = $value; 
        }
    }
    return $newDisplay;
}

$onDisplay = resetOnDisplay($newIndex, $datas);

function displayText($onD){
    echo "<h1>".$onD[title]."</h1>";
    echo "<h4>".$onD[lead]."</h4>";
    echo "<p>".$onD[blurb]."</p>";
}

displayText($onDisplay);

?>