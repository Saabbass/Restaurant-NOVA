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


$categorie_procesID = $_POST['categorie_procesID'];


if (
  isset($_POST['naam'])
) {
  if (
    !empty($_POST['naam'])
  ) {

    require 'database.php';

    $naam = $_POST['naam'];

    $sql = "UPDATE categorie SET categorie_naam = :naam WHERE categorie_id = :categorie_procesID";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":naam", $naam);
    $stmt->bindParam(":categorie_procesID", $categorie_procesID);

    if ($stmt->execute()) {
      header("Location: menucategorie_index.php?success=Het categorie is toegevoegd!");
      exit();
    } else {
      header("Location: menucategorie_update.php?error=Er is een onbekende fout opgetreden!");
      exit();
    }
  } else {
    header("Location: menucategorie_update.php?id=$categorie_procesID&error=Er zijn één of meerdere velden leeg! Probeer opnieuw.");
    exit();
  }
} else {
  header("Location: menucategorie_update.php?id=$categorie_procesID&error=Er zijn velden niet correct ingevuld!");
  exit();
}
