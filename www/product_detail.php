<?php
session_start();
// if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee' || ($_SESSION['rol']) === 'customer')) {
require 'database.php';

$product_id = $_GET['id'];

$sql = "SELECT * FROM product INNER JOIN categorie ON product.categorie_id = categorie.categorie_id WHERE product.product_id = :product_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":product_id", $product_id);
$stmt->execute();
$product_data = $stmt->fetch(PDO::FETCH_ASSOC);

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
        <section class="container_no_scroll">
          <div class="scroll_top">
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

          <div class="detailcard_holder">
            <div class="detailcard">
              <div class="detailcard_inner">
                <img src="img/<?php echo $product_data['afbeelding'] ?>" alt="error">
                <div class="detailcard_text">
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') { ?>
                      <p><?php echo $product_data['product_id'] ?></p>
                    <?php } ?>
                  <?php } ?>
                  <p><?php echo $product_data['categorie_naam'] ?></p>
                  <p><?php echo $product_data['product_naam'] ?></p>
                  <div class="detailcard_text_description">
                    <p><?php echo $product_data['beschrijving'] ?></p>
                  </div>
                  <p>€<?php echo $product_data['verkoopprijs'] ?></p>
                  <p>Vega: <?php echo $product_data['is_vega'] ?></p>
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data === 'admin' || $data === 'employee') { ?>
                      <p>Vooraad: <?php echo $product_data['aantal_vooraad'] ?></p>
                      <p>Inkoopprijs: <?php echo $product_data['inkoopprijs'] ?></p>
                    <?php } ?>
                  <?php } ?>
                </div>
                <?php if (isset($_SESSION['rol'])) {
                  $data = $_SESSION['rol'];
                  if ($data === 'admin' || $data === 'employee') { ?>
                    <div class="btn_holder">
                      <a href="product_delete.php?id=<?php echo $product_data['product_id'] ?>" class="btn-delete">delete</a>
                      <a href="product_update.php?id=<?php echo $product_data['product_id'] ?>" class="btn-update">update</a>
                    </div>
                  <?php } ?>
                <?php } ?>
              </div>
            </div>
          </div>
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
//   header("Location: login.php");
//   exit();
// }
?>