<?php
// TÄLLÄ SIVULLA LUODAAN YHTEYS TIETOKANTAAN

// Oikeassa tilanteessa ei tunnuksia koodiin (GitHub)
$host = "mysql_db"; // Tietokantapalvelimen osoite, viittaa Dockerin sisäiseen konttiin.
$db = "leva";       // Tietokannan nimi.
$user = "root";     // Käyttäjätunnus tietokantaan, tämä pitäisi vaihtaa toiseen.
$pass ="root";      // Salasana tietokantaan, tämä pitäisi vaihtaa toiseen.

// Luodaan yhteys tietokantaan MySQLi -kirjaston avulla.
$conn = new mysqli($host, $user, $pass, $db);

// Tarkistetaan, onnistuiko yhteyden muodostaminen.
if($conn->connect_error) {
    // Jos yhteys epäonnistui, tulostetaan virheilmoitus ja lopetetaan scripti.
    die("Connection failed: " . $conn->connect_error);
}

// Tässä vaiheessa yhteys on onnistuneesti muodostettu.