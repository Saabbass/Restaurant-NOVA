<!DOCTYPE html>
<html lang="nl-NL">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/styles.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <title>Gasthof</title>
  <link rel="icon" type="image/x icon" src="img/gasthof.png" href="" alt="gasthof">
</head>

<body>
  <!-- begin header -->
  <section class="header_nav">
    <header class="container">
      <section class="container_width">
        <div class="nav_top">
          <div class="left">
            <img src="img/gasthof.png" alt="gasthof">
            <!-- <a href="index.php">De Gasthof</a> -->
            <!-- begin box voor de rechterkant van de header -->
            <!-- einde box voor de rechterkant van de header -->
          </div>
          <div class="right">
            <p>&copy;2024.SchoolProject</p>
            <form action="searchpage.php" method="POST" class="search_box">
              <input id="search" name="search" type="search" placeholder="Type here">
              <button class="searchButton" id="submit" type="submit" name="search_submit"><i class="fa fa-search"></i></button>
            </form>
            <!-- <div class="search_box">
                            <input type="text">
                            <span class="fa fa-search"></span>
                        </div> -->
            <a href="index.php"><i class="fa fa-home"></i></a>
            <?php
            if (isset($_SESSION['email'])) {
            ?>
              <script src="js/drop.js"></script>
              <div class="dropdown">
                <button onclick="myFunction()" class="dropbtn"><?php echo $_SESSION['voornaam']; ?></button>
                <div id="myDropdown" class="dropdown-content">
                  <?php if (isset($_SESSION['rol'])) {
                    $data = $_SESSION['rol'];
                    if ($data == 'admin') {
                  ?>
                      <a href="user_index.php">Gebruikers</a>
                      <a href="reservation_index.php">Reserveringen</a>

                    <?php } else {
                    ?>
                    <?php } ?>
                  <?php } ?>
                  <a href="user_settings.php">instellingen</a>
                  <a href="session_logout.php">Logout</a>
                </div>
              </div>
            <?php
            } else {
            ?>
              <a href="login.php"><i class="fa fa-user"></i></a>
            <?php
            }
            ?>
          </div>
        </div>
        <hr class="hr-yellow">
      </section>
    </header>
    <!-- begin invoegen van navbar -->
    <?php
    include('nav.php');
    ?>
    <!-- einde invoegen van navbar -->
  </section>
  <!-- einde header -->
  <!-- </body>

</html> -->