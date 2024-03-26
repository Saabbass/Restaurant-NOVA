<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  echo "You are not logged in, please login. ";
  echo "<a href='login.php'>Login here</a>";
  exit;
}

if ($_SESSION['rol'] != 'admin' && $_SESSION['rol'] != 'employee') {
  echo "U bent niet bevoegd om deze pagina te bekijken, login in als admin of medewerker!";
  exit;
}

require 'database.php';

$categorie_id = $_GET['id'];

$sql = "SELECT * FROM categorie WHERE categorie_id = :categorie_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":categorie_id", $categorie_id);
$stmt->execute();
$categorie = $stmt->fetch(PDO::FETCH_ASSOC);

require 'header.php';
?>

<main>
  <div class="container">
    <div class="container_width">
      <section class="form_align">
        <form action="menucategorie_update_session.php" method="post">
          <div>
            <h2 class="form_head">Categorie aanpassen</h2>
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
          <input type="hidden" name="categorie_procesID" id="categorie_procesID" value="<?php echo $categorie['categorie_id'] ?>" placeholder="<?php echo $categorie['categorie_id'] ?>">
          <div class="form_group">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" name="naam" value="<?php echo $categorie['categorie_naam'] ?>" placeholder="<?php echo $categorie['categorie_naam'] ?>">
          </div>
          <button type="submit" class="button_submit" name="submit">Toevoegen</button>
        </form>
      </section>
    </div>
  </div>
</main>
<?php require 'footer.php' ?>