<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  echo "You are not logged in, please login. ";
  echo "<a href='login.php'>Login here</a>";
  exit;
}

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin  of medewerker!";
  exit;
}
//check method
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
  echo "You are not allowed to view this page";
  exit;
}

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

$sql = "INSERT INTO product(product_naam, beschrijving, inkoopprijs, verkoopprijs, afbeelding, is_vega, aantal_vooraad, categorie_id) 
  VALUES (:naam, :beschrijving, :inkoopprijs, :verkoopprijs, :image, :is_vega, :aantal_vooraad, :categorie_id)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":naam", $naam);
$stmt->bindParam(":beschrijving", $beschrijving);
$stmt->bindParam(":inkoopprijs", $inkoopprijs);
$stmt->bindParam(":verkoopprijs", $verkoopprijs);
$stmt->bindParam(":image", $image);
$stmt->bindParam(":is_vega", $is_vega);
$stmt->bindParam(":aantal_vooraad", $aantal_vooraad);
$stmt->bindParam(":categorie_id", $categorie_id);
//TODO: bindPArams van maken

if ($stmt->execute()) {
  header("Location: product_index.php?success=Het product is toegevoegd!");
  exit();
} else {
  header("Location: product_create.php?error=Er is een onbekende fout opgetreden!");
  exit();
}
