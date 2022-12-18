<?php
echo "<h1>testen</h1>";

echo "<a href='new.php'>Nieuw</a>";
echo "<table style='border: solid 1px black;'>";
$id = 'id';
$email= 'email';
$voornaam = 'voornaam';
$tussenvoegsel = 'tussenvoegsel';
$achternaam = 'achternaam';
$currency = 'currency';
echo '<tr><th>'.$id.'</th><th>'.$email.'</th><th>'.$voornaam.'</th><th>'.$tussenvoegsel.'</th><th>'.$achternaam.'</th><th>'.$currency.'</th><th>Action</th></tr>';

class TableRows extends RecursiveIteratorIterator {
  function __construct($it) {
    parent::__construct($it, self::LEAVES_ONLY);
  }

  function current() {
    return "<td style='width:150px;border:1px solid black;'>" . parent::current(). "</td>";
  }

  function beginChildren() {
    echo "<tr>";
  }

  function endChildren() {
    echo "</tr>" . "\n";
  }
}

include_once ('openDB.php');

try {
  $stmt = $conn->prepare("SELECT * FROM debiteur");
  $stmt->execute();

  // set the resulting array to associative
  $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
  foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
    echo $v;
    if ($k=='id') {
      $id = strip_tags($v);
      $e= 'edit.php?id='.$id;
    }
    if ($k=='currency') {
      echo "<td><a href='$e'>E</a></td>";
    }
  }
} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";

echo "<a href='new.php'>Nieuw</a>";
?>