<?php
session_start();
// require database.php wordt gebruikt voor de database connectie
require 'database.php';
?>
<!-- Een enkel woord voor een Duits restaurant zou “Gasthof” kunnen zijn, wat verwijst naar een traditionele Duitse herberg of eetgelegenheid. Het is kort, krachtig en heeft een authentiek Duitse klank. Prost op uw succes! -->
<!-- 

<body> -->

  <!-- begin ingoegen van navbar / header -->
  <?php
  require 'header.php';
  ?>
  <!-- einde invoegen van navbar / header -->
  <section id="content" class="min_page_heigt">
    <main>
      <!-- begin main part 1 -->
      <section class="container_img">
        <img src="img/alex-PZC7p-Pstmg-unsplash.jpg" alt="">

            <div class="box">
              <div class="txt_box">
                <h1>Gasthof</h1>

                <p>Uw favoriete restaurant</p>

                <a href="">Reserveer nu uw tafel</a>
              </div>

        </div>
      </section>
    </main>
  </section>

  <?php
  require 'footer.php';
  ?>

<!-- </body>

</html> -->