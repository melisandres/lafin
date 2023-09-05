<?php
$pageName = "iterate!";

if(!isset($_POST['parent_id']) || $_POST['parent_id']==null){
    header('location:index.php');
    exit;
}

$parent_id = $_POST['parent_id'];

require_once('class/Crud.php');
$crud = new Crud;

//get writers
$selectWriters = $crud->selectWriters('writer', 'firstName', 'lastName', 'id');
extract($selectWriters);

//get the text
$selectText = $crud->selectIdText('text', $parent_id);


//get and treat the keywords
$selectKeywords = $crud->selectKeyword($parent_id);
$keywords = "";
foreach ($selectKeywords as $key => $value) {
    $keywords .= $value.", ";
}
trim(", ", $keywords);

//I can't remember why this has to come after the keywords
unset($selectText['parent_id']); 
extract($selectText);


include_once("snippets/header.html");
?>


<form action="text-store.php" method="post">

    <label for="writer-select">writer:</label>
    <select name="writer_id">
        <option value="">--Please choose an option--</option>

        <?php
        foreach ($selectWriters as $writer) {
            echo   "<option value=\"" . $writer['id'] . "\">" . $writer['firstName'] . " " . $writer['lastName'] . "</option>";
        }
    
        ?>

    </select>
    <span class="author">iterating on: <?=$selectText['firstName']." ".$selectText['lastName']?>'s words</span>
    <label>parent id: </label>
    <input type="hidden" name="parent_id" value="<?=$parent_id;?>">
    <label>title: 
        <input type="text" name="title" value="<?=$selectText['title']?>">
    </label>
    <label>write max 50 words: 
        <textarea name="writing" rows="10" cols="50"  value=""><?=$selectText['writing']?></textarea>
    </label>
    <label>you may edit the keywords, but do so with some forethought
        <input type="text" name="keywords" value="<?=$keywords?>">
    </label>
        <input type="hidden" name="date" value="<?= date("Y-m-d H:i:s") ?>">
    <input type="submit" value="save">
</form>
    

    
<?php
include_once("snippets/footer.html");
?>