<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
  require 'database.php';

  $sql = "SELECT * FROM reservering INNER JOIN gebruiker ON reservering.gebruiker_id = gebruiker.gebruiker_id";

  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                <?php foreach ($users as $user) : ?>
                  <tr>
                    <td><?php echo $user['reservering_nummer'] ?></td>
                    <td><?php echo $user['reservering_naam'] ?></td>
                    <td><?php echo $user['datum'] ?></td>
                    <td><?php echo $user['tijd'] ?></td>
                    <td><?php echo $user['aantal_personen'] ?></td>
                    <td><?php echo $user['tafelnummer'] ?></td>
                    <td><?php echo $user['gebruiker_id'] ?></td>
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
} else {
  header("Location: index.php");
  exit();
}
?>