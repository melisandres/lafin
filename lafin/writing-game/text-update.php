<?php
require_once("class/Crud.php");
$crud = new Crud;

//FROM TEXT STORE:
//get the new keywords from POST, copy, and remove
$keywords = $_POST['keywords'];
unset($_POST['keywords']);


//NEW FOR THIS PAGE:
//get the previous keywords from POST, also remove
$lastKeywords = $_POST['lastKeywords'];
unset($_POST['lastKeywords']); 


//  √ 1. var_dump $keywords and previouskeywords... see how to make
//the structure the same for comparing
//strings
//  √ 2. check functions to compare and return elements only in previouskeywords
//   3. check functions to loop through to delete lines of text_has_keyword 
//where you check both the id of the word to delete AND the id of the text... 
//   4. once you've managed to delete these lines, you will be able to run the 
//code in delete, for deleting keywords that are not referenced in text_has_keyword.




//SIMILAR TO TEXT STORE, BUT WITH UPDATE:
//send what's left of the POST (text info) to CRUD

$update = $crud->update("text", $_POST);




//CHANGED from TEXT STORE:
//prepare keywords array... to send to CRUD

function prepareWords($words){
    echo $words;
    echo "<br>";
    $words = explode(',', $words);
    var_dump($words);
    echo "<br>";
    $cleanedWordArray = [];
    foreach ($words as $word) {
        $word = trim($word);
        if(!empty(trim($word))){
            array_push($cleanedWordArray, trim($word));
        }
    }
    return $cleanedWordArray;
}

$cleanedKeywords = prepareWords($keywords);
$cleanedLastKeywords = prepareWords($lastKeywords);
$wordsToCheck = array_diff($cleanedLastKeywords, $cleanedKeywords);



//FROM TEXT STORE-- except, we already did the trim
//each keyword needs to be treated:
foreach ($cleanedKeywords as $word) {
    //cleaned of spaces
    $assArr = ['word' => trim($word)];
    echo "<br> word to process: <br>";
    echo $word;
    echo "<br> what is the ass array? <br>";
    var_dump($assArr);

    //inserted into the keywords table, (if it isn't already there)
    $crud->insert('keyword', $assArr, true);
    //we need that keyword's id: but we must remember that it comes as an array
    $keywordIdFromInsert = $crud->selectWordId($assArr);
    //with that id, we can build an associative array to send to text_has_keyword
    $textHasKeywordArray = ['text_id' => $_POST['id'], 'keyword_id' => $keywordIdFromInsert['id']];
    //now we can insert this keyword into text_has_keyword
    $crud->insertTextHasKeyWord('text_has_keyword',  $textHasKeywordArray);
}




if(isset($wordsToCheck) && !empty($wordsToCheck)){

    foreach($wordsToCheck as $word){
        //delete text_has_id lines for keywords no longer used
        $crud->deleteTextHasKeyword($word, $_POST['id']);

        //I'm getting errors here: I should possibly combine these two to make
        $wordsToCheck = array_filter($wordsToCheck, function($word) {
            return !empty($word);
        });

        //get an associative array with the whole keyword line
        $keywordInfos = $crud->selectId('keyword', $word, 'word', 'writers-show');
        //with the id, check if the key is being used elsewhere, if not, delete from keywords
        $crud->deleteUnusedKeywords($keywordInfos['id']);
    }
    header("location:texts-show.php");
}else{
    header("location:texts-show.php");
}








/* echo "lastkeywords:<br>";
var_dump($lastKeywords);
echo "<br>";
echo "keywords:<br>";
var_dump($keywords);
echo "<br>";
echo "words to delete:<br>";
var_dump($wordsToDelete);
die(); */




?>




