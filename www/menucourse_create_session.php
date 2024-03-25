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

$menugang_naam = $_POST['naam'];

$sql = "INSERT INTO menugang(menugang_naam) 
  VALUES (:menugang_naam)";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":menugang_naam", $menugang_naam);

if ($stmt->execute()) {
  header("Location: product_index.php?success=Het product is toegevoegd!");
  exit();
} else {
  header("Location: product_create.php?error=Er is een onbekende fout opgetreden!");
  exit();
}
