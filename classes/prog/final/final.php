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
<style>
    form{
        display: flex;
        flex-direction: column;
        justify-content: center;
        margin: 200px;
        /*https://getcssscan.com/css-box-shadow-examples*/
        box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;
    }

    input, textarea, label{
        flex-basis: 50%;
        display: block;
        margin: 0 100px;
        font-family: sans-serif;
        font-size: 15px;
    }
</style>
</head>
<body>



<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" target="_blank">
    <label for="name">name</label>
    <input type="text" name="name" id="name" required>
    <label for="password" name="password" id="password">password</label>
    <input type="password" required>
    <input type="submit" value="submit">
</form>


<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = test_input($_POST["name"]);
/*         $password = test_input($_POST["password"]); */
        include 'final_functions.php';
        calculateMean($notes, $passFailStructure, $notesABC, $ponderations, $noteDePassage);

    }
 
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


 ?>






<?php 

//create a form
//send that info to the next functions
//will the form disappear once you submit?

?>









    
</body>
</html>