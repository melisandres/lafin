<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
* 582-11B-MA Epreuve Finale
*
* Mélisandre Schofield: 2395207
*/


$notes = array(
105 => [["Stein", "Gertrude"],[89, 90],[45, 90]],
106 => [["DeBeauvoir", "Simone"],[100, 100],[100, 99]],
107 => [["Atwood", "Margaret"],[52, 67],[0, 1]],
108 => [["Munro", "Alice"],[5, 0],[100, 32]],
109 => [["Didion", "Joan"],[90, 90],[90, 90]],
110 => [["Duras", "Marguerite"],[100, 100],[55, 34]],
111 => [["Orzick", "Cynthia"], [0, 0], [0,0]], 
112 => [["Plath", "Sylvia"], [85, 83],[100, 98]],
113 => [["Lessing", "Doris"], [85, 83],[100, 98]],
114 => [["Elliot", "Georges"], [56, 83],[100, 98]]
);

//variables comming in
$notesABC = array("A" => 90, "B"=> 80, "C" => 70, "D" => 60,"E" => 1, "Abs" => 0);
$passFailStructure = array("reussites" => 0, "echecs" => 0, "vides" => 0);
$ponderations = array(20, 20,  25, 35);
$noteDePassage = 60;


/* //variables pour tableau
$nom_etudiant = "";
$moyene_étudiante = 0;
$note_lettre = "";
$best_note = 0;
$best_travail = "";
$travail_egale = ""; */


//variables pour haut de la page
/* $nb_vides = 0;
$nb_echecs = 0;
$nb_reussites = 0;
$best_remise = "";
$worst_remise = "";
$best_remise_egale = "";
$worst_remise_egale = ""; */



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
//




function calculateMean($arr, $passFailS, $aBC, $pond, $passage){
    displayGreeting();
    //variables pour tableau
    $nom =""; 
    $matricule ="";
    $moyene = ""; 
    $note = ""; 
    $meilleur_travail = "";
    //array Traveaux Examens
    $arrTE = createDynamicArrays($arr, $passFailS);

    /* Une structure qui permet de voir pour chaque travail au niveau
    individuel, et de la classe, les echecs, reussites, et remises vides*/
    $remiseTravauxEtudiant = $passFailS;
    $remisesTravauxClasse = $arrTE[0];

    /*La meme structure, mais pour les examens */
    $remiseExamensEtudiant = $passFailS;
    $remisesExamensClasse = $arrTE[1];

    /*La meme structure, mais pour toutes les remises, et pour le cours*/
    $remisesTotals = $passFailS;
    $cour = $passFailS;

    /* une variable pour initialiser le tableau html*/
    $init = FALSE;

    foreach ($arr as $key => $value){
        for ($i = 0; $i < count($value); $i++){
            //lets initialize the tableau
            if (!$init){
                $t = "travail ";
                $e = "examen ";
                $traveauxHead = setDynamicTableHead($value[1], $t);
                $examensHead = setDynamicTableHead($value[2], $e);
                initializeTable($traveauxHead, $examensHead);
                $init = TRUE;
            }

            switch ($i){
                //looping through the name
                case 0:
                    $nom = $value[$i][0]. ", ". $value[$i][1];
                    $matricule = $key;

                    break;

                //looping through the TPs 
                case 1:
                    $meilleur_travail = calculPlusHauteNote($value[$i]);

                    /*update the variables that are tracking all the remises*/
                    $returnArr = calculDesRemises($value[$i], $remisesTravauxClasse, $passage);
                    $remiseTravauxEtudiant = $returnArr[0];
                    $remisesTravauxClasse = $returnArr[1];

                    $remisesTotals = calculTotalRemises($remisesTotals, $remiseTravauxEtudiant, $passage);

                    /*variable pour creer la parti du tableau qui comprend les notes*/
                    $notesT = addDynamiclyToTable($value[$i]);

                    break;

                //looping though the exams 
                case 2:
                    /*update the variables that are tracking all the remises*/
                    $returnArr = calculDesRemises($value[$i], $remisesExamensClasse, $passage);
                    $remiseExamensEtudiant = $returnArr[0];
                    $remisesExamensClasse = $returnArr[1];
                    $remisesTotals = calculTotalRemises($remisesTotals, $remiseExamensEtudiant, $passage);

                    /*variable pour creer la parti du tableau qui comprend les notes*/
                    $notesE = addDynamiclyToTable($value[$i]);

                    //la moyene de l'édudiant
                    $mean = calculateEachMean($pond, $value);
                    $note = getLetterGrade($mean, $aBC);

                    //add your pass/fail values to an associative array for the class
                    $cour = refreshClassArr($cour, $mean, $passage);

                    //add the current student to the html table
                    addToTable($nom, $matricule, $mean, $note, $notesT, $notesE, $meilleur_travail);

                    break;  
                }
        }
    }
    //close the html table, now that you have added all the students
    endTable();

    $best_remise = bestAndWorstInClass($remisesTravauxClasse, $remisesExamensClasse, "reussites");
    $worst_remise = bestAndWorstInClass($remisesTravauxClasse, $remisesExamensClasse, "echecs");

    topOfPage($cour["vides"], $cour["echecs"], $cour["reussites"], $best_remise, $worst_remise);
}







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









