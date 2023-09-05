<?php

require_once('class/Crud.php');
$crud = new Crud;


//get the keywords from POST
$keywords = $_POST['keywords'];
//remove the keywords from POST
unset($_POST['keywords']);


//send what's left of the POST (text info) to CRUD
$textIdFromInsert = $crud->insert('text', $_POST);



//prepare keywords array... to send to CRUD
$keywords = explode(',', $keywords);


//each keyword needs to be treated:
foreach ($keywords as $word) {
    //cleaned of spaces
    $assArr = ['word' => trim($word)];
    //inserted into the keywords table, (if it isn't already there)
    $crud->insert('keyword', $assArr, true);
    //we need that keyword's id: but we must remember that it comes as an array
    $keywordIdFromInsert = $crud->selectWordId($assArr);
    //with that id, we can build an associative array to send to text_has_keyword
    $textHasKeywordArray = ['text_id' => $textIdFromInsert, 'keyword_id' => $keywordIdFromInsert['id']];
    //now we can insert this keyword into text_has_keyword
    $crud->insert('text_has_keyword',  $textHasKeywordArray);
}



header("location:text-show.php?id=$textIdFromInsert");
?>