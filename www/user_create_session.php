<?php
session_start();
include("database.php");

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin of medewerker!";
  exit;
}
//check method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "You are not allowed to view this page";
  exit;
}

if (
  isset($_POST['email']) && isset($_POST['voornaam'])
  && isset($_POST['achternaam']) && isset($_POST['land'])
  && isset($_POST['postcode']) && isset($_POST['woonplaats'])
  && isset($_POST['straat']) && isset($_POST['huisnummer'])
  && isset($_POST['wachtwoord']) && isset($_POST['check_wachtwoord'])
) {

  function validate($data)
  {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

  $email = validate($_POST['email']);
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
  if (isset(($_POST['toevoeging']))) {
    $toevoeging = validate($_POST['toevoeging']);
  } else {
    $toevoeging = '';
  }
  $pass = validate($_POST['wachtwoord']);
  $check_pass = validate($_POST['check_wachtwoord']);
  $rol = validate($_POST['rol']);

  $user_data =
    'email=' . $email .
    '&voornaam=' . $voornaam .
    // '&tussenvoegsel=' . $tussenvoegsel .
    '&achternaam=' . $achternaam .
    '&land=' . $land .
    '&postcode=' . $postcode .
    '&woonplaats=' . $woonplaats .
    '&straat=' . $straat .
    '&huisnummer=' . $huisnummer
    // '&toevoeging=' . $toevoeging
  ;

  if (empty($email)) {
    header("Location: user_create.php?error=Email-address is required&$user_data");
    exit();
  } else if (empty($voornaam)) {
    header("Location: user_create.php?error=voornaam is required&$user_data");
    exit();
    // } else if (empty($tussenvoegsel)) {
    //   header("Location: user_create.php?error=tussenvoegsel is required&$user_data");
    //   exit();
  } else if (empty($achternaam)) {
    header("Location: user_create.php?error=achternaam is required&$user_data");
    exit();
  } else if (empty($land)) {
    header("Location: user_create.php?error=land is required&$user_data");
    exit();
  } else if (empty($postcode)) {
    header("Location: user_create.php?error=postcode is required&$user_data");
    exit();
  } else if (empty($woonplaats)) {
    header("Location: user_create.php?error=woonplaats is required&$user_data");
    exit();
  } else if (empty($straat)) {
    header("Location: user_create.php?error=straat is required&$user_data");
    exit();
  } else if (empty($huisnummer)) {
    header("Location: user_create.php?error=huisnummer is required&$user_data");
    exit();
    // } else if (empty($toevoeging)) {
    //   header("Location: user_create.php?error=toevoeging is required&$user_data");
    //   exit();
  } else if (empty($pass)) {
    header("Location: user_create.php?error=Password is required&$user_data");
    exit();
  } else if (empty($check_pass)) {
    header("Location: user_create.php?error=Check password is required");
    exit();
  } else if ($pass !== $check_pass) {
    header("Location: user_create.php?error=Password confirmation does not math");
    exit();
  } else {

    // password hashing
    $password = password_hash($pass, PASSWORD_DEFAULT);
    // echo $password;
    // die;

    $sqlCheck = "SELECT * FROM gebruiker WHERE email='$email'";
    $stmt = $conn->prepare($sqlCheck);
    $stmt->execute();
    $resultCheck = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultCheck > 0) {
      header("Location: user_create.php?error=This email-address is already in use&$user_data");
      exit();
    } else {
      $sql = "INSERT INTO adres(land, postcode, woonplaats, straat, huisnummer, toevoeging) 
      VALUES (:land, :postcode, :woonplaats, :straat, :huisnummer, :toevoeging)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":land", $land);
      $stmt->bindParam(":postcode", $postcode);
      $stmt->bindParam(":woonplaats", $woonplaats);
      $stmt->bindParam(":straat", $straat);
      $stmt->bindParam(":huisnummer", $huisnummer);
      $stmt->bindParam(":toevoeging", $toevoeging);


      if ($stmt->execute()) {
        $adres_id = $conn->lastInsertId();

        $sql = "INSERT INTO gebruiker(email, gebruiker_voornaam, gebruiker_tussenvoegsel, gebruiker_achternaam, wachtwoord, rol, adres_id) VALUES(:email, :voornaam, :tussenvoegsel, :achternaam, :password, :rol, :adres_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":voornaam", $voornaam);
        $stmt->bindParam(":tussenvoegsel", $tussenvoegsel);
        $stmt->bindParam(":achternaam", $achternaam);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":rol", $rol);
        $stmt->bindParam(":adres_id", $adres_id);

        if ($stmt->execute()) {
          header("Location: user_index.php?success=Uw account is aangemaakt!");
          exit();
        } else {
          header("Location: user_create.php?error=Unknown error occurred&$user_data");
          exit();
        }
      } else {
        echo 'did not send user data';
      }
    }
  }
} else {
  header("Location: user_create.php?error");
  exit();
}
