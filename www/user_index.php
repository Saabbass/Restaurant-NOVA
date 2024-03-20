<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
  require 'database.php';

  $sql = "SELECT * FROM gebruiker INNER JOIN adres ON gebruiker.adres_id = adres.adres_id";

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
                  <th>ID</th>
                  <th>Email</th>
                  <th>Voornaam</th>
                  <th>Achternaam</th>
                  <th>Land</th>
                  <th>Postcode</th>
                  <th>Woonplaats</th>
                  <th>Straat</th>
                  <th>Huisnummer</th>
                  <th>Toevoeging</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user) : ?>
                  <tr>
                    <td><?php echo $user['gebruiker_id'] ?></td>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['gebruiker_voornaam'] ?></td>
                    <td><?php echo $user['gebruiker_achternaam'] ?></td>
                    <td><?php echo $user['land'] ?></td>
                    <td><?php echo $user['postcode'] ?></td>
                    <td><?php echo $user['woonplaats'] ?></td>
                    <td><?php echo $user['straat'] ?></td>
                    <td><?php echo $user['huisnummer'] ?></td>
                    <td><?php echo $user['toevoeging'] ?></td>
                    <td>
                      <?php if (isset($_SESSION['rol'])) {
                        $data = $_SESSION['rol'];
                        if ($data == 'admin') {
                      ?>
                          <a href="user_delete.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-delete">delete</a>
                          <a href="updateUser.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-update">update</a>

                        <?php } elseif ($data == 'employee') { ?>
                          <a href="updateUser.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-update">update</a>
                        <?php } else {
                        ?>

                        <?php } ?>
                      <?php } ?>
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
} else {
  header("Location: index.php");
  exit();
}
?>