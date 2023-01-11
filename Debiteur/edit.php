<?php

// file been called by /delete.php?id={id}   $_GET['id']


include_once('openDB.php');

echo "<p><a href='index.php'>terug naar index</a></p>";

if (isset($_GET['id'])) {
    echo '<h1>Update van id ' . $_GET['id'] . '<h1>';
    $id = $_GET['id'];
    try {
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $conn->prepare("SELECT * FROM debiteur WHERE Id=$id");
        $stmt->execute();

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        foreach ($stmt->fetchAll() as $k => $v) {
            $email = htmlspecialchars($v['email']);
            $voornaam = $v['voornaam'];
            $tussen = $v['tussenvoegsel'];
            $achternaam = $v['achternaam'];
            $totaal = $v['totaal'];
            echo "
             <form action=\"edit.php\" method='post'>

              <label for=\"id\">id:</label><br>
              <input type=\"text\" id=\"id\" name=\"id\" value='$id'><br>

              <label for=\"email\">Email:</label><br>
              <input type=\"text\" id=\"email\" name=\"email\" value='$email'><br>

              <label for=\"voornaam\">Voornaam:</label><br>
              <input type=\"text\" id=\"voornaam\" name=\"voornaam\" value='$voornaam'><br>

              <label for=\"tussenvoegsel\">Tussenvoegsel:</label><br>
              <input type=\"text\" id=\"tussenvoegsel\" name=\"tussenvoegsel\" value='$tussen'><br>
              
              <label for=\"achternaam\">Achternaam:</label><br>
              <input type=\"text\" id=\"achternaam\" name=\"achternaam\" value='$achternaam'><br>
              
              <label for=\"Totaal\">Totaal:</label><br>
              <input type=\"text\" id=\"Totaal\" name=\"Totaal\" value='$totaal'><br>

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
        $tussen = $_POST['tussenvoegsel'];
        $achternaam = $_POST['achternaam'];
        $totaal = $_POST['Totaal'];
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE debiteur
                    SET 
                        email= :email,
                        voornaam= :voornaam, 
                        tussenvoegsel= :tussenvoegsel,
                        achternaam= :achternaam,
                        Totaal= :Totaal
                WHERE Id=$id";

        // Prepare statement
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":voornaam", $voornaam);
        $stmt->bindParam(":tussenvoegsel", $tussen);
        $stmt->bindParam(":achternaam", $achternaam);
        $stmt->bindParam(":Totaal", $totaal);
        // execute the query
        $stmt->execute();

        // echo a message to say the UPDATE succeeded
        echo $stmt->rowCount() . " records UPDATED successfully";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
