<?php 
/*
* 582-11B-MA Epreuve Finale
*
* Mélisandre Schofield: 2395207
*/
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>final</title>
    <link rel="stylesheet" href="styles/style.css">
    
<style>
</style>
</head>
<body>



<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
        include 'final_functions.php';
        calculateMean($studentData, $passFailStructure, $gradesABC, $ponderations, $passingGrade);
    }
    else {
        echo '<form action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '" method="post" target="_blank">
        <label for="name">name</label>
        <input type="text" name="name" id="name" required>
        <label for="password" name="password" id="password">password</label>
        <input type="password" required>
        <input type="submit" value="submit">
        </form>';
      }

 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


 ?>
    
</body>
</html>