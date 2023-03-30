<?php 
/*
* 582-11B-MA Epreuve Finale
*
* Mélisandre Schofield: 2395207
*/


$notes = array(
105 => [["Stein", "Gertrude"],[89, 59],[45, 90]],
106 => [["DeBeauvoir", "Simone"],[100, 100],[100, 99]],
107 => [["Atwood", "Margaret"],[52, 67],[0, 1]],
108 => [["Munro", "Alice"],[5, 0],[100, 32]],
109 => [["Didion", "Joan"],[90, 90],[90, 90]],
110 => [["Duras", "Marguerite"],[100, 100],[55, 34]],
);


echo "yay!";

function calculateMean($arr){
    $remisesTraveaux = array("reussites" => 0, "echecs" => 0, "vides" => 0);
    $remisesExamens = array ("reussites" => 0, "echecs" => 0, "vides" => 0);
    $remisesTotal = array("reussites" => 0, "echecs" => 0, "vides" => 0);
    $cour = array("reussites" => 0, "echecs" => 0);

    foreach ($arr as $key => $value){
        for ($i = 0; $i < 3; $i++){
            switch ($i){
                //are you currently looping through the name?
                case 0:
                    echo "name: ";
                    echo $value[$i][0]. ", ". $value[$i][1];
                    echo "<br>";
                    break;

                //are you currently looping through the TPs? 
                case 1:
                    calculePlusHauteNote($value[$i]);
                    $remisesTraveaux = calculeRemises($value[$i]);
                    echo "<br>remise de traveaux:<br>";
                    echo var_dump($remisesTraveaux);
                    echo "<br> remises totals: <br>";
                    $remisesTotal = updateRemises($remisesTotal, $remisesTraveaux);
                    echo var_dump($remisesTotal);
                    break;

                //are you currently looping though the exams? 
                case 2:
                    //create your exam reussite, echec, and void array
                    $remisesExamens = calculeRemises($value[$i]);
                    $remisesTotal = updateRemises($remisesTotal, $remisesExamens);

                    //make a function to calculate the mean dynamically? give it two arrays.  
                    $mean = ($value[$i-1][0] / 100 * 20) + ($value[$i-1][1] / 100 * 20) + ($value[$i][0] / 100 * 25) + ($value[$i][1] / 100 * 35);

                    //add your pass/fail values to an associative array for the class
                    if ($mean >= 60){
                        $cours["reussites"] ++;
                    }
                    else 
                        $cours["echecs"] ++;

                    echo "mean: ".$mean;
                    echo "<br>";
                    echo "Letter Grade: ".getLetterGrade($mean);
                    echo "<br>";
                    echo "<br>";
                    break;  

                }
        }
    }
    echo var_dump($remisesTotal);
}

calculateMean($notes);

function updateRemises($arrTotal, $arrAjout){
    // foreach ($arrTotal as $key => $value){
    //     $arrTotal[$value] += $arrAjout[$value];
    //     echo "meow";
    // }

    //this is fine, but it's only being run through once for travail, and once for exams... I need it to run through every value in the array... like the other functions do. 
    $echecs = $arrTotal["echecs"]; 
    $echecs += $arrAjout["echecs"];
    $arrTotal["echecs"] = $echecs;
    $echecs =0;

    $reussites = $arrTotal["reussites"]; 
    $reussites += $arrAjout["reussites"];
    $arrTotal["reussites"] = $reussites;
    $reussites =0;

    $vides = $arrTotal["vides"]; 
    $vides += $arrAjout["vides"];
    $arrTotal["vides"] = $vides;
    $vides =0; 

    // $arrTotal["reussites"] += $arrAjout["reussites"];
    // $arrTotal["echecs"] += $arrAjout["echecs"];
    // $arrTotal["vides"] += $arrAjout["vides"];
    return $arrTotal;
}






 function getLetterGrade($grade){
    switch ($grade){
        case ($grade >= 101):
            echo "erreur. Note plus grande que 100.";
            return;
        case ($grade >= 90):
            return "A";
        case ($grade >= 80):
            return "B";
        case ($grade >= 70):
            return "C";
        case ($grade >= 60):
            return "D";
        case ($grade >= 1):
            return "E";
        case ($grade == 0):
            return "Abs";
        // case default:
        //     return "error";
    }
}









 function calculePlusHauteNote($arr){
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
        echo "Best TP: travail ".$travail." & ".$travailEgale."---note: ".$plusHauteNote;
    }
    //rendre les infos pour la plus haute note.
    else 
        echo "Best TP: travail ".$travail."--- note: ".$plusHauteNote;
    }
    echo"<br>";
} 






function calculeRemises($arr){
    $reussites = 0;
    $echecs = 0; 
    $vides = 0; 
    foreach ($arr as $note){
        if ($note >= 60){
            echo "note is (reussi): ".$note;
            $reussites ++;
        }
        if ($note == ""){
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
}

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


