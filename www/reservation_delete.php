<?php

require 'database.php';

$id = $_GET['id'];

$sql = "SELECT reservering_nummer FROM reservering WHERE reservering_nummer = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// if ($stmt->rowCount() > 0) {
if ($result > 0) {

  $sql = "DELETE FROM reservering WHERE reservering_nummer = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $id);

  if ($stmt->execute()) {
    header("Location: reservation_index.php?success=De reservering is geannuleerd!");
    exit();
  } else {
    header("Location: reservation_index.php?error=Er is een fout opgetreden!");
    exit();
  }
}
