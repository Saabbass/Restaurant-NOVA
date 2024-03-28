<?php
session_start();
// if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
require 'database.php';

$sql = "SELECT * FROM product INNER JOIN categorie ON product.categorie_id = categorie.categorie_id ORDER BY categorie.categorie_id ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
            <?php if (isset($_SESSION['rol'])) {
              $data = $_SESSION['rol'];
              if ($data === 'admin' || $data === 'employee') { ?>
                <a class="btn-info" href="product_create.php">Maak menu aan</a>
              <?php } ?>
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
          <?php foreach ($producten as $product) : ?>
            <table class="vertical_table">
              <tbody class="vertical_cell">
                <?php if (isset($_SESSION['rol'])) {
                  $data = $_SESSION['rol'];
                  if ($data === 'admin' || $data === 'employee') { ?>
                    <tr>
                      <th>Nummer:</th>
                      <td><?php echo $product['product_id'] ?></td>
                    </tr>
                  <?php } ?>
                <?php } ?>
                <tr>
                  <th>Menugang:</th>
                  <td><?php echo $product['categorie_naam'] ?></td>
                </tr>
                <tr>
                  <th>Naam gerecht:</th>
                  <td><?php echo $product['product_naam'] ?></td>
                </tr>
                <tr>
                  <th>Omschrijving:</th>
                  <td><?php echo $product['beschrijving'] ?></td>
                </tr>
                <tr>
                  <th>Prijs:</th>
                  <td><?php echo $product['verkoopprijs'] ?></td>
                </tr>
                <tr>
                  <th>Vega:</th>
                  <td><?php echo $product['is_vega'] ?></td>
                </tr>
                <?php if (isset($_SESSION['rol'])) {
                  $data = $_SESSION['rol'];
                  if ($data === 'admin' || $data === 'employee') { ?>
                    <tr>
                      <th>Vooraad:</th>
                      <td><?php echo $product['aantal_vooraad'] ?></td>
                    </tr>
                    <!-- <tr>
                      <td><a href="menucourse_delete.php?id=<?php echo $product['menugang_id'] ?>" class="btn-delete">delete</a>
                        <a href="menucourse_update.php?id=<?php echo $product['menugang_id'] ?>" class="btn-update">update</a>
                      </td>
                    </tr> -->
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
                  if ($data === 'admin' || $data === 'employee') { ?>
                    <th>Nummer</th>
                  <?php } ?>
                <?php } ?>
                <th>Naam gang</th>
                <th>Naam gerecht</th>
                <th>Omschrijving</th>
                <th>Prijs</th>
                <!-- <th>Afbeelding</th> -->
                <th>Vega</th>
                <?php if (isset($_SESSION['rol'])) {
                  $data = $_SESSION['rol'];
                  if ($data === 'admin' || $data === 'employee') { ?>
                    <th>Vooraad</th>
                  <?php } ?>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($producten as $product) : ?>
                <tr>
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') { ?>
                      <td><?php echo $product['product_id'] ?></td>
                    <?php } ?>
                  <?php } ?>
                  <td><?php echo $product['categorie_naam'] ?></td>
                  <td><?php echo $product['product_naam'] ?></td>
                  <td><?php echo $product['beschrijving'] ?></td>
                  <td><?php echo $product['verkoopprijs'] ?></td>
                  <!-- <td><?php echo $product['afbeelding'] ?></td> -->
                  <td><?php echo $product['is_vega'] ?></td>
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') { ?>
                      <td><?php echo $product['aantal_vooraad'] ?></td>
                    <?php } ?>
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
<!-- <?php
      // } else {
      //   header("Location: index.php");
      //   exit();
      // }
      ?> -->