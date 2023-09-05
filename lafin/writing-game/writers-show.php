<?php
$pageName = "our community!";
require_once('class/Crud.php');

$crud = new Crud;
$select = $crud->select('writer');
extract($select);

include_once("./snippets/header.html"); ?>


<table>
        <tr>
            <th>first name</th>
            <th>last name</th>
            <th>email</th>
        </tr>
        <?php
        foreach($select as $row){
        ?>
        <tr>
            <td><a href="writer-show.php?id=<?= $row['id']?>"> <?= $row['firstName']; ?></a></td>
            <td><?= $row['lastName']; ?></td>
            <td><?= $row['email']; ?></td>
        </tr>
        <?php
        }
        ?>


    </table>






<?php include_once("./snippets/footer.html"); ?>