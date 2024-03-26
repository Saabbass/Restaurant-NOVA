<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
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

$categorie_naam = $_POST['naam'];

$sql = "INSERT INTO categorie(categorie_naam) 
  VALUES (:categorie_naam)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":categorie_naam", $categorie_naam);

if ($stmt->execute()) {
  header("Location: menucategorie_index.php?success=De categorie is toegevoegd!");
  exit();
} else {
  header("Location: menucategorie_create.php?error=Er is een onbekende fout opgetreden!");
  exit();
}
