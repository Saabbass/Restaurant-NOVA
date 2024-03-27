<?php
session_start();
// if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee')) {
require 'database.php';

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin of medewerker!";
  exit;
}

$sql = "SELECT * FROM categorie";

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
            <a class="btn-info" href="menucategorie_create.php">Maak categorie aan</a>
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
                <tr>
                  <th>ID:</th>
                  <td><?php echo $product['categorie_id'] ?></td>
                </tr>
                <tr>
                  <th>Naam categorie:</th>
                  <td><?php echo $product['categorie_naam'] ?></td>
                </tr>
                <tr>
                  <!-- <th></th> -->
                  <td>
                    <a href="menucategorie_delete.php?id=<?php echo $product['categorie_id'] ?>" class="btn-delete">delete</a>
                    <a href="menucategorie_update.php?id=<?php echo $product['categorie_id'] ?>" class="btn-update">update</a>
                  </td>
                </tr>
              </tbody>
            </table>
          <?php endforeach; ?>
          <!-- laptop view -->
          <table class="horizontal_table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Naam categorie</th>
                <th></th>
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