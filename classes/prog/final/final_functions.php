<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/*
* 582-11B-MA Epreuve Finale
*
* Mélisandre Schofield: 2395207
*/


displayGreeting();

$notes = array(
105 => [["Stein", "Gertrude"],[89, 59],[45, 90]],
106 => [["DeBeauvoir", "Simone"],[100, 100],[100, 99]],
107 => [["Atwood", "Margaret"],[52, 67],[0, 1]],
108 => [["Munro", "Alice"],[5, 0],[100, 32]],
109 => [["Didion", "Joan"],[90, 90],[90, 90]],
110 => [["Duras", "Marguerite"],[100, 100],[55, 34]],
111 => [["Orzick", "Cynthia"], [0, 0], [0,0]]
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
$nb_vides = 0;
$nb_echecs = 0;
$nb_reussites = 0;
$best_remise = "";
$worst_remise = "";
$best_remise_egale = "";
$worst_remise_egale = "";



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
                $t = "Travail ";
                $e = "Examen ";
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




//the following two functions can be combined, surely. 
//and the function immediately following may be better a little shorter



//would it be possible, while looping through, to check if... for instance, pass exists, 
//at arrT[$i] position (wherever I've found a pass...)and if it does not, just add it with a 
//value of 1? would that be less code heavy?

//this returns an array with the values from all the traveau, or all the examens
//what are the two arrays being sent out? 
function calculDesRemises($arr, $arrTE, $passage){
    $reussites = 0;
    $echecs = 0; 
    $vides = 0; 
    for ($i = 0; $i < count($arr); $i++){
        /* echo $arr[$i]."this is the value being tested"; */
        if ($arr[$i] >= $passage){
            /* echo "note is (reussi): ".$arr[$i]; */
            $reussites ++;
            $arrTE[$i]["reussites"] ++;
        }
        if ($arr[$i] == 0){
            /* echo "note is (vide): ".$arr[$i]; */
            $vides ++;
            $arrTE[$i]["vides"] ++;
            //would this also count as an echec? 
        }
        if ($arr[$i] <$passage && $arr[$i] > 0) {
           /*  echo "note is (echec): ".$arr[$i]; */
            $echecs ++;
            $arrTE[$i]["echecs"] ++;
        }
    }
    $arr = array( "reussites" => $reussites, "echecs" => $echecs, "vides" => $vides);
    return array($arr, $arrTE);
}

//this is surely doing the same thing as some other functions... 
//I need to compare the functions that seem to do something similar, 
//and see if they really are, and if they aren't I need to articulate that
//in some good comments because my comments are not good enough to explain my code 
//to future me. I'm confused about what I wrote last week. 
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
    $position = "";
    $remiseEgale = "";

    $combinedArr = array($classArrT, $classArrE);
    for ($i = 0; $i < count($combinedArr); $i++){
        for($j = 0; $j < count($combinedArr[$i]); $j++){
            if ($combinedArr[$i][$j][$bestWorst] > $lastValue){
                $lastValue = $combinedArr[$i][$j][$bestWorst];
                //if $i ==0 we are running through Traveaux,  $i=1 is exams
                if($i == 0){
                    $position = "travail ".($j+1);
                }
                else {
                    $position = "examen ".($j+1);
                }
            }
            //check if the number here is equal to the last one
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
    if ($lastValue == $equalValue){
        $position .= " & ".$remiseEgale;
    }
    
    return $position;
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
        return "Travail".$travail." & ".$travailEgale.", à ".$plusHauteNote."%";
    }
    //rendre les infos pour la plus haute note.
    else 
        return "Travail".$travail.", à ".$plusHauteNote."%";
    }
    $returnArr = array($plusHauteNote, $travail, $travailEgale);
    return $returnArr; 
} 












/*HTML DISPLAY FUNCTIONS*/


function displayGreeting(){
    echo "Welcome: ".$_POST["name"]."</br></br>";
}




function initializeTable($traveaux, $examens){
    echo $GLOBALS['table'];
    echo $GLOBALS['tr'];
    echo $GLOBALS['th'].  "étudiant(e)"  .$GLOBALS['th_end'];
    echo $GLOBALS['th']. "matricule"   .$GLOBALS['th_end'];
    echo $traveaux;
    echo $examens;
    echo $GLOBALS['th'].  "moyene finale"  .$GLOBALS['th_end'];
    echo $GLOBALS['th'].  "note finale"  .$GLOBALS['th_end'];
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
        $tabNotes .= $GLOBALS['td'].$note.$GLOBALS['td_end'];
    }
    return $tabNotes;
}





function addToTable($nom, $matricule, $moyene, $note, $notesTraveaux, $notesExamens, $meilleur_travail){
    echo $GLOBALS['tr'];
    echo $GLOBALS['td'].  $nom  .$GLOBALS['td_end'];
    echo $GLOBALS['td']. $matricule .$GLOBALS['td_end'];
    echo $notesTraveaux;
    echo $notesExamens;
    echo $GLOBALS['td'].  $moyene  .$GLOBALS['td_end'];
    echo $GLOBALS['td'].  $note  .$GLOBALS['td_end'];
    echo $GLOBALS['td'].  $meilleur_travail  .$GLOBALS['td_end'];
    echo $GLOBALS['tr_end'];
}





function endTable(){
    echo $GLOBALS['table_end'];
}






//maybe do this in a loop so that you don't need to copy paste so many times

function topOfPage($vides, $echecs, $reussites, $best_remise, $worst_remise){


    echo $GLOBALS['section'];

    echo $GLOBALS['div'];
    echo $GLOBALS['h2'];
    echo "remises vides";
    echo $GLOBALS['h2_end'];
    echo $GLOBALS['div'];
    echo $vides;
    echo $GLOBALS['div_end'];
    echo $GLOBALS['div_end'];

    echo $GLOBALS['div'];
    echo $GLOBALS['h2'];
    echo "échecs";
    echo $GLOBALS['h2_end'];
    echo $GLOBALS['div'];
    echo $echecs;
    echo $GLOBALS['div_end'];
    echo $GLOBALS['div_end'];

    echo $GLOBALS['div'];
    echo $GLOBALS['h2'];
    echo "réussites";
    echo $GLOBALS['h2_end'];
    echo $GLOBALS['div'];
    echo $reussites;
    echo $GLOBALS['div_end'];
    echo $GLOBALS['div_end'];

    echo $GLOBALS['div'];
    echo $GLOBALS['h2'];
    echo "remise(s) la plus réussie";
    echo $GLOBALS['h2_end'];
    echo $GLOBALS['div'];
    echo $best_remise;
    echo $GLOBALS['div_end'];
    echo $GLOBALS['div_end'];

    echo $GLOBALS['div'];
    echo $GLOBALS['h2'];
    echo "remise(s) la plus échouée";
    echo $GLOBALS['h2_end'];
    echo $GLOBALS['div'];
    echo $worst_remise;
    echo $GLOBALS['div_end'];
    echo $GLOBALS['div_end'];

    echo $GLOBALS['section_end'];
}

?>


