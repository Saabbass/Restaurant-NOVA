<?php
session_start();

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


$product_procesID = $_POST['product_procesID'];


if (
  isset($_POST['naam']) && isset($_POST['beschrijving'])
  && isset($_POST['inkoopprijs']) && isset($_POST['verkoopprijs'])
  && isset($_POST['is_vega']) && isset($_POST['aantal_vooraad'])
  && isset($_POST['categorie']) && isset($_FILES['image']['name'])
) {
  if (
    !empty($_POST['naam']) && !empty($_POST['beschrijving'])
    && !empty($_POST['inkoopprijs']) && !empty($_POST['verkoopprijs'])
    && !empty($_POST['is_vega']) && !empty($_POST['aantal_vooraad'])
    && !empty($_POST['categorie']) && !empty($_FILES['image']['name'])
  ) {

    require 'database.php';

    $naam = $_POST['naam'];
    $beschrijving = $_POST['beschrijving'];
    $inkoopprijs = $_POST['inkoopprijs'];
    $verkoopprijs = $_POST['verkoopprijs'];
    $is_vega = $_POST['is_vega'];
    $aantal_vooraad = $_POST['aantal_vooraad'];
    $categorie_id = $_POST['categorie'];
    $image = $_FILES['image']['name'];

    //TODO: Warning: Cannot modify header information - headers already sent by (output started at /var/www/html/product_create_file_upload.php:12) in /var/www/html/product_create_session.php on line 40
    include 'product_create_file_upload.php';

    $sql = "UPDATE product SET product_naam = :naam, beschrijving = :beschrijving, inkoopprijs = :inkoopprijs, verkoopprijs = :verkoopprijs, afbeelding = :afbeelding, is_vega = :is_vega, aantal_vooraad = :aantal_vooraad, categorie_id = :categorie_id WHERE product_id = :product_procesID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":naam", $naam);
    $stmt->bindParam(":beschrijving", $beschrijving);
    $stmt->bindParam(":inkoopprijs", $inkoopprijs);
    $stmt->bindParam(":verkoopprijs", $verkoopprijs);
    $stmt->bindParam(":afbeelding", $image);
    $stmt->bindParam(":is_vega", $is_vega);
    $stmt->bindParam(":aantal_vooraad", $aantal_vooraad);
    $stmt->bindParam(":categorie_id", $categorie_id);
    $stmt->bindParam(":product_procesID", $product_procesID);

    if ($stmt->execute()) {
      header("Location: product_index.php?success=Het product is toegevoegd!");
      exit();
    } else {
      header("Location: product_update.php?error=Er is een onbekende fout opgetreden!");
      exit();
    }
  } else {
    header("Location: product_update.php?id=$product_procesID&error=Er zijn één of meerdere velden leeg! Probeer opnieuw.");
    exit();
  }
} else {
  header("Location: product_update.php?id=$product_procesID&error=Er zijn velden niet correct ingevuld!");
  exit();
}
