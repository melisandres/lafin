<?php 

function displayImage($onD){
    echo "<figure class='center-image'> <img src=".$onD[image1]." alt='".$onD[alt1]."' title='test title'> <figcaption> ".$onD[caption1]." </figcaption> </figure>";
}
displayImage($onDisplay);

?>