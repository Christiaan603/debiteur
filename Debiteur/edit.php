<?php

// file been called by /delete.php?id={id}   $_GET['id']
echo '<h1>Update van id ' . $_GET['id'] . '<h1>';

include_once('openDB.php');

echo "<p><a href='debiteur.php'>terug naar index</a></p>";

if ($_GET['id']) {
    $id = $_GET['id'];
    try {
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM debiteur WHERE id=$id");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($stmt->fetchAll() as $k => $v) {
            $id = $v['id'];
            $email = $v['email'];
            $fname = $v['voornaam'];
            $mname = $v['tussenvoegsel'];
            $lname = $v['achternaam'];
            $currency = $v['currency'];
            echo "
             <form action=\"edit.php\" method='post'>
              <label for=\"id\">id:</label><br>
              <input type=\"text\" id=\"id\" name=\"id\" value='$id'><br>
              <label for=\"email\">email:</label><br>
              <input type=\"text\" id=\"email\" name=\"email\" value='$email'><br>
              <label for=\"fname\">fname:</label><br>
              <input type=\"text\" id=\"fname\" name=\"fname\" value='$fname'><br>
              <label for=\"mname\">mname:</label><br>
              <input type=\"text\" id=\"mname\" name=\"mname\" value='$mname'><br>
              <label for=\"lname\">lname:</label><br>
              <input type=\"text\" id=\"lname\" name=\"lname\" value='$lname'><br>
              <label for=\"currency\">currency:</label><br>
              <input type=\"text\" id=\"currency\" name=\"currency\" value='$currency'><br>
              <input type=\"submit\" value=\"Wegschrijven\">
            </form> 
            
            <a href='index.php'>Terug naar index</a>
            ";
        }

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}

if ($_POST) {
    try {
        $id = $_POST['id'];
        $email = $_POST['email'];
        $voornaam = $_POST['voornaam'];
        $tussenvoegsel = $_POST['tussenvoegsel'];
        $achternaam = $_POST['achternaam'];
        $currency = $_POST['currency'];
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE debiteur 
                    SET 
                        email='$email',
                        voornaam='$voornaam',
                        tussenvoegsel='$tussenvoegsel',
                        achternaam='$achternaam',
                        currency='$currency',
                WHERE id=$id";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        echo $stmt->rowCount() . " records UPDATED successfully";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}