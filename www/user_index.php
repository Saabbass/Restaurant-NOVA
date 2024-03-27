<?php
session_start();
if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
  require 'database.php';

  $sql = "SELECT * FROM gebruiker INNER JOIN adres ON gebruiker.adres_id = adres.adres_id";

  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $data = $_SESSION['rol'];

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
              <?php if ($data == 'admin' || $data == 'employee') { ?>
                <a class="btn-info" href="user_create.php">Maak gebruiker aan</a>
              <?php } ?>
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

            <!-- mobile view -->
            <?php foreach ($users as $user) : ?>
              <table class="vertical_table">
                <tbody class="vertical_cell">
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') { ?>
                      <tr>
                        <th>ID:</th>
                        <td><?php echo $user['gebruiker_id'] ?></td>
                      </tr>
                    <?php } ?>
                  <?php } ?>
                  <tr>
                    <th>Email:</th>
                    <td><?php echo $user['email'] ?></td>
                  </tr>
                  <tr>
                    <th>Voornaam:</th>
                    <td><?php echo $user['gebruiker_voornaam'] ?></td>
                  </tr>
                  <tr>
                    <th>Achternaam:</th>
                    <td><?php echo $user['gebruiker_achternaam'] ?></td>
                  </tr>
                  <tr>
                    <th>Land:</th>
                    <td><?php echo $user['land'] ?></td>
                  </tr>
                  <tr>
                    <th>Postcode:</th>
                    <td><?php echo $user['postcode'] ?></td>
                  </tr>
                  <tr>
                    <th>Woonplaats:</th>
                    <td><?php echo $user['woonplaats'] ?></td>
                  </tr>
                  <tr>
                    <th>Straat:</th>
                    <td><?php echo $user['straat'] ?></td>
                  </tr>
                  <tr>
                    <th>Huisnummer:</th>
                    <td><?php echo $user['huisnummer'] ?></td>
                  </tr>
                  <tr>
                    <th>Toevoeging:</th>
                    <td><?php echo $user['toevoeging'] ?></td>
                  </tr>
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') { ?>
                      <tr>
                        <th>Rol:</th>
                        <td><?php echo $user['rol'] ?></td>
                      </tr>
                      <tr>
                        <td>
                          <a href="user_delete.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-delete">delete</a>
                          <a href="user_update.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-update">update</a>
                        </td>
                      </tr>
                    <?php } ?>
                  <?php } ?>
                </tbody>
              </table>
            <?php endforeach; ?>

            <!-- laptop view -->
            <table class="horizontal_table">
              <thead>
                <tr>
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') {
                  ?>
                      <th>ID</th>
                    <?php } ?>
                  <?php } ?>
                  <th>Email</th>
                  <th>Voornaam</th>
                  <th>Achternaam</th>
                  <th>Land</th>
                  <th>Postcode</th>
                  <th>Woonplaats</th>
                  <th>Straat</th>
                  <th>Huisnummer</th>
                  <th>Toevoeging</th>
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') {
                  ?>
                      <th>Rol</th>
                      <th></th>
                    <?php } ?>
                  <?php } ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user) : ?>
                  <tr>
                    <?php if (isset($_SESSION['rol'])) {
                      $data = $_SESSION['rol'];
                      if ($data === 'admin' || $data === 'employee') {
                    ?>
                        <td><?php echo $user['gebruiker_id'] ?></td>
                      <?php } ?>
                    <?php } ?>
                    <td><?php echo $user['email'] ?></td>
                    <td><?php echo $user['gebruiker_voornaam'] ?></td>
                    <td><?php echo $user['gebruiker_achternaam'] ?></td>
                    <td><?php echo $user['land'] ?></td>
                    <td><?php echo $user['postcode'] ?></td>
                    <td><?php echo $user['woonplaats'] ?></td>
                    <td><?php echo $user['straat'] ?></td>
                    <td><?php echo $user['huisnummer'] ?></td>
                    <td><?php echo $user['toevoeging'] ?></td>
                    <?php
                    if ($data == 'admin') {
                    ?>
                      <td><?php echo $user['rol'] ?></td>
                      <td>
                        <a href="user_delete.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-delete">delete</a>
                        <a href="user_update.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-update">update</a>
                      </td>
                    <?php } else if ($data == 'employee') { ?>
                      <td><?php echo $user['rol'] ?></td>
                      <td>
                        <a href="user_update.php?id=<?php echo $user['gebruiker_id'] ?>" class="btn-update">update</a>
                      </td>
                    <?php } ?>
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