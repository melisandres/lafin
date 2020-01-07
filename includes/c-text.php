<?php 
function displayText($onD){

        echo "<h1>".$onD[title]." blah </h1>";
        echo "<h4>".$onD[lead]."</h4>";
        echo "<p>".$onD[blurb]."</p>";
}
displayText($onDisplay);
?>