//this calculates how many failures, successes, and empties in the whole class, for all traveaux's and exams
function calculTotalRemises($arrTotal, $arrAjout){
    foreach ($arrTotal as $key => $value){
        $arrTotal[$key] += $arrAjout[$key];
    }
    return $arrTotal;
}






function createDynamicArrays($arr, $passFailS){
    $arrT = array();
    $arrE = array();
    //only loop once over one student, to see what the template is
    //and only on the value of the associative array
    //start your iterator at one to skip the name
    $loop = true;
    foreach ($arr as $key => $value){
        if (!$loop){
            $returnArr = array($arrT, $arrE);
            return $returnArr;
        }
        for($i = 1; $i < count($value); $i++){
            for($j = 0; $j < count($value[$i]); $j++){
                if ($i == 1){
                    //as you loop through traveaux, add an array for each
                    array_push($arrT, $passFailS);
                }
                else {
                    //as you loop through exams, add an array for each
                    array_push($arrE, $passFailS);
                }
            }
            $loop = false;
        }
    } 
}




//this returns two arrays with the values from all the traveau, OR all the examens
//it gets called while looping through the traveau, and again while looping through the exams
//$arr is the data for the student currently being looped through
//$arClasse is an array compiling the data for the whole class
function calculDesRemises($arr, $arrClasse, $passage){
    $reussites = 0;
    $echecs = 0; 
    $vides = 0; 
    for ($i = 0; $i < count($arr); $i++){
        if ($arr[$i] >= $passage){
            $reussites ++;
            $arrClasse[$i]["reussites"] ++;
        }
        if ($arr[$i] == 0){
            $vides ++;
            $arrClasse[$i]["vides"] ++;
        }
        if ($arr[$i] <$passage && $arr[$i] > 0) {
            $echecs ++;
            $arrClasse[$i]["echecs"] ++;
        }
    }
    $arrEtudiant = array( "reussites" => $reussites, "echecs" => $echecs, "vides" => $vides);
    return array($arrEtudiant, $arrClasse);
}




//this is refreshing the class passes and fails
function refreshClassArr($class, $mean, $passage){
    if ($mean >= $passage){
        $class["reussites"] ++;
    }
    elseif ($mean > 0) {
        $class["echecs"] ++;
    }
    else{
        $class["vides"] ++;
    }
    return $class;
}






//This is meant to return the exam or homework that the most people passed
//but it will also be used to return the exam or homework that most people failed
//$bestWorst is the value () that determines which we are checking for. 
function bestAndWorstInClass($classArrT, $classArrE, $bestWorst){
    $lastValue = 0;
    $equalValue = 0;
    $bestOrWorst = "";
    $remiseEgale = "";
    echo "we are checking ".$bestWorst;
    echo "<br>";

    $combinedArr = array($classArrT, $classArrE);
    for ($i = 0; $i < count($combinedArr); $i++){
        for($j = 0; $j < count($combinedArr[$i]); $j++){
            echo "we are now checking ".$combinedArr[$i][$j][$bestWorst];
            echo "<br>";
            if ($combinedArr[$i][$j][$bestWorst] > $lastValue){
                echo $combinedArr[$i][$j][$bestWorst]. " is > to ".$lastValue;
                echo "<br>";
                echo "lastValue is being set to: ".$combinedArr[$i][$j][$bestWorst];
                $lastValue = $combinedArr[$i][$j][$bestWorst];
                //if $i == 0 we are running through traveaux,  $i == 1 is exams
                if($i == 0){
                    $bestOrWorst = "travail ".($j+1);
                }
                else {
                    $bestOrWorst = "examen ".($j+1);
                }
            }
            //check if the number here is equal to the last one
            elseif ($combinedArr[$i][$j][$bestWorst] == $lastValue){
                echo $combinedArr[$i][$j][$bestWorst]. " is == to ".$lastValue;
                echo "<br>";
                echo "equalValue is being set to: ".$combinedArr[$i][$j][$bestWorst];
                $equalValue = $combinedArr[$i][$j][$bestWorst];
                if($i == 0){
                    $remiseEgale = "travail ".($j+1);
                }
                else {
                    $remiseEgale = "examen ".($j+1);
                }
            }
            else{
                echo "<br>";
                echo "we are slipping through";
                echo $combinedArr[$i][$j][$bestWorst]. " is neither == nor > than ".$lastValue;
            }
        }
    }
    if ($lastValue == $equalValue){
        $bestOrWorst .= " & ".$remiseEgale;
    }

    return $bestOrWorst;
}





//this will return the final letter grade for each student. 

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








//this iterates through one array and returns the highest grade, with the 
//"name"(as a number) of the associated homework. It also sends the "name of 
//a secondary homework if another homework ties for first place. It will not
//return a third homework name, if three homeworks have tied for first place

function calculPlusHauteNote($arr){
    $plusHauteNote = $arr[0];
    $travail = 1;
    $travailEgale = 0;
    for ($j = 1; $j < count($arr); $j++){
        //vérifier si la présente note est plus grande que la dernière
        if ($plusHauteNote < $arr[$j]){
            $plusHauteNote = $arr[$j];
            $travail = $j + 1;
        }
        //vérifier si la présente note est égale à la dernière
        elseif ($plusHauteNote == $arr[$j]){
            $travailEgale = $j +1;
        }
    //vérifier si la plus grande note a une note égale
    if ($travailEgale > 0 && $arr[$travailEgale-1] == $plusHauteNote){
        return "travail ".$travail." & ".$travailEgale.", à ".$plusHauteNote."%";
    }
    //rendre les infos pour la plus haute note.
    else 
        return "travail ".$travail.", à ".$plusHauteNote."%";
    }
    $returnArr = array($plusHauteNote, $travail, $travailEgale);
    return $returnArr; 
} 












/*HTML DISPLAY FUNCTIONS*/


function displayGreeting(){
    echo $GLOBALS['div']."Welcome: ".$_POST["name"].$GLOBALS['div_end'];
}




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




function setDynamicTableHead($arr, $examOrTp){
    $i = 1;
    $head = "";
    foreach($arr as $headerName){
        $head .= $GLOBALS['th'].$examOrTp.$i.$GLOBALS['th_end'];
        $i++;
    }
    return $head;
}




function addDynamiclyToTable($arr){
    $tabNotes = "";
    foreach($arr as $note){
        $tabNotes .= $GLOBALS['td'].$note. "%".$GLOBALS['td_end'];
    }
    return $tabNotes;
}





function addToTable($nom, $matricule, $moyene, $note, $notesTraveaux, $notesExamens, $meilleur_travail){
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





function endTable(){
    echo $GLOBALS['table_end'];
}






//a display function that gets called for each new value

function topOfPage($vides, $echecs, $reussites, $best_remise, $worst_remise){

    echo $GLOBALS['section'];

    createTopSegment("vides", $vides);
    createTopSegment("échecs", $echecs);
    createTopSegment("réussites", $reussites);
    createTopSegment("remise(s) la plus réussie", $best_remise);
    createTopSegment("remise(s) la plus échouée", $worst_remise);

    echo $GLOBALS['section_end'];
}

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


