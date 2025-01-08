<?php
// Tarkistetaan, onko pyyntö tehty POST-metodilla
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once "../database/db_connect.php";
    // Tarkistetaan tietokantayhteys ja lopetetaan suoritus, jos yhteys epäonnistuu
    if ($conn->connect_error) {
        die("Tietokantayhteys epäonnistui: " . $conn->connect_error);
    }
    // Käyttäjän lähettämien tietojen käsittely ja validointi
    // `intval` varmistaa, että $user_id on kokonaisluku, estäen SQL-injektiot
    // 28.11. Lisätty $status
    $user_id = intval($_POST['user_id']);
    // Suojataan merkkijonoarvot SQL-injektioita vastaan `real_escape_string`-metodilla
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $status = $conn->real_escape_string($_POST['status']);

    // Rakennetaan SQL-kysely, jolla päivitetään käyttäjän tiedot
    // `updated_at = NOW()` päivittää käyttäjän viimeisimmän muokkausajankohdan
    // 28.11. Lisätty $status
    $sql = "UPDATE user SET firstname = '$firstname', lastname = '$lastname', email = '$email', status = '$status', updated_at = NOW() WHERE user_id = $user_id";

    // Suoritetaan kysely ja tarkistetaan, onnistuiko tietojen päivitys
    if ($conn->query($sql) === TRUE) {
        echo "<p>Käyttäjän tiedot päivitetty onnistuneesti!</p>";
    } else {
        echo "<p>Virhe tietojen päivityksessä: " . $conn->error . "</p>";
    }
}
?>