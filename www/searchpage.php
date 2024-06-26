<?php
session_start();
// require database.php wordt gebruikt voor de database connectie
require 'database.php';

// $search = $_POST['search'];

if (isset($_POST['search_submit'])) {
  if (!empty($_POST['search'])) {
    require 'database.php';
    $zoekterm = $_POST['search'];
    $sql = "SELECT * FROM menugang INNER JOIN product ON menugang.product_id = product.product_id 
        INNER JOIN categorie ON product.categorie_id = categorie.categorie_id WHERE product_naam LIKE '%$zoekterm%' OR menugang_naam LIKE '%$zoekterm%'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } else {
    header("Location: index.php");
    exit();
  }
} else {
  header("Location: index.php");
  exit();
}

// sql-qeury voor het ophalen van alle producten uit de database
// $sql = "SELECT * FROM producten WHERE merk LIKE '%$search%' OR model LIKE '%$search%'";
// $stmt = $conn->prepare($sql);
// $stmt->execute();

// $productenSearch = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<head>
  <title>searchpage</title>
</head>

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
                <a class="btn-info" href="menu_create.php">Maak menu aan</a>
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
                  <th>Naam gang:</th>
                  <td><?php echo $product['categorie_naam'] ?></td>
                </tr>
                <tr>
                  <th>product naam:</th>
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
                    <tr>
                      <th>Inkoopprijs:</th>
                      <td><?php echo $product['inkoopprijs'] ?></td>
                    </tr>
                    <tr>
                      <td>
                        <a href="product_delete.php?id=<?php echo $product['product_id'] ?>" class="btn-delete">delete</a>
                        <a href="product_update.php?id=<?php echo $product['product_id'] ?>" class="btn-update">update</a>
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
                    <th></th>
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
                  <td>
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
<!-- <?php
      // } else {
      //   header("Location: index.php");
      //   exit();
      // }
      ?> -->