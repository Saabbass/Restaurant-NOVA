<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

require 'database.php';

$id = $_GET['id'];
$main_user_id = $_SESSION['user_id'];

if ($_SESSION['rol'] === 'admin' || $id == $main_user_id) {

  $sql = "SELECT gebruiker_id, adres_id FROM gebruiker WHERE gebruiker_id = :id";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":id", $id);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $adresID = $result['adres_id'];

  if ($stmt->rowCount() > 0) {
    if ($id == $main_user_id) {
      $sql = "SELECT gebruiker_id FROM reservering WHERE gebruiker_id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($result > 0) {

        $sql = "DELETE FROM reservering WHERE gebruiker_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
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
            }
          } else {
            header("Location: user_index.php?error=Er is een fout opgetreden!");
            exit();
          }
        }
      } else {
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
          }
        } else {
          header("Location: user_index.php?error=Er is een fout opgetreden!");
          exit();
        }
      }
    } else {
      $sql = "SELECT gebruiker_id FROM reservering WHERE gebruiker_id = :id";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(":id", $id);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

      if ($result > 0) {

        $sql = "DELETE FROM reservering WHERE gebruiker_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
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
            }
          } else {
            header("Location: user_index.php?error=Er is een fout opgetreden!");
            exit();
          }
        }
      } else {
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
          }
        } else {
          header("Location: user_index.php?error=Er is een fout opgetreden!");
          exit();
        }
      }
    }
  }
} else {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin!";
  exit;
}
