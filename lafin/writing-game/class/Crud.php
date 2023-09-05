<?php

class Crud extends PDO{
    public function __construct(){
        parent::__construct('mysql:host=localhost; dbname=tag; port=8889; charset=utf8', 'root', '');
    }

    //returns every field from one table
    public function select($table, $field = 'id', $order = 'ASC'){
        $sql = "SELECT * FROM $table ORDER BY $field $order";
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }

    //returns elements in a table that match a specific search
    public function selectId($table, $value, $field='id', $url='writer-show'){
        $sql = "SELECT * FROM $table WHERE $field = :$field";
        //SELECT * FROM $table WHERE $field = :id
        //the : is a "bind" and creates a hidden variable inside... 
        
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $value);
        $stmt->execute();

        return $stmt->fetch();

/*         $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            trigger_error("Custom error message: value: $value and count: $count", E_USER_ERROR);
        } */
        //return $stmt->fetch();
    }

    //returns an array where the keys are keyword.id and the values are keyword.word. These values are only the ones associated to the text.id sent to the function
    public function selectKeyword($idValue, $field='id'){
        $sql = "SELECT word, id FROM keyword INNER JOIN text_has_keyword ON keyword_id = keyword.id WHERE text_id = :$field";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $idValue);
        $stmt->execute();

        $result = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['id']] = $row['word'];
        }
    
        return $result;
    }


    //returns all the text as well as the first and last name of the writer
    //associated to the current text via its id
    //I'm not using the variables I'm passing--this is a little confusing 
    //it might make sense to include the getting of the keywords here.
    public function selectIdText($table, $idValue, $field='id', $url='writer-show'){
        $sql = "SELECT text.*, writer.firstName AS firstName, 
                writer.lastName AS lastName
                FROM text INNER JOIN writer 
                ON text.writer_id = writer.id 
                WHERE $table.$field = :$field;";
        
        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $idValue);
        $stmt->execute();

        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            header("location:$url.php");
            exit;
        }
    }

    //returns the id of the keyword sent as the value of a one-item associative array
    //I'm iterating elsewhere and sending it here... but it may be better to combine functions
    public function selectWordId($assArr){
        $value = $assArr['word'];
        $sql = "SELECT id FROM keyword WHERE word = :word;";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(":word", $value);
        $stmt->execute();

        $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            exit;
        }
    }


    //returns all the keyword_ids associated to this current text.
    public function selectKeywordIds($id, $field='id'){
        $sql ="SELECT keyword_id
        FROM text_has_keyword
        WHERE text_id = :$field;";

        $stmt = $this->prepare($sql);
        $stmt->bindValue(":$field", $id);
        $stmt->execute();

        $count = $stmt->rowCount();
        if ($count >= 1){
            return $stmt->fetchAll();
        }
    }


    //I belive this is not being used... it seems like it would return a list
    //of the texts based on a writer's id I should work on it, to use it later
    public function selectText($table, $field = 'id'){
        $sql = "SELECT text.*, writer.firstName AS firstName, writer.lastName AS lastName
        FROM text
        INNER JOIN writer ON text.writer_id = writer.id;";


        //I need to make sure that I'm using : these to "prepare" my id... and other fields... but at the moment... it may be difficult with the dots. 
        
        $stmt = $this->prepare($sql);
        //$stmt->bindValue(":$field", $value);
        $stmt->execute();

        /* $count = $stmt->rowCount();
        if ($count == 1){
            return $stmt->fetch();
        }else{
            header("location:$url.php");
            exit;
        } */

        return $stmt->fetchAll();

    }




    //this returns a list of writers to populate the select field that 
    //gets generated in the create-text form
    public function selectWriters($table, $cell1, $cell2, $cell3){
        $sql = "SELECT $cell1, $cell2, $cell3 FROM $table";
        
        $stmt = $this->query($sql);
        return $stmt->fetchAll();
    }


    //this can get called to insert text OR keywords.
    public function insert($table, $data, $keyWordInsert = false){
        $fieldName = implode(', ', array_keys($data));
        $fieldValue = ":".implode(', :', array_keys($data));
        $fieldName = trim($fieldName, ", ");
        $keywordExtra = "";
        if ($keyWordInsert){
            $keywordExtra = "ON DUPLICATE KEY UPDATE word = VALUES(word)";
        }

        $sql = "INSERT INTO $table ($fieldName) VALUES ($fieldValue) $keywordExtra";

        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
        }

 /*       $stmt->execute();

        return $this->lastInsertId();

         if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
        } */
    }

    //this is specific for inserting text_has_keyword entry
    public function insertTextHasKeyWord($table, $data){
        $keyword_id = $data['keyword_id'];
        $text_id = $data['text_id'];
        $fieldName = implode(', ', array_keys($data));
        $fieldValue = ":".implode(', :', array_keys($data));
        

        $sql = "INSERT INTO $table ($fieldName) VALUES ($fieldValue) 
        ON DUPLICATE KEY UPDATE
            keyword_id = VALUES(keyword_id),
            text_id = VALUES(text_id);";

        $stmt = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if($stmt->execute()){
            return $this->lastInsertId();
        }else{
            print_r($stmt->errorInfo());
        }
    }

    //this gets called to do a simple delete, based on an id of
    //the item being deleted
    public function delete($table, $value, $url, $field='id'){
        $sql = "DELETE FROM $table WHERE $field = :$field;";
        $stmt = $this->prepare($sql); 
        $stmt->bindValue(":$field", $value);
        $stmt->execute(); 

        header("location:$url.php");
    }

    //receiving keywords on the update page, and checking which ones were previously entered but have now been modified or deleted, here we delete
    public function deleteTextHasKeyword($word, $id){

        $sql = "DELETE text_has_keyword FROM text_has_keyword
                INNER JOIN keyword  ON text_has_keyword.keyword_id = keyword.id
                WHERE word = :word;
                AND text_has_keyword.text_id = :id;";

        $stmt = $this->prepare($sql); 
        $stmt->bindValue(":word", $word);
        $stmt->bindValue(":id", $id);
        $stmt->execute(); 
    }

    //this gets called from a loop, perhaps I should add the 
    //loop in this function. The value sent is an associative array
    //of one element. Technically, I could change the sql statement, 
    //to make it work with other unused lists... $value key is keyword_id, 
    //and so the sql could be populated dynamically. But will I use this
    //sort of function elsewhere?
    public function deleteUnusedKeywords($value, $field = 'id'){
        $sql = "DELETE FROM keyword
                WHERE id = :$field
                AND NOT EXISTS (
                    SELECT 1
                    FROM text_has_keyword
                    WHERE keyword_id = :$field
                    );";
        $stmt = $this->prepare($sql); 
        $stmt->bindValue(":$field", $value);
        $stmt->execute();   
    }




    //this is dynamic. it updates with all the elements
    //in the POST (or $data) using keys and values to build 
    //the sql query. 
    public function update($table, $data, $field = 'id'){
        $fieldName = null;

        foreach ($data as $key => $value) {
            $fieldName .= "$key = :$key, "; 
        }

        $fieldName = rtrim($fieldName, ", ");

        $sql = "UPDATE $table SET $fieldName WHERE $field = :$field;";



        $stmt = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);

        }

        $stmt->execute();

/*         if(){
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }else{
            print_r($stmt->errorInfo());
        } */

    }

}

?>