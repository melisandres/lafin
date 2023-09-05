<?php
$pageName = "show me!";

if(!isset($_GET['id']) || $_GET['id']==null){
    header('location:text-create.php');
    exit;
}

$id=$_GET['id'];


require_once('class/Crud.php');
$crud = new Crud;

$textInfo = $crud->selectIdText('text', $id);
$keywords = $crud->selectKeyword($id);


include_once("./snippets/header.html");
?>


    <h1><strong>author: </strong><span class="author"><?=$textInfo['firstName'] ." ". $textInfo['lastName'];?></span></h1>
    <p><strong>title: </strong><?=$textInfo['title'];?></p>
    <p><strong>date: </strong><?=$textInfo['date'];?></p>

    <?php
     if (isset($keywords) && is_array($keywords)){
        $i = 0;
        foreach ($keywords as $key => $value) {
            $i++;
            echo  "<p class='keyword' data-keyword-index=$key>keyword $i: $value</p>";
        }
    } 
    ?>


    <p><strong>text: </strong><?=$textInfo['writing'];?></p>



    <form action="text-delete.php" method="POST">
        <input type="hidden" name="id" value="<?=$id;?>" >
        <input type="submit" value="delete" >
    </form>
    <form action="text-edit.php" method="POST">
        <input type="hidden" name="id" value="<?=$id;?>" >
        <input type="submit" value="Mise a jour" >
    </form>
    <form action="text-iterate.php" method="POST">  
        <!--parent id is the id of the parent text-->    
        <input type="hidden" name="parent_id" value="<?=$id;?>" >
        <input type="submit" value="iterate" >
    </form>




<?php
    include_once("./snippets/footer.html");
?>