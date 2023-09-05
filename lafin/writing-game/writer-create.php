<?php
$pageName = "who are you?";
include_once("snippets/header.html");

?>


    <form action="writer-store.php" method="post">
        <label>first name
            <input type="text" name="firstName">
        </label>
        <label>last name
            <input type="text" name="lastName">
        </label>
        <label>password
            <input type="password" name="password">
        </label>
        <label>email
            <input type="email" name="email">
        </label>
        <label>birthday
            <input type="date" name="birthday">
        </label>
        <input type="submit" value="save">
    </form>
    

    
<?php
include_once("snippets/footer.html");
?>