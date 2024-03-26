<?php

session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if (
  isset($_POST['voornaam'])
  && isset($_POST['achternaam']) && isset($_POST['land'])
  && isset($_POST['postcode']) && isset($_POST['woonplaats'])
  && isset($_POST['straat']) && isset($_POST['huisnummer'])
  && isset($_POST['wachtwoord']) && isset($_POST['check_wachtwoord'])
) {

  include("database.php");

  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  // $email = validate($_POST['email']);
  $user_procesID = $_POST['userID'];
  $voornaam = validate($_POST['voornaam']);
  if (isset(($_POST['tussenvoegsel']))) {
    $tussenvoegsel = validate($_POST['tussenvoegsel']);
  } else {
    $tussenvoegsel = '';
  }
  $achternaam = validate($_POST['achternaam']);
  $land = validate($_POST['land']);
  $postcode = validate($_POST['postcode']);
  $woonplaats = validate($_POST['woonplaats']);
  $straat = validate($_POST['straat']);
  $huisnummer = validate($_POST['huisnummer']);
  if (isset($_POST['toevoeging'])) {
    $toevoeging = validate($_POST['toevoeging']);
  } else {
    $toevoeging = '';
  }
  $pass = validate($_POST['wachtwoord']);
  $check_pass = validate($_POST['check_wachtwoord']);
  if (empty($_POST['rol'])){
  } else{
    $rol = $_POST['rol'];
  }

  $user_data =
    // 'email=' . $email .
    '&voornaam=' . $voornaam .
    '&tussenvoegsel=' . $tussenvoegsel .
    '&achternaam=' . $achternaam .
    '&land=' . $land .
    '&postcode=' . $postcode .
    '&woonplaats=' . $woonplaats .
    '&straat=' . $straat .
    '&huisnummer=' . $huisnummer .
    '&toevoeging=' . $toevoeging;

  if (empty($voornaam)) {
    header("Location: user_update.php?id=$user_procesID&error=voornaam is required&$user_data");
    exit();
  } else if (empty($achternaam)) {
    header("Location: user_update.php?id=$user_procesID&error=achternaam is required&$user_data");
    exit();
  } else if (empty($land)) {
    header("Location: user_update.php?id=$user_procesID&error=land is required&$user_data");
    exit();
  } else if (empty($postcode)) {
    header("Location: user_update.php?id=$user_procesID&error=postcode is required&$user_data");
    exit();
  } else if (empty($woonplaats)) {
    header("Location: user_update.php?id=$user_procesID&error=woonplaats is required&$user_data");
    exit();
  } else if (empty($straat)) {
    header("Location: user_update.php?id=$user_procesID&error=straat is required&$user_data");
    exit();
  } else if (empty($huisnummer)) {
    header("Location: user_update.php?id=$user_procesID&error=huisnummer is required&$user_data");
    exit();
  } else if (empty($pass)) {
    header("Location: user_update.php?id=$user_procesID&error=Password is required&$user_data");
    exit();
  } else if (empty($check_pass)) {
    header("Location: user_update.php?id=$user_procesID&error=Check password is required");
    exit();
  } else if ($pass !== $check_pass) {
    header("Location: user_update.php?id=$user_procesID&error=Password confirmation does not math");
    exit();
  } else {

    // password hashing
    $wachtwoord = password_hash($pass, PASSWORD_DEFAULT);
    // echo $password;
    // die;

    
    $sql = "SELECT gebruiker.gebruiker_id, gebruiker.rol, adres.adres_id FROM gebruiker INNER JOIN adres ON gebruiker.adres_id = adres.adres_id WHERE gebruiker.gebruiker_id = :user_procesID";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":user_procesID", $user_procesID);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (empty($rol) && $user['rol'] == 'customer') {
      $rol = 'customer';
    } else if (empty($rol) && $user['rol'] == 'admin') {
      $rol = 'admin';
    } else if (empty($rol) && $user['rol'] == 'employee') {
      $rol = 'employee';
    }

    $user_id = $user['gebruiker_id'];
    $user_adresID = $user['adres_id'];

    $sql = "UPDATE adres SET land = :land, postcode = :postcode, woonplaats = :woonplaats, straat = :straat, huisnummer = :huisnummer, toevoeging = :toevoeging WHERE adres_id = :user_adresID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":land", $land);
    $stmt->bindParam(":postcode", $postcode);
    $stmt->bindParam(":woonplaats", $woonplaats);
    $stmt->bindParam(":straat", $straat);
    $stmt->bindParam(":huisnummer", $huisnummer);
    $stmt->bindParam(":toevoeging", $toevoeging);
    $stmt->bindParam(":user_adresID", $user_adresID);
    // $stmt->execute();

    if ($stmt->execute()) {

      $sql = "UPDATE gebruiker SET gebruiker_voornaam = :voornaam, gebruiker_tussenvoegsel = :tussenvoegsel, gebruiker_achternaam = :achternaam, wachtwoord = :wachtwoord, rol = :rol WHERE gebruiker_id = :user_id AND adres_id = :user_adresID";

      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":voornaam", $voornaam);
      $stmt->bindParam(":tussenvoegsel", $tussenvoegsel);
      $stmt->bindParam(":achternaam", $achternaam);
      $stmt->bindParam(":wachtwoord", $wachtwoord);
      $stmt->bindParam(":rol", $rol);
      $stmt->bindParam(":user_id", $user_id);
      $stmt->bindParam(":user_adresID", $user_adresID);

      if ($stmt->execute()) {
        if ($_SESSION['rol'] == 'admin' || $_SESSION['rol'] == 'employee') {
          header("Location: user_index.php?success=Het account is aangepast!");
          exit();
        } else {
          header("Location: account_dashboard.php?success=Het account is aangepast!");
          exit();
        }
      } else {
        header("Location: user_index.php?error=Unknown error occurred&$user_data");
        exit();
      }
    } else {
      echo 'did not send user data';
    }
    // }
  }
} else {
  header("Location: user_index.php?error");
  exit();
}
