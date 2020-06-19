<?php 
function displayText($onD){
        echo "<h1>".$onD[title]."</h1>";
        echo "<h4>".$onD[lead]."</h4>";

        if ($onD[index] == "27") {
                include '../infos/'.$onD[index].'.php'; 
        }
        else { 
                echo "<p>".$onD[blurb]."</p>";
        }
}

displayText($onDisplay);
?>      