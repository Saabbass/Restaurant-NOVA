<?php
session_start();
// if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
require 'database.php';

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin of medewerker!";
  exit;
}

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
            <a class="btn-info" href="menucourse_create.php">Maak menugang aan</a>
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
                <th>ID</th>
                <th>Naam gang</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($producten as $product) : ?>
                <tr>
                  <td><?php echo $product['menugang_id'] ?></td>
                  <td><?php echo $product['menugang_naam'] ?></td>
                  <td>
                    <a href="menucourse_delete.php?id=<?php echo $product['menugang_id'] ?>" class="btn-delete">delete</a>
                    <a href="menucourse_update.php?id=<?php echo $product['menugang_id'] ?>" class="btn-update">update</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div class="scroll_top">
            <a class="btn-info" href="category_create.php">Maak menugang aan</a>
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
                <th>ID</th>
                <th>Naam categorie</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($producten as $product) : ?>
                <tr>
                  <td><?php echo $product['categorie_id'] ?></td>
                  <td><?php echo $product['categorie_naam'] ?></td>
                  <td>
                    <a href="menucategorie_delete.php?id=<?php echo $product['categorie_id'] ?>" class="btn-delete">delete</a>
                    <a href="menucategorie_update.php?id=<?php echo $product['categorie_id'] ?>" class="btn-update">update</a>
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