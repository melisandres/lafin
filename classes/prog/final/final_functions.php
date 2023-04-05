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
111 => [["Orzick", "Cynthia"], [0,0], [0,0]]
);

//variables comming in
$notesABC = array("A" => 90, "B"=> 80, "C" => 70, "D" => 60,"E" => 1, "Abs" => 0);
$passFailStructure = array("reussites" => 0, "echecs" => 0, "vides" => 0);
$ponderations = array(20, 20, 25, 35);
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
    $moyene = ""; 
    $note = ""; 
    $meilleur_travail = "";
    $arrTE = createDynamicArrays($arr, $passFailS);


    $remiseTravauxEtudiant = $passFailS;
    $remisesTravauxClasse = $arrTE[0];
/*     echo var_dump($remisesTravauxClasse)."<br>does this work?"; */

    $remiseExamensEtudiant = $passFailS;
    $remisesExamensClasse = $arrTE[1];

    $remisesTotals = $passFailS;
    $cour = $passFailS;

    initializeTable();

    foreach ($arr as $key => $value){
        for ($i = 0; $i < count($value); $i++){
            switch ($i){
                //looping through the name
                case 0:
                    $nom = $value[$i][0]. ", ". $value[$i][1];
  /*                   echo "name: ";
                    echo $value[$i][0]. ", ". $value[$i][1];
                    echo "<br>"; */
                    break;

                //looping through the TPs 
                case 1:
                    $meilleur_travail = calculPlusHauteNote($value[$i]);


                    $returnArr = calculDesRemises($value[$i], $remisesTravauxClasse, $passage);
                    $remiseTravauxEtudiant = $returnArr[0];
                    $remisesTravauxClasse = $returnArr[1];
/*                     echo "<br>";
                    echo "<br>".var_dump($remisesTravauxClasse)."remise Travaux CLass</br>"; */

                    $remisesTotals = calculTotalRemises($remisesTotals, $remiseTravauxEtudiant, $passage);
                    break;

                //looping though the exams 
                case 2:
                    $returnArr = calculDesRemises($value[$i], $remisesExamensClasse, $passage);
                    $remiseExamensEtudiant = $returnArr[0];
                    $remisesExamensClasse = $returnArr[1];

/*                     echo "<br>";
                    echo "<br>".var_dump($remisesExamensClasse)."remise Examens CLass</br>"; */

                    $remisesTotals = calculTotalRemises($remisesTotals, $remiseExamensEtudiant, $passage);

                    $mean = calculateEachMean($pond, $value);

                    //add your pass/fail values to an associative array for the class
                    $cour = refreshClassArr($cour, $mean, $passage);


/*                     echo "mean: ".$mean;
                    echo "<br>"; */
                    $note = getLetterGrade($mean, $aBC);
/*                     echo "Letter Grade: ".$note;
                    echo "<br>";
                    echo "<br>"; */
                    addToTable($nom, $mean, $note, $meilleur_travail);

                    break;  

                }
        }
    }
    endTable();
/*     echo var_dump($remisesTotals);
    echo "total pass: ".$cour["reussites"];
    echo "total fail: ".$cour["echecs"]; */
}

/*calculateMean($notes);*/






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
//$bestWorst is the value that determines which we are checking for. 
function bestAndWorstInClass($classArrT, $classArrE, $bestWorst){
    $lastValue = 0;
    $position = "";
    $combinedArr = array($classArrT, $classArrE);
    for ($i = 0; $i < count($combinedArr); $i++){
        for($j = 0; $j < count($combinedArr[$i]); $j++){
            if ($combinedArr[$i][$j][$bestWorst] > $lastValue){
                $lastValue = $combinedArr[$i][$j][$bestWorst];
                if($i == 0){
                    $position = "travail".$i;
                }
                else {
                    $examOrHomework = "examen".$i;
                }
            }
        }
    }
    echo "The most successful of all exams and homeworks for this class was  ".$stringTE.$position;
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
        //echo "Best TP: travail ".$travail." & ".$travailEgale."---note: ".$plusHauteNote;
        return "Travail".$travail." & ".$travailEgale.", à ".$plusHauteNote."%";
    }
    //rendre les infos pour la plus haute note.
    else 
        //echo "Best TP: travail ".$travail."--- note: ".$plusHauteNote;
        return "Travail".$travail.", à ".$plusHauteNote."%";
    }
    echo"<br>";
    $returnArr = array($plusHauteNote, $travail, $travailEgale);
    return $returnArr; 
} 












/*HTML DISPLAY FUNCTIONS*/

function displayGreeting(){
    echo "Welcome: ".$_POST["name"]."</br></br>";
}

function initializeTable(){
    echo $GLOBALS['table'];
    echo $GLOBALS['tr'];
    echo $GLOBALS['th'].  "étudiant(e)"  .$GLOBALS['th_end'];
    echo $GLOBALS['th'].  "moyene finale"  .$GLOBALS['th_end'];
    echo $GLOBALS['th'].  "note finale"  .$GLOBALS['th_end'];
    echo $GLOBALS['th'].  "travail le mieux réussit"  .$GLOBALS['th_end'];
    echo $GLOBALS['tr_end'];
}

function addToTable($nom, $moyene, $note, $meilleur_travail){
    echo $GLOBALS['tr'];
    echo $GLOBALS['td'].  $nom  .$GLOBALS['td_end'];
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
/*     {
        $numargs = func_num_args();
        echo "Number of arguments: $numargs \n";
        if ($numargs >= 2) {
            echo "Second argument is: " . func_get_arg(1) . "\n";
        }
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            echo "Argument $i is: " . $arg_list[$i] . "\n";
        }
    } */




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
    echo "remises échecs";
    echo $GLOBALS['h2_end'];
    echo $GLOBALS['div'];
    echo $echecs;
    echo $GLOBALS['div_end'];
    echo $GLOBALS['div_end'];

    echo $GLOBALS['div'];
    echo $GLOBALS['h2'];
    echo "remises réussies";
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


/* function calculDesRemises($arr){
    $reussites = 0;
    $echecs = 0; 
    $vides = 0; 
    foreach ($arr as $note){
        if ($note >= 60){
            echo "note is (reussi): ".$note;
            $reussites ++;
        }
        if ($note == 0){
            echo "note is (vide): ".$note;
            $vides ++;
            //would this also count as an echec? 
        }
        if ($note <60 && $note > 0) {
            echo "note is (echec): ".$note;
            $echecs ++;
        }
    }
    $arr = array( "reussites" => $reussites, "echecs" => $echecs, "vides" => $vides);
    return $arr;
} */

//maybe you need to call something like this once befor you iterate through ALL the students
//just to create the template array (with the right number of homeworks and exams)
/* function calculUneRemise($arr){

    for ($i = 0; $i < count($arr); $i++){

        $newArr = array("reussites" => 0, "echecs" => 0, "vides" => 0);

        switch ($i){

            case ($arr[$i] >= 60):
                echo "note is (reussi): ".$note;
                $newArr["reussites"] = $newArr["reussites"] + 1;
                break;
        
            case ($arr[$i] == 0):
                echo "note is (vide): ".$note;
                $newArr["vides"] = $newArr["vides"] + 1;
                break;
                //would this also count as an echec? 

            case ($arr[$i] <60 && $note > 0):
                echo "note is (echec): ".$note;
                $newArr["echecs"] = $newArr["echecs"] + 1;
                break;
        }
    }
    $arr = array( "reussites" => $reussites, "echecs" => $echecs, "vides" => $vides);
    return $arr;
} */

//above, you should use a for loop instead
//use the iterator to name NO... don't name anything new...
//create your array at the end of the iteration, instead of 

//the problem with the following function is that there is 
//currently no array containing only the values of ONE travail
//or of ONE Examen... the calculUneRemise, actually combines ALL the 
//traveaux... SO... I need to include some of the logic in "calculUneRemise"
//so that we can output an array of one array per travail.
//so that the updated array is a two dimensional array, that keeps
//reussites, echecs and vide of each travail separate. 
//the total will be compiled but also two dimentionally... 


/* function calculRemisesTE($arrTotal, $arrAjout, $arrTE, $i){
    for ($i = 0; $i < count($arrTE); $i++){
        if ($i == 0){
            $arrTotal[0] = $arrAjout;
        }
        if ($i > 0){
            array_push($arrTotal, $arrAjout);
        }
    }
    return $arrTotal;
} */

















//functions to calculate
//a function to display the header
//a function to display the table
//what am I missing?



/* function calculReussites($arr){
    $reussites = array(array());
    array_pop($reussites);   
    foreach ($arr as $key => $value){
        for ($i = 1; $i < count($value); $i++){
            $pass = 0;
            for ($j = 0; $j < count($value[$i]); $j++)
                if ($value[$i][$j] >= 60){
                    $pass ++;
                }
            $reussites[$i-1][$j] = $pass;
            $pass = 0;
        }
    }
    echo var_dump($reussites[1]);
} 


calculReussites($notes);  */

/*function plusSouventReussi($arr){
    foreach ($arr as $value){

    }

} */

?>


