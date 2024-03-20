<?php

require 'database.php';

$id = $_GET['id'];

$sql = "SELECT gebruiker_id, adres_id FROM gebruiker WHERE gebruiker_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$adresID = $result['adres_id'];

if ($stmt->rowCount() > 0) {

  $sql = "DELETE FROM gebruiker WHERE gebruiker_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $id);
  if ($stmt->execute()) {

    $sql = "DELETE FROM adres WHERE adres_id = :adresID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":adresID", $adresID);
    if ($stmt->execute()) {
      header("Location: user_index.php?success=Het acount is verwijderd!");
      exit();
    } else {
      header("Location: user_index.php?error=Er is een fout opgetreden!");
      exit();
    }
  }
}
