<?php 
/*
* 582-11B-MA Epreuve Finale
*
* Mélisandre Schofield: 2395207
*/

echo "Welcome: ".$_POST["name"]."</br></br>";
$notes = array(
105 => [["Stein", "Gertrude"],[89, 59],[45, 90]],
106 => [["DeBeauvoir", "Simone"],[100, 100],[100, 99]],
107 => [["Atwood", "Margaret"],[52, 67],[0, 1]],
108 => [["Munro", "Alice"],[5, 0],[100, 32]],
109 => [["Didion", "Joan"],[90, 90],[90, 90]],
110 => [["Duras", "Marguerite"],[100, 100],[55, 34]],
111 => [["Orzick", "Cynthia"], [0,0], [0,0]]
);



function calculateMean($arr){
    $arrTE = createDynamicArrays($arr);


    $remiseTravauxEtudiant = array("reussites" => 0, "echecs" => 0, "vides" => 0);
    $remisesTravauxClasse = $arrTE[0];
    echo var_dump($remisesTravauxClasse)."<br>does this work?";

    $remiseExamensEtudiant = array("reussites" => 0, "echecs" => 0, "vides" => 0);
    $remisesExamensClasse = $arrTE[1];

    $remisesTotals = array("reussites" => 0, "echecs" => 0, "vides" => 0);
    $cour = array("reussites" => 0, "echecs" => 0);

    foreach ($arr as $key => $value){
        for ($i = 0; $i < count($value); $i++){
            switch ($i){
                //looping through the name
                case 0:
                    echo "name: ";
                    echo $value[$i][0]. ", ". $value[$i][1];
                    echo "<br>";
                    break;

                //looping through the TPs 
                case 1:
                    calculPlusHauteNote($value[$i]);


                    $returnArr = calculDesRemises($value[$i], $remisesTravauxClasse);
                    $remiseTravauxEtudiant = $returnArr[0];
                    $remisesTravauxClasse = $returnArr[1];
                    echo "<br>";
                    echo "<br>".var_dump($remisesTravauxClasse)."remise Travaux CLass</br>";

                    $remisesTotals = calculTotalRemises($remisesTotals, $remiseTravauxEtudiant);
                    break;

                //looping though the exams 
                case 2:
                    $returnArr = calculDesRemises($value[$i], $remisesExamensClasse);
                    $remiseExamensEtudiant = $returnArr[0];
                    $remisesExamensClasse = $returnArr[1];

                    echo "<br>";
                    echo "<br>".var_dump($remisesExamensClasse)."remise Examens CLass</br>";

                    $remisesTotals = calculTotalRemises($remisesTotals, $remiseExamensEtudiant);

                    //make a function to calculate the mean dynamically? give it two arrays.  
                    $mean = ($value[$i-1][0] / 100 * 20) + ($value[$i-1][1] / 100 * 20) + ($value[$i][0] / 100 * 25) + ($value[$i][1] / 100 * 35);

                    //add your pass/fail values to an associative array for the class
                    if ($mean >= 60){
                        $cour["reussites"] ++;
                    }
                    else {
                        $cour["echecs"] ++;
                    }

                    echo "mean: ".$mean;
                    echo "<br>";
                    echo "Letter Grade: ".getLetterGrade($mean);
                    echo "<br>";
                    echo "<br>";
                    break;  

                }
        }
    }
    echo var_dump($remisesTotals);
    echo "total pass: ".$cour["reussites"];
    echo "total fail: ".$cour["echecs"];
}

/*calculateMean($notes);*/



function calculTotalRemises($arrTotal, $arrAjout){
    foreach ($arrTotal as $key => $value){
        $arrTotal[$key] += $arrAjout[$key];
    }
    return $arrTotal;
}

function createDynamicArrays($arr){
    $arrT = array();
    $arrE = array();
    $arrPush = array("reussites" => 0, "echecs" => 0, "vides" => 0);
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
                    array_push($arrT, $arrPush);
                }
                else {
                    //as you loop through exams, add an array for each
                    array_push($arrE, $arrPush);
                }
            }
            $loop = false;
        }
    } 
}
//would it be possible, while looping through, to check if... for instance, pass exists, 
//at arrT[$i] position (wherever I've found a pass...)and if it does not, just add it with a 
//value of 1? would that be less code heavy?

//this returns an array with the values from all the traveau, or all the examens
function calculDesRemises($arr, $arrTE){
    $reussites = 0;
    $echecs = 0; 
    $vides = 0; 
    for ($i = 0; $i < count($arr); $i++){
        echo $arr[$i]."this is the value being tested";
        if ($arr[$i] >= 60){
            echo "note is (reussi): ".$note;
            $reussites ++;
            $arrTE[$i]["reussites"] ++;
        }
        if ($arr[$i] == 0){
            echo "note is (vide): ".$note;
            $vides ++;
            $arrTE[$i]["vides"] ++;
            //would this also count as an echec? 
        }
        if ($arr[$i] <60 && $arr[$i] > 0) {
            echo "note is (echec): ".$note;
            $echecs ++;
            $arrTE[$i]["echecs"] ++;
        }
    }
    $arr = array( "reussites" => $reussites, "echecs" => $echecs, "vides" => $vides);
    return array($arr, $arrTE);
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
        echo "Best TP: travail ".$travail." & ".$travailEgale."---note: ".$plusHauteNote;
    }
    //rendre les infos pour la plus haute note.
    else 
        echo "Best TP: travail ".$travail."--- note: ".$plusHauteNote;
    }
    echo"<br>";
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


