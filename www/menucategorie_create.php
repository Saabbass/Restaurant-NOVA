<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin of medewerker!";
  exit;
}
require 'database.php';

// $sql = "SELECT * FROM menugang";

// $stmt = $conn->prepare($sql);
// $stmt->execute();

// $menu = $stmt->fetch(PDO::FETCH_ASSOC);

require 'header.php';
?>

<main>
  <div class="container">
    <div class="container_width">
      <section class="form_align">
        <form action="menucategorie_create_session.php" method="post">
          <div>
            <h2 class="form_head">Nieuwe categorie</h2>
          </div>
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

          <div class="form_group">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam">
          </div>
          <button type="submit" class="button_submit" name="submit">Toevoegen</button>
        </form>
      </section>
    </div>
  </div>
</main>
<?php require 'footer.php' ?>