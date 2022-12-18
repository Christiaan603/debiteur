<?php
echo '<h1>Nieuwe regel toevoegen</h1>';

if ($_POST) {
    include_once('openDB.php');
    echo "<h2>regel toevoegen.</h2>";
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $postalZip = $_POST['postalZip'];
    $region = $_POST['region'];
    $country = $_POST['country'];
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO debiteur (name, address, email, phone, postalZip, region, country)
                VALUES ('$name', '$address', '$email', '$phone', '$postalZip', '$region', '$country')";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "New record created successfully";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}

// formulier aanmaken
echo "
 <form action=\"new.php\" method='post'>
  <label for=\"fname\">name:</label><br>
  <input type=\"text\" id=\"name\" name=\"name\"><br>
  <label for=\"address\">address:</label><br>
  <input type=\"text\" id=\"address\" name=\"address\"><br>
  <label for=\"email\">email:</label><br>
  <input type=\"text\" id=\"email\" name=\"email\"><br>
  <label for=\"phone\">phone:</label><br>
  <input type=\"text\" id=\"phone\" name=\"phone\"><br>
  <label for=\"postalZip\">postalZip:</label><br>
  <input type=\"text\" id=\"postalZip\" name=\"postalZip\"><br>
  <label for=\"region\">region:</label><br>
  <input type=\"text\" id=\"region\" name=\"region\"><br>
  <label for=\"country\">country:</label><br>
  <input type=\"text\" id=\"country\" name=\"country\"><br><br>
  <input type=\"submit\" value=\"Wegschrijven\">
</form> 

<a href='debiteur.php'>Terug naar index</a>
";