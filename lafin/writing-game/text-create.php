<?php
$pageName = "write!";
include_once("snippets/header.html");

require_once('class/Crud.php');
$crud = new Crud;

$selectWriters = $crud->selectWriters('writer', 'firstName', 'lastName', 'id');

extract($selectWriters);

?>


    <form action="text-store.php" method="post">

    <label for="writer-select">writer:</label>
    <select name="writer_id">
        <option value="">--Please choose an option--</option>

        <?php
        foreach ($selectWriters as $writer) {
            echo   "<option value=".$writer['id'].">".$writer['firstName']." ".$writer['lastName']."</option>";
        }
        
        ?>

        </select>


        <label>title
            <input type="text" name="title">
        </label>
        <label>write max 50 words: 
            <textarea name="writing" rows="10" cols="50"></textarea>
        </label>
        <label>keywords (max 3, seperated by commas please)
            <input type="text" name="keywords">
        </label>
        </label>
            <input type="hidden" name="date" value="<?= date("Y-m-d H:i:s") ?>">
        <input type="submit" value="save">
    </form>
    

    
<?php
include_once("snippets/footer.html");
?>