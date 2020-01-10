<?php 
//this script be included AFTER $page is set, 
//BUT BEFORE all of these functions are called!

// Get the contents of the JSON file 
session_start();
$datas = file_get_contents("info.json");
$datas = json_decode($datas, TRUE);
$_SESSION[$datas] = $datas;

//special arrays of items relating to current page
//these will visible as icons in two scroll bars
$pageProjects = array();
$pagePeriods = array();

//current project(s) current period(s)
//these will be shown slightly differently, as things happening now.
$currentProjects = array();
$currentPeriods = array();

//ON DISPLAY... is an object... an array?
//it is the project or period displayed at the center of the page.
$onDisplay = array();

//contemporary project(s) active period(s)
//contemporary, in this case, means contemporary to onDisplay
$contemporaryProjects = array();
$contemporaryPeriods = array();
 
//PAGE PERIODS & PROJECTS
    //create 2 arrays (on load)
    //use them in both asides
function fillArchive($data, $thisPage, $type){
    $archive = array();
    foreach ($data as $value) 
    {
        if ($value[page]==$thisPage && $value[type]==$type) {
            array_push($archive, $value);
        }
    }
    return $archive;
}

$pageProjects = fillArchive($datas, $page, "project");
$pagePeriods = fillArchive($datas, $page, "period");

//reorganize arrays so that the elements are in chronological order
function sortFunction( $a, $b ) {
    return strtotime($a["startDate"]) - strtotime($b["startDate"]);
}
usort($pageProjects, "sortFunction");
usort($pagePeriods, "sortFunction");


//WHERE ARE WE, IN TIME? (what is today?)
//(a variable that can be altered easily if Lafin ever time-travels)
$currentDate = date("Y-m-d");

//CURRENT PERIOD(S) & PROJECTS
//create 2 arrays (on load)
//(REUSE to make your "contemporary" arrays, later)
function findCurrent($data, $thisTime){
    $archive = array();
    foreach($data as $value){
        if ($thisTime >= $value[startDate] && $thisTime <= $value[endDate]){
            array_push($archive, $value); 
        }
    }
    return $archive;
}
$currentProjects = findCurrent($pageProjects, $currentDate);
$currentPeriods = findCurrent($pagePeriods, $currentDate);
  
//onDisplay
//Which current projects/period(s) will be on display (on load).
    //Are there any current projects? ( if yes, *for now* display currentProjects[0])
    //No current projects, check current periods. (if yes, *for now* display currentPeriods[0])
    //No current periods, put in a fallback... wherein the json "type" is set to default
function chooseDisplay($projects, $periods, $json, $page){
    $onDisplay;
    if(count($projects) > 0) {
        $onD = $projects[0];
    }
    elseif(count($periods) > 0) {
        $onD = $periods[0];
    }else{
        foreach($json as $value){
            if($value[type]=="default" && $value[page]== $page){
                $onD = $value;
            }
        }
    }
    return $onD;
}
$onDisplay = chooseDisplay($currentProjects, $currentPeriods, $datas, $page);

//populate both asides
//call the function from left-aside & right-aside?
function fillAsides($archive, $type, $onDisplay){
    foreach ($archive as $value) 
    {
        $buttonScript = "";
        if($value == $onDisplay){
            echo "<a href='#' onClick='myFunction(".$value[index].");'><li data-internalid='".$value[index]."' class='".$type." archive-button p-active'>".$value[title]."</li>";            
        }
        else{
            echo "<a href='#' onClick='myFunction(".$value[index].");'><li data-internalid='".$value[index]."' class='".$type." archive-button'>".$value[title]."</li>";
        }
    }
}

//make "current" in the asides, add to a $page.current array

//on icon click:
    //check icon parent... 
    //display parent.description, and parent.images in c-image, and c-text
    //make other icons normal
    //make icon current
    //check parent.dates, compare to project/period-array.dates, make matches current
    //reposition the left-aside and right aside, so that currents are centred
function onIconClick($thisArchive) {
    displayText($thisArchive);
    displayImage ($thisArchive);
}





