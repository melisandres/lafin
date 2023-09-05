<?php

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
$crud->delete('writer', $id, "index");

?>