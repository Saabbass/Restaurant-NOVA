<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  echo "You are not logged in, please login. ";
  echo "<a href='login.php'>Login here</a>";
  exit;
}

// if ($_SESSION['rol'] != 'admin') {
//   echo "You are not allowed to view this page, please login as admin";
//   exit;
// }

//check method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "You are not allowed to view this page";
  exit;
}


$user_procesID = $_POST['reservation_number'];


if (
  isset($_POST['naam']) && isset($_POST['tafelnummer'])
  && isset($_POST['aantal_personen']) && isset($_POST['datum'])
  && isset($_POST['tijd'])
) {
  if (
    !empty($_POST['naam']) && !empty($_POST['tafelnummer'])
    && !empty($_POST['aantal_personen']) && !empty($_POST['datum'])
    && !empty($_POST['tijd'])
  ) {

    require 'database.php';

    $naam = $_POST['naam'];
    $tafelnummer = $_POST['tafelnummer'];
    $aantal_personen = $_POST['aantal_personen'];
    $datum = $_POST['datum'];
    $tijd = $_POST['tijd'];
    $data = $_SESSION['rol'];
    if ($data === 'admin' || $data === 'employee') {
      $gebruiker_id = $_POST['reservering_naam'];
    } else {
      $gebruiker_id = $_SESSION['user_id'];
    }

    $user_data =
      'naam=' . $naam .
      '&tafelnummer=' . $tafelnummer .
      '&aantal_personen=' . $aantal_personen .
      '&datum=' . $datum .
      '&tijd=' . $tijd;


    $sqlCheck = "SELECT * FROM reservering WHERE datum='$datum' and tafelnummer= :tafelnummer";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->bindParam(":tafelnummer", $tafelnummer);
    $stmt->execute();
    $resultCheck = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultCheck > 0) {
      header("Location: reservation_create.php?error=Deze datum of tafel zijn al gereserveerd&$user_data");
      exit();
    } else {
      // $sql = "INSERT INTO reservering(reservering_naam, tafelnummer, aantal_personen, datum, tijd, gebruiker_id) 
      // VALUES ('$naam', '$tafelnummer', '$aantal_personen', '$datum', '$tijd', '$gebruiker_id')"; //TODO: bindPArams van maken
      // $stmt = $conn->prepare($sql);

      $sql = "UPDATE reservering SET reservering_naam = :naam, tafelnummer = :tafelnummer, aantal_personen = :aantal_personen, datum = :datum, tijd = :tijd, gebruiker_id = :gebruiker_id WHERE reservering_nummer = :user_procesID";

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":naam", $naam);
      $stmt->bindParam(":tafelnummer", $tafelnummer);
      $stmt->bindParam(":aantal_personen", $aantal_personen);
      $stmt->bindParam(":datum", $datum);
      $stmt->bindParam(":tijd", $tijd);
      $stmt->bindParam(":gebruiker_id", $gebruiker_id);
      $stmt->bindParam(":user_procesID", $user_procesID);

      if ($stmt->execute()) {
        header("Location: reservation_index.php?success=Uw reservering is aangepast!");
        exit();
      } else {
        header("Location: reservation_create.php?id=$user_procesID&error=Unknown error occurred&$user_data");
        exit();
      }
    }
  } else {
    header("Location: reservation_update.php?id=$user_procesID&error=Er zijn één of meerdere velden leeg! Probeer opnieuw.");
    exit();
  }
} else {
  header("Location: reservation_update.php?id=$user_procesID&error=Er zijn velden niet correct ingevuld!");
  exit();
}
