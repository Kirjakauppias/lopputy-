<?php
session_start();
include_once "../database/db_enquiry.php";
$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty
$user_status = getUserStatus($conn, $user_id);

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
} else if ($user_status === 'admin') {

include_once "../database/db_connect.php";

// 26.11. Tarkistetaan yhteys.
if ($conn->connect_error) {
    die("Tietokantayhteys epäonnistui: " . $conn->connect_error);
}

// 26.11. Haetaan käyttäjät user-taulukosta hox! deleted_at = null
$sql = "SELECT user_id, firstname, lastname, username, email, status, deleted_at FROM user";
$result = $conn->query($sql);

// Tarkistetaan. löytyykö kyselyn tuloksista yhtään riviä.
if ($result->num_rows > 0) {
    // Käydään jokainen rivi läpi ja tulostetaan käyttäjän tiedot taulukkorakenteeseen.
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
            echo '<td>' . htmlspecialchars($row['user_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['firstname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['lastname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['status']) . '</td>';
            // Tulostetaan toiminnot: muokkaa- ja poista-painikkeet.
            echo '<td>
                <button 
                    onclick="openModal(' . $row['user_id'] . ', 
                        \'' . htmlspecialchars($row['firstname']) . '\', 
                        \'' . htmlspecialchars($row['lastname']) . '\', 
                        \'' . htmlspecialchars($row['email']) . '\',
                        \'' . htmlspecialchars($row['status']) . '\' )">
                    Muokkaa
                </button> ';
                // 30.11. Tarkistetaan, onko käyttäjä jo poistettu.
                if ($row['deleted_at'] === null) {
                echo '<button 
                    hx-delete="admin_delete_user.php?user_id=' . $row['user_id'] . '" 
                    hx-confirm="Haluatko varmasti poistaa tämän käyttäjän?" 
                    hx-swap="none"
                >
                    Poista
                </button>';
                } else {
                    echo '
                        <button
                            hx-put="admin_restore_user.php?user_id=' . $row['user_id'] . '"
                            hx-confirm="Haluatko palauttaa tämän käyttäjän?"
                            hx-swap="none"
                        >
                            Lisää
                        </button>
                    ';
                }
        echo   '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="7">Ei käyttäjiä löytynyt.</td></tr>';
}

// Suljetaan tietokantayhteys
$conn->close();
} else {
    die("Käyttäjällä ei ole admin -oikeuksia.");
}
?>