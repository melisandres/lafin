<?php
//some earlier notes on how to check errors:
/* $sql = "DELETE FROM client WHERE id = ?";
extract($_GET);
require_once("db/connex.php");
$stmt = $pdo->prepare($sql);
if($stmt->execute(array($id))){
    echo "SUCCESS!";
}else{
    print_r($stmt->errorInfo());
} */

$id = $_POST['id']; 
require_once('class/Crud.php');
$crud = new Crud;

//$keyWordIds is given an associative array where all keys are "keyword_id"
//it is empty if there are no keywords in the given text.
$keyWordIds = $crud->selectKeywordIds($id);

//check if there are any keywords... and if so
if(isset($keyWordIds)){
    //delete ALL text_has_keyword entries
    $crud->delete('text_has_keyword', $id, "texts-show", "text_id");
    //delete the keywords, if they aren't being used by other text_has_keyword
    foreach ($keyWordIds as $key => $value) {
        $crud->deleteUnusedKeywords($value);
    }
}
//delete the text entry
$crud->delete('text', $id, "texts-show");



?>