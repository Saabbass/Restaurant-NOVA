<?php
session_start();
// if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
require 'database.php';

$sql = "SELECT * FROM menugang INNER JOIN product ON menugang.product_id = product.product_id 
INNER JOIN categorie ON product.categorie_id = categorie.categorie_id";

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
          <table>
            <thead>
              <tr>
                <?php if (isset($_SESSION['rol'])) {
                  $data = $_SESSION['rol'];
                  if ($data === 'admin' || $data === 'employee') { ?>
                    <th>ID</th>
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
                    <th>Categorie</th>
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
                      <td><?php echo $product['menugang_id'] ?></td>
                    <?php } ?>
                  <?php } ?>
                  <td><?php echo $product['menugang_naam'] ?></td>
                  <td><?php echo $product['product_naam'] ?></td>
                  <td><?php echo $product['beschrijving'] ?></td>
                  <td><?php echo $product['verkoopprijs'] ?></td>
                  <!-- <td><?php echo $product['afbeelding'] ?></td> -->
                  <td><?php echo $product['is_vega'] ?></td>
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') { ?>
                      <td><?php echo $product['aantal_vooraad'] ?></td>
                      <td><?php echo $product['categorie_naam'] ?></td>
                    <?php } ?>
                  <?php } ?>
                  <!-- <td>
                    <?php if (isset($_SESSION['rol'])) {
                      $data = $_SESSION['rol'];
                      if ($data == 'admin') {
                    ?>
                        <a href="menucourse_delete.php?id=<?php echo $product['menugang_id'] ?>" class="btn-delete">delete</a>
                        <a href="menucourse_update.php?id=<?php echo $product['menugang_id'] ?>" class="btn-update">update</a>

                      <?php } elseif ($data == 'employee') { ?>
                        <a href="menucourse_delete.php?id=<?php echo $product['menugang_id'] ?>" class="btn-delete">delete</a>
                        <a href="menucourse_update.php?id=<?php echo $product['menugang_id'] ?>" class="btn-update">update</a>
                      <?php } else {
                      ?>

                      <?php } ?>
                    <?php } ?>
                  </td> -->
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