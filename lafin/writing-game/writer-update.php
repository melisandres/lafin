<?php

$id = $_POST['id'];

require_once("class/Crud.php");
$crud = new Crud;
$update = $crud->update("writer", $_POST);
header("location:writer-show.php?id=$id");


?>