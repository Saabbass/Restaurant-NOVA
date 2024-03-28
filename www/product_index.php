<?php
session_start();
// if (isset($_SESSION['user_id']) && isset($_SESSION['email']) && (($_SESSION['rol']) === 'admin' || ($_SESSION['rol']) === 'employee' || ($_SESSION['rol']) === 'customer')) {
  require 'database.php';

  $sql = "SELECT * FROM product INNER JOIN categorie ON product.categorie_id = categorie.categorie_id ORDER BY `categorie`.`categorie_id` ASC";

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
            <script src="js/show_more.js" async></script>
            <div class="scroll_top">
              <?php if (isset($_SESSION['rol'])) {
                $data = $_SESSION['rol'];
                if ($data === 'admin' || $data === 'employee') {
              ?>
                  <a class="btn-info" href="product_create.php">Maak gerecht aan</a>
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

            <div class="card_holder">
              <?php foreach ($producten as $product) : ?>
                <div class="card">
                  <div class="card_inner">
                    <img src="img/<?php echo $product['afbeelding'] ?>" alt="error">
                    <div class="card_text">
                      <?php if (isset($_SESSION['rol'])) {
                        $data = $_SESSION['rol'];
                        if ($data === 'admin' || $data === 'employee') { ?>
                          <p><?php echo $product['product_id'] ?></p>
                        <?php } ?>
                      <?php } ?>
                      <p><?php echo $product['categorie_naam'] ?></p>
                      <p><?php echo $product['product_naam'] ?></p>
                      <div class="card_text_description" id="clipped">
                        <p><?php echo $product['beschrijving'] ?></p>
                      </div>
                      <div id="clippedmore">
                        <p><a href="product_detail.php?id=<?php echo $product['product_id'] ?>">Zie meer...</a></p>
                      </div>
                      <p>€<?php echo $product['verkoopprijs'] ?></p>
                      <p>Vega: <?php echo $product['is_vega'] ?></p>
                      <?php if (isset($_SESSION['rol'])) {
                        $data = $_SESSION['rol'];
                        if ($data === 'admin' || $data === 'employee') { ?>
                          <p>Vooraad: <?php echo $product['aantal_vooraad'] ?></p>
                          <p>Inkoopprijs: <?php echo $product['inkoopprijs'] ?></p>
                        <?php } ?>
                      <?php } ?>
                    </div>

                    <?php if (isset($_SESSION['rol'])) {
                      $data = $_SESSION['rol'];
                      if ($data === 'admin' || $data === 'employee') { ?>
                        <div class="btn_holder">
                          <a href="product_delete.php?id=<?php echo $product['product_id'] ?>" class="btn-delete">delete</a>
                          <a href="product_update.php?id=<?php echo $product['product_id'] ?>" class="btn-update">update</a>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div>
              <?php endforeach; ?>
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