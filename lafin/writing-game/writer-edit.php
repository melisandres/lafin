<?php
$pageName = "change yourself!";

if(!isset($_POST['id']) || $_POST['id']==null){
    header('location:index.php');
    exit;
}

$id = $_POST['id'];

require_once('class/Crud.php');
$crud = new Crud;
$selectId = $crud->selectId("writer", $id); 

extract($selectId);

include_once("snippets/header.html");
?>



    <form action="writer-update.php" method="post">
        <input type="hidden" name="id" value="<?=$id;?>">
        <label>first name
            <input type="text" name="firstName" value=<?=$firstName;?>>
        </label>
        <label>last name
            <input type="text" name="lastName" value=<?=$lastName;?>>
        </label>
        <label>email
            <input type="email" name="email" value=<?=$email;?> >
        </label>
        <label>birthday
            <input type="date" name="birthday" value=<?=$birthday;?> >
        </label>
        <input type="submit" value="save" >
    </form>
    <form action="writer-delete.php" method="POST">
        <input type="hidden" name="id" value="<?=$id;?>" >
        <input type="submit" value="delete" >
    </form>

    <?php 
    include_once("snippets/footer.html");
    ?>