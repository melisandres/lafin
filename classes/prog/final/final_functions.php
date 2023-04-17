<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
* 582-11B-MA Epreuve Finale
*
* Mélisandre Schofield: 2395207
*/

// Data for the class
$studentData = array(
105 => [["Stein", "Gertrude"],[89, 90, 25],[45, 90]],
106 => [["DeBeauvoir", "Simone"],[100, 100, 25],[100, 99]],
107 => [["Atwood", "Margaret"],[52, 67, 34],[0, 1]],
108 => [["Munro", "Alice"],[5, 0, 24],[100, 32]],
109 => [["Didion", "Joan"],[90, 90, 56],[90, 90]],
110 => [["Duras", "Marguerite"],[100, 100, 67],[55, 34]],
111 => [["Orzick", "Cynthia"], [0, 0, 54], [0,0]], 
112 => [["Plath", "Sylvia"], [85, 83, 43],[100, 98]],
113 => [["Lessing", "Doris"], [85, 83, 45],[100, 98]],
114 => [["Elliot", "Georges"], [56, 83, 45],[100, 98]]
);
$gradesABC = array("A" => 90, "B"=> 80, "C" => 70, "D" => 60,"E" => 1, "Abs" => 0);
$passFailStructure = array("reussites" => 0, "echecs" => 0, "vides" => 0);
$ponderations = array(20, 10, 10, 25, 35);
$passingGrade = 60;


// HTML 
$br = "<br>";
$table = "<table>";
$table_end = "</table>";
$tr = "<tr>";
$tr_end = "</tr>"; 
$th = "<th>";
$th_end = "</th>";
$td = "<td>";
$td_end = "</td>";
$div = "<div>";
$div_end = "</div>";
$section = "<section>";
$section_end = "</section>";
$h2 = "<h2>";
$h2_end = "</h2>";



/*
 * Main function iterates through the student data structure and calls all other functions
 * 
 * Inputs :
 * $arr: students array
 * $passFailS: associative array structure to track: echecs, succes et vides
 * $aBC: array with number grades and equivalent letter grades
 * $pond: ponderation array
 * $pass: passing grade
 * 
 * Outputs :
 * (void) Executes display functions.
 */
function calculateMean($arr, $passFailS, $aBC, $pond, $pass){
    // Display the greeting
    displayGreeting();

    // Create two assiative arrays that track pass, fail, and empty.
    $arrTraveauxExamens = createDynamicArrays($arr, $passFailS);
    // Extract these arrays (one for ALL traveaux, and the other for ALL examens)
    $remisesTravauxClasse = $arrTraveauxExamens[0];
    $remisesExamensClasse = $arrTraveauxExamens[1];

    // Use the same structure, and track: all "remises", the class
    // and each individual student, as we loop through.
    $cour = $passFailS;

    // A variable to check if we've initialized the html spreadsheet
    $init = FALSE;

    foreach ($arr as $key => $value){
        for ($i = 0; $i < count($value); $i++){
            // Let's initialize the spreadsheet
            if (!$init){
                $t = "travail ";
                $e = "examen ";
                // $value[1] and $value[2] are respectively Traveaux and Examens
                $traveauxHead = setDynamicTableHead($value[1], $t);
                $examensHead = setDynamicTableHead($value[2], $e);
                initializeTable($traveauxHead, $examensHead);
                $init = TRUE;
            }

            switch ($i){
                // Let's loop through the name
                case 0:
                    $nom = $value[$i][0]. ", ". $value[$i][1];
                    $matricule = $key;
                    break;

                // Let's loop through the Traveaux 
                case 1:
                    // Calculate the highest grade on a Travail by this student
                    $meilleur_travail = calculPlusHauteNote($value[$i]);

                    // Update the variables that are tracking all the remises Traveaux for display
                    $remisesTravauxClasse =  calculRemises($value[$i], $remisesTravauxClasse, $pass);

                    // This is a variable that holds a dynamic update of the grades for the spreadsheet
                    $notesT = addDynamiclyToTable($value[$i]);

                    break;

                // Let's loop though the exams 
                case 2:
                    // Update the variables that are tracking all the remises Examens
                    $remisesExamensClasse =  calculRemises($value[$i], $remisesExamensClasse, $pass);


                    // Update the variables that are tracking all the remises Examens for display
                    $notesE = addDynamiclyToTable($value[$i]);

                    // Calculate the student's final grade
                    $mean = calculateEachMean($pond, $value);
                    $note = getLetterGrade($mean, $aBC);

                    // Add this student's pass or fail to an ass. array tracking pass/fail for the class
                    $cour = refreshArr($cour, $mean, $pass);

                    // Add the current student to the html spreadsheet
                    addToTable($nom, $matricule, $mean, $note, $notesT, $notesE, $meilleur_travail);

                    break;  
                }
        }
    }
    // Close the html table, now that you have added all the students.
    endTable();

    // Calculate the best and the worst remises, for the top of the page.
    $best_remise = bestAndWorstInClass($remisesTravauxClasse, $remisesExamensClasse, "reussites");
    $worst_remise = bestAndWorstInClass($remisesTravauxClasse, $remisesExamensClasse, "echecs");

    // Display the data that will go on top of the page.
    topOfPage($cour["vides"], $cour["echecs"], $cour["reussites"], $best_remise, $worst_remise);
}





/*
 * Calculate each student's final number grade.
 * 
 * Inputs :
 * $pond: ponderation array
 * $value: the student array 
 * 
 * Outputs :
 * $mean: the final grade.
 */
//
function calculateEachMean($pond, $value){
    $mean = 0;
    $k = 0;
    for ($i = 1; $i < count($value); $i++){
        for ($j = 0; $j < count($value[$i]); $j++){
            $mean += $value[$i][$j] /100 * $pond[$k];
            $k++; 
        }
    }
    return $mean;
}





/*
 * Loop through one studentData layer, and use 
 * it as a template to create two associative arrays,
 * one for Traveaux, and another for Examens.
 * 
 * Inputs :
 * $arr: the student array
 * $passFailS: associative array structure to track: echecs, succes et vides
 * 
 * Outputs :
 * $arrT: array of arrays, 1 for each Travail found in the first student's structure.
 * $arrE: array of arrays, 1 for each Exament found in the first student's structure.
 */

function createDynamicArrays($arr, $passFailS){
    $arrT = array();
    $arrE = array();
    // Only loop once over one student, to see what the template is
    // and only on the value of the associative array
    // start your iterator at one to skip the name.
    $loop = true;
    foreach ($arr as $key => $value){
        if (!$loop){
            $returnArr = array($arrT, $arrE);
            return $returnArr;
        }
        for($i = 1; $i < count($value); $i++){
            for($j = 0; $j < count($value[$i]); $j++){
                if ($i == 1){
                    // As you loop through traveaux, add an array for each.
                    array_push($arrT, $passFailS);
                }
                else {
                    // As you loop through exams, add an array for each
                    array_push($arrE, $passFailS);
                }
            }
            $loop = false;
        }
    } 
}




/*
 * Return an array with the values from all the traveaux, OR all the examens
 * it gets called twice 1. looping through traveaux, 2. looping through exams
 * 
 * Inputs :
 * $arr: the student array
 * $arrClasse: is an array compiling the data for the whole class
 * 
 * Outputs :
 * $arrClasse: updated class array
 */

function calculRemises($arr, $arrClasse, $pass){
    for ($i = 0; $i < count($arr); $i++){
        if ($arr[$i] >= $pass){
                $arrClasse[$i]["reussites"] ++;
            }
            if ($arr[$i] == 0){
                $arrClasse[$i]["vides"] ++;
            }
            if ($arr[$i] <$pass && $arr[$i] > 0) {
                $arrClasse[$i]["echecs"] ++;
            }
        }
    return $arrClasse;
}



/*
 * This is refreshing the class passes and fails
 * 
 * Inputs :
 * $arrToRefresh: the array that one wants to refresh
 * $value: the student array
 * $pass: the passing grade
 * 
 * Outputs :
 * $arrToRefresh: the array that is being refreshed
 */
function refreshArr($arrToRefresh, $value, $pass){
    if ($value >= $pass){
        $arrToRefresh["reussites"] ++;
    }
    elseif ($value > 0) {
        $arrToRefresh["echecs"] ++;
    }
    else{
        $arrToRefresh["vides"] ++;
    }
    return $arrToRefresh;
}





/*
 * Check which homework or Exam did best, 
 * and which did worst
 * 
 * Inputs :
 * $classArrT: the array of class Pass/Fails for Traveaux
 * $classArrE: the array of class Pass/Fails for Examens
 * $bestWorst: a string (values= "reussites" or "echecs"), 
 * used as a key determining if we check for the best, or the worst
 * 
 * Outputs :
 * $bestOrWorst: a string with the name of the best/worst travail/examen
 */
function bestAndWorstInClass($classArrT, $classArrE, $bestWorst){
    $lastValue = 0;
    $equalValue = 0;
    $bestOrWorst = "";
    $remiseEgale = "";

    $combinedArr = array($classArrT, $classArrE);
    for ($i = 0; $i < count($combinedArr); $i++){
        for($j = 0; $j < count($combinedArr[$i]); $j++){
            if ($combinedArr[$i][$j][$bestWorst] > $lastValue){
                $lastValue = $combinedArr[$i][$j][$bestWorst];
                // If $i == 0 we are running through traveaux,  $i == 1 is exams
                if($i == 0){
                    $bestOrWorst = "travail ".($j+1);
                }
                else {
                    $bestOrWorst = "examen ".($j+1);
                }
            }
            // Check if the number here is equal to the last one
            elseif ($combinedArr[$i][$j][$bestWorst] == $lastValue){
                $equalValue = $combinedArr[$i][$j][$bestWorst];
                if($i == 0){
                    $remiseEgale = "travail ".($j+1);
                }
                else {
                    $remiseEgale = "examen ".($j+1);
                }
            }
        }
    }
    // Now that we've determined the best or worst, let's check if the equal value is still equal.
    if ($lastValue == $equalValue){
        $bestOrWorst .= " & ".$remiseEgale;
    }

    return $bestOrWorst;
}




/*
 * Get the letter grade for current student
 * 
 * Inputs :
 * $grade: the students final grade
 * $abc: array of letter grades, and equivalent number grades
 * 
 * Outputs :
 * $key: the letter grade for the current student
 */

function getLetterGrade($grade, $aBC){
    if  ($grade >= 101 | $grade < 0){
        echo "erreur de tableau. ".$grade." n'est pas une valeur de note permise.";
    }
    foreach ($aBC as $key => $value){
        if ($grade >= $value){
            return $key;
        }
    }
}




/*
 * Iterate through one array and return the highest grade, with the 
 * name of the associated homework. It also sends the name of 
 * a secondary homework if this ties it for 1st place. It will not
 * return a 3rd homework name, if 3 homeworks tie for 1st place.
 * 
 * Inputs :
 * $arr: student array
 * 
 * Outputs :
 * $returnArr (includes) :
 * $plusHauteNote: the grade of the best travail
 * $travail: the numeral associated to the best travail
 * $travailEgale: the numeral associated to another travail that tied it for 1st place
 */
function calculPlusHauteNote($arr){
    $plusHauteNote = $arr[0];
    $travail = 1;
    $travailEgale = 0;
    for ($j = 1; $j < count($arr); $j++){
        // Check if the current grade is greater than the last
        if ($plusHauteNote < $arr[$j]){
            $plusHauteNote = $arr[$j];
            $travail = $j + 1;
        }
        // Check if the current grade is equal to the last
        elseif ($plusHauteNote == $arr[$j]){
            $travailEgale = $j +1;
        }
    // Check if the greatest grade has a grade equal to it
    if ($travailEgale > 0 && $arr[$travailEgale-1] == $plusHauteNote){
        return "travail ".$travail." & ".$travailEgale.", à ".$plusHauteNote."%";
    }
    // Return the infos for the best grade.
    else 
        return "travail ".$travail.", à ".$plusHauteNote."%";
    }
    $returnArr = array($plusHauteNote, $travail, $travailEgale);
    return $returnArr; 
} 










/*
*HTML DISPLAY FUNCTIONS
 */


/*
 * Display the Greeting 
 * 
 * Inputs :
 * $name: the user name (received from POST)
 * $global html variables
 * 
 * Outputs :
 * (void) execute part of the display
 */

function displayGreeting(){
    echo $GLOBALS['div']."Bienvenue: ".$_POST["name"].$GLOBALS['div_end'];
}



/*
 * Display the initializing of the spreadsheet
 * 
 * Inputs :
 * $traveaux: an html string showing the correct number of traveaux
 * $examens: an html string showing the correct number of examens
 * gobal html variables
 * 
 * Outputs :
 * (void) execute part of the display
 */
function initializeTable($traveaux, $examens){
    echo $GLOBALS['table'];
    echo $GLOBALS['tr'];
    echo $GLOBALS['th'].  "étudiant(e)"  .$GLOBALS['th_end'];
    echo $GLOBALS['th']. "matricule"   .$GLOBALS['th_end'];
    echo $traveaux;
    echo $examens;
    echo $GLOBALS['th'].  "note finale"  .$GLOBALS['th_end'];
    echo $GLOBALS['th'].  "note lettre"  .$GLOBALS['th_end'];
    echo $GLOBALS['th'].  "travail le mieux réussit"  .$GLOBALS['th_end'];
    echo $GLOBALS['tr_end'];
}



/*
 * Create the strings for the Spreadsheet Head
 * Traveaux and Examen part, so that it reflects the 
 * correct number of these
 * 
 * Inputs :
 * $arr: student array
 * $examOrTp: string, "examen" or "travail"
 * gobal html variables
 * 
 * Outputs :
 * $head: a string for each examen and travail
 */
function setDynamicTableHead($arr, $examOrTp){
    $i = 1;
    $head = "";
    foreach($arr as $headerName){
        $head .= $GLOBALS['th'].$examOrTp.$i.$GLOBALS['th_end'];
        $i++;
    }
    return $head;
}

/*
 * Add grades the the spreadsheet
 * 
 * Inputs :
 * $arr: student array
 * gobal html variables
 * 
 * Outputs :
 * $tabNotes: an html output of the grades concatenated together
 */
function addDynamiclyToTable($arr){
    $tabNotes = "";
    foreach($arr as $note){
        $tabNotes .= $GLOBALS['td'].$note. "%".$GLOBALS['td_end'];
    }
    return $tabNotes;
}

/*
 * Add all the student data to the spreadsheet
 * 
 * Inputs :
 * $nom: student name 
 * $matricule: student id
 * $moyene: student final grade
 * $note: student letter grade
 * $notesTraveaux: grades for all traveaux
 * $notesExamens: grades for all examens
 * $meilleur_travail: grade for best travail, and its name
 * gobal html variables
 * 
 * Outputs :
 * (void) Displays the spreadsheet line of one student
 */
function addToTable(
    $nom, 
    $matricule, 
    $moyene, 
    $note, 
    $notesTraveaux, 
    $notesExamens, 
    $meilleur_travail) {

    echo $GLOBALS['tr'];
    echo $GLOBALS['td'].  $nom  .$GLOBALS['td_end'];
    echo $GLOBALS['td']. "#".$matricule .$GLOBALS['td_end'];
    echo $notesTraveaux;
    echo $notesExamens;
    echo $GLOBALS['td'].  $moyene."%"  .$GLOBALS['td_end'];
    echo $GLOBALS['td'].  $note  .$GLOBALS['td_end'];
    echo $GLOBALS['td'].  $meilleur_travail  .$GLOBALS['td_end'];
    echo $GLOBALS['tr_end'];
}


/*
 * Close the html for the spreadsheet
 * 
 * Inputs :
 * none  (gobal html variables)
 * 
 * Outputs :
 * (void) execute a display
 */
function endTable(){
    echo $GLOBALS['table_end'];
}




/*
 * Display the statistical elements 
 * for the top of the page
 * 
 * Inputs :
 * $vides: number of students in the class who only returned empty work
 * $echecs: number of failures in the class
 * $reussites: number of successes in the class
 * $best_remise: work(s) that the most students succeeded at
 * $worst_remise: work(s) that the most students failed at
 * gobal html variables
 * 
 * Outputs :
 * (void) executes a display
 */
function topOfPage($vides, $echecs, $reussites, $best_remise, $worst_remise){

    echo $GLOBALS['section'];

    createTopSegment("vides", $vides);
    createTopSegment("échecs", $echecs);
    createTopSegment("réussites", $reussites);
    createTopSegment("remise(s) la plus réussie", $best_remise);
    createTopSegment("remise(s) la plus échouée", $worst_remise);

    echo $GLOBALS['section_end'];
}


/*
 * Display the statistical elements 
 * for the top of the page
 * 
 * Inputs :
 * $text: the header to be displayed
 * $value: the value to be displayed
 * 
 * Outputs :
 * (void) executes a display
 */
function createTopSegment($text, $value){
    echo $GLOBALS['div'];
    echo $GLOBALS['h2'];
    echo $text;
    echo $GLOBALS['h2_end'];
    echo $GLOBALS['div'];
    echo $value;
    echo $GLOBALS['div_end'];
    echo $GLOBALS['div_end'];
}

?>


