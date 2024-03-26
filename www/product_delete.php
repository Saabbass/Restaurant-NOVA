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

require 'database.php';

$id = $_GET['id'];

$sql = "SELECT product_id FROM product WHERE product_id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

// if ($stmt->rowCount() > 0) {
if ($result > 0) {

  $sql = "DELETE FROM product WHERE product_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $id);

  if ($stmt->execute()) {
    header("Location: product_index.php?success=Het item is verwijderd!");
    exit();
  } else {
    header("Location: product_index.php?error=Er is een fout opgetreden!");
    exit();
  }
}
