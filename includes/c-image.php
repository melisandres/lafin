<?php 

function displayImage($onD){
    echo "<figure class='center-image'> <div class='cell'> <img src=".$onD[image1]." alt='".$onD[alt1]."' title='".$onD[alt1]."'> </div> <figcaption> ".$onD[caption1]." </figcaption> </figure>";
}
displayImage($onDisplay);

?>