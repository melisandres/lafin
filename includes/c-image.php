<?php 

function displayImage($onD){
echo "<figure> <img src=".$onD[image1]." alt=".$onD[alt1]."> <figcaption> ".$onD[caption1]." </figcaption> </figure>";
echo "this is what's in alt: ";
var_dump($onD[alt1]);
}
displayImage($onDisplay);

//echo "number of projects:".count($pageProjects)."<br>number of periods:".count($pagePeriods);
//echo "<br>Current projects:".count($currentProjects)."<br>Current periods:".count($currentPeriods);
?>