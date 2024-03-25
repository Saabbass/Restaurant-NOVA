<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
  require 'database.php';

  $sql = "SELECT * FROM reservering INNER JOIN gebruiker ON reservering.gebruiker_id = gebruiker.gebruiker_id";

  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'customer')) {
  require 'database.php';

  $user_id = $_SESSION['user_id'];

  $sql = "SELECT * FROM reservering INNER JOIN gebruiker ON reservering.gebruiker_id = gebruiker.gebruiker_id WHERE gebruiker.gebruiker_id = :user_id";
  // $sql = "SELECT * FROM gebruiker INNER JOIN reservering ON gebruiker.gebruiker_id = reservering.gebruiker_id WHERE gebruiker.gebruiker_id = :user_id";

  $stmt = $conn->prepare($sql);
  $stmt->bindParam(":user_id", $user_id);
  $stmt->execute();

  $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // header("Location: index.php");
  // exit();
}

?>

<!-- begin ingoegen van navbar / header -->
<?php
require 'header.php';
?>
<!-- einde invoegen van navbar / header -->
<section class="home_main">
  <section class="container_img">
    <div class="container">
      <div class="container_width">
        <section class="container_scroll">
          <div class="scroll_top">
            <a class="btn-info" href="reservation_create.php">Maak reservering aan</a>
            <div>
              <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
              <?php } ?>
            </div>
            <div>
              <?php if (isset($_GET['success'])) { ?>
                <p class="success"><?php echo $_GET['success']; ?></p>
              <?php } ?>
            </div>
          </div>
          <table>
            <thead>
              <tr>
                <th>Nummer</th>
                <th>Naam</th>
                <th>Datum</th>
                <th>Tijd</th>
                <th>Aantal personen</th>
                <th>Tafelnummer</th>
                <th>Gebruikers nummer</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reservations as $reservation) : ?>
                <tr>
                  <td><?php echo $reservation['reservering_nummer'] ?></td>
                  <td><?php echo $reservation['reservering_naam'] ?></td>
                  <td><?php echo $reservation['datum'] ?></td>
                  <td><?php echo $reservation['tijd'] ?></td>
                  <td><?php echo $reservation['aantal_personen'] ?></td>
                  <td><?php echo $reservation['tafelnummer'] ?></td>
                  <td><?php echo $reservation['gebruiker_id'] ?></td>
                  <td>
                    <a href="reservation_delete.php?id=<?php echo $reservation['reservering_nummer'] ?>" class="btn-delete">delete</a>
                    <a href="reservation_update.php?id=<?php echo $reservation['reservering_nummer'] ?>" class="btn-update">update</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </section>
      </div>
    </div>
  </section>
</section>
<!-- begin footer -->
<?php
require 'footer.php';
?>
<!-- einde footer -->
<?php
// } else {
//   header("Location: index.php");
//   exit();
// }
?>