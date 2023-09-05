<?php
require_once('class/Crud.php');
$crud = new Crud;

$insert = $crud->insert('writer', $_POST);

echo $insert;

header("location:writer-show.php?id=$insert");
?>