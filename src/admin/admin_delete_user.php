<?php
session_start();
include_once "../database/db_enquiry.php";

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

// 1.12. Tarkistetaan käyttäjän status
$user_status = getUserStatus($conn, $user_id);
if ($user_status === 'admin') {
    echo "<h1>Tervetuloa, admin!</h1>";
} else {
    die("Käyttäjällä ei ole admin -oikeuksia.");
}

if (isset($_GET['user_id'])) {
    include_once "../database/db_connect.php";

    // 30.11. Tarkistetaan yhteys.
    if ($conn->connect_error) {
        die("Tietokantayhteys epäonnistui: " . $conn->connect_error);
    }

    $user_id = intval($_GET['user_id']);
    $sql = "UPDATE user SET deleted_at = NOW() WHERE user_id = $user_id";

    if ($conn->query($sql) === TRUE) {
        http_response_code(200); // HTMX tunnistaa onnistuneen poiston
    } else {
        http_response_code(500);
        echo "Virhe poistamisessa: " . $conn->error;
    }

    $conn->close();
}
?>