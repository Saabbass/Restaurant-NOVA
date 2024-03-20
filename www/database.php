<?php
/*
// Database configuratie
$host  = "mariadb";
$dbuser = "root";
$dbpass = "password";
$dbname = "webwinkel_autobedrijf";

// Maak een  database connectie
$conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
*/
    // Database configuratie
    $servername  = "mariadb";
    $username = "root";
    $password = "password";
    $dbname = "restaurant_nova";

    // Maak een  database connectie
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
?>