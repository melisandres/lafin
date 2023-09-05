<?php
$pageName = "this is you!";

if(!isset($_GET['id']) || $_GET['id']==null){
    header('location:writer-create.php');
    exit;
}

$id=$_GET['id'];


require_once('class/Crud.php');
$crud = new Crud;

$selectId = $crud->selectId('writer', $id);

extract($selectId);


include_once("./snippets/header.html");
?>



    <p><strong>first name: </strong><?=$firstName;?></p>
    <p><strong>last name: </strong><?=$lastName;?></p>
    <p><strong>email: </strong><?=$email;?></p>

    <form action="writer-delete.php" method="POST">
        <input type="hidden" name="id" value="<?=$id;?>" >
        <input type="submit" value="delete" >
    </form>
    <form action="writer-edit.php" method="POST">
        <input type="hidden" name="id" value="<?=$id;?>" >
        <input type="submit" value="Mise a jour" >
    </form>



<?php
    include_once("./snippets/footer.html");
?>