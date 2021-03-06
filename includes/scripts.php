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
//this checks the start date of projects, or periods.
function sortFunction( $a, $b ) {
    return strtotime($a["startDate"]) - strtotime($b["startDate"]);
}
usort($pageProjects, "sortFunction");
usort($pagePeriods, "sortFunction");



//FUNCTION THAT COMBINES THIS PAGE'S PROJECTS AND PERIODS
//and holds them in chronological order.
function createArrayOfAllPageArchives($periods, $projects){
    foreach ($projects as $value){  
        array_push($periods, $value);
    }
    usort($periods, "sortFunction");
    return $periods;
}

$allArchives = createArrayOfAllPageArchives($pagePeriods, $pageProjects);




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
        echo "<script> let defaulted = false; </script>";
    }
    elseif(count($periods) > 0) {
        $onD = $periods[0];
        echo "<script> let defaulted = false; </script>";
    }else{
        foreach($json as $value){
            if($value[type]=="default" && $value[page]== $page){
                $onD = $value;
                echo "<script> let defaulted = true; </script>";
            }
        }
    }
    return $onD;
}
$onDisplay = chooseDisplay($currentProjects, $currentPeriods, $datas, $page);

//a few links have been added to some pages, that don't get fed through this process, because 
//they are not destined to be on the timeline. These links are currently hardcoded into the 
//html. The only issue this is creating so far is the p-active class on the top-desc-link only
//sets on click... and takes it's hardcoded state on load, regardless of whether or not its 
//archive is displayed. DEFAULTED exists to check whether or not the to-desc-link
//should have the class p-active or not when loading the page. A some javascript inserted in 
//the page's navigation does a quick check and adjusts p-active in consequence.




//populate the aside (it used to be two asides)
//call the function from left-aside & right-aside?
function fillAsides($archive, $onDisplay){
    //this is getting checked to know whether or not to print the year
    $lastPrintedYear;
    //we will need a bool, to know when to close the period openface rectangle
    $inPeriod;
    //and a year to check next to the cycling year, also for closing...
    $lastPeriodEnd;
    //last type... in case a period has no work in it
    $lastType;

    for($i = 0; $i < count($archive); ++$i){

        //this is the length of the time-line fragments
        $lineLength = 20;

        //isolate start and end years from the full date
        $startYear = intval($archive[$i][startDate]);
        $endYear = intval($archive[$i][endDate]);

        //make type more accessible
        $type = $archive[$i][type];

        //A three character shortening of the month name
        //replace the "M" with an "F" for a full month name (ie. January)
        $startMonth = date("M", strtotime($archive[$i][startDate]));
        $endMonth = date("M", strtotime($archive[$i][endDate]));

        //and now to get the days
        $startDay = date("d", strtotime($archive[$i][startDate]));
        $endDay = date("d", strtotime($archive[$i][endDate]));

        //with this new archive, check if you have a current period
        //and if his new archive fits into that period
        //if the previous period ended, you have to close it up!
        //to check if the period is empty, just check if the last type was "period"
        //At this time, there will be no overlapping periods. 
        //overlapping periods will need to be named, and made into their own periods.
        //an empty period will have a 4* length timeline
        if ($archive[$i][startDate] >= $lastPeriodEnd && $inPeriod){
            if ($lastType == "period" && $inPeriod ){
                echo "<div class='time-line' style='height: ".$lineLength * 4 ."px;'></div>";
              }
           echo "</section>";
           echo "<section class='out-of-period'>";
           //when we skip out of a period, 
            if ($type =="project"){
                echo "<div class='time-line' style='height: ".$lineLength."px;'></div>";
            }
           $inPeriod = false;
        }

        //ensure that if the first element is a project
        //the start of the time-line is properly formatted
        if ($i == 0){
            if ($type == "project"){
                echo "<section class='out-of-period'>";
                $inPeriod = false;
            }
        }

        //check if THIS year is already printed on the time-line, IF NOT PRINT IT
        //I've tried printing start years for periods too, but it's too weird.
        //If printed, they should appear differently, and there should be one for 
        //start and one for end.
        if ($startYear !== $lastPrintedYear && $type == "project"){
            $lastPrintedYear = $startYear;
            if ($lastType == "period" && $inPeriod){
                echo "<div class='time-line' style='height: ".$lineLength."px;'></div>";
            }
            echo "<div class='timeline-year'>".$startYear."</div>";
            echo "<div class='time-line' style='height: ".$lineLength."px;'></div>";
        }

        //IF this is a period, OPEN the period border / rectangle / section
        if ($type == "period"){
            if ($i !== 0){
            echo "</section>";
            }
            echo "<section class='period-line'>";
            $inPeriod = true;
            $lastPeriodEnd = $archive[$i][endDate];
        }

        //create a variable, and set it to p-active if this is the "onDisplay"
        $activeState = "";
        if($archive[$i] == $onDisplay){
            $activeState = "p-active";
        }
        //do a few comparisons to figure out how to reference the dates
        $when;
        if ($startYear !== $endYear){
           $when = $startYear."/".$endYear;
        }
        elseif($startYear == $endYear && $startMonth !== $endMonth){
            if ($type == "project"){
            $when = $startMonth." ".$startDay."/".$endMonth." ".$endDay;
            }
            elseif($type == "period"){
                $when = $startYear." ".$startMonth."/".$endMonth;
            }
        }
        elseif($startMonth == $endMonth){
            if ($type == "period"){
                $when = $startYear." ".$startMonth;
            }
            elseif ($type == "project"){
                if ($startDay !== $endDay){
                    $when = $startMonth." ".$startDay."/".$endDay;
                }
                else{$when = $startMonth." ".$startDay;}

            }
        }

        //make sure the title is no longer than 17char
        $max_length = 17;
        $title = $archive[$i][title];
        if ($type == "project" && strlen($title) > $max_length){
            $offset = ($max_length - 3) - strlen($title);
            $title = substr($title, 0, strrpos($title, ' ', $offset)) . '...';
        }

        //build this archive's archive-button!
        echo "<li data-internalid='".$archive[$i][index]."' class='".$type." archive-button ".$activeState."'></li> <li class='info'>".$title."<br>".$when."</li>";

        //place a timeline under this archive button, but not if it's the last!
        //you may be able to get rid of the "project" reference here.
        if ($i !== count($archive)-1 && $type == "project"){
            echo "<div class='time-line' style='height: ".$lineLength."px;'></div>";
        }

        //make sure that if you're at the last archive, but your period extends further,
        //that you close the period section.
        if ($i == count($archive)-1 && $inPeriod){
            if ($lastType = "period" && $inPeriod){
                $lineLength = 80;
                echo "<div class='time-line' style='height: ".$lineLength."px;'></div>";
              }
            echo "</section>";
            $inPeriod = false;
        }

        //reset $lastType
        $lastType = $type;
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
    displayImage($thisArchive);
}





