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

    $sql = "SELECT * FROM company";
    $result = $conn->query($sql);

    // Tarkistetaan. löytyykö kyselyn tuloksista yhtään riviä.
    if ($result->num_rows > 0) {
        // Käydään jokainen rivi läpi ja tulostetaan käyttäjän tiedot taulukkorakenteeseen.
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['company_id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['company_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['company_number']) . '</td>';
            echo '<td>' . htmlspecialchars($row['address']) . '</td>';
            echo '<td>' . htmlspecialchars($row['zipcode']) . '</td>';
            echo '<td>' . htmlspecialchars($row['postplace']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['phone_number']) . '</td>';
            echo '<td>' . htmlspecialchars($row['slogan']) . '</td>';
            echo '<td>
                    <button 
                        onclick="openModal(' . $row['company_id'] . ', 
                            \'' . htmlspecialchars($row['company_name']) . '\', 
                            \'' . htmlspecialchars($row['company_number']) . '\', 
                            \'' . htmlspecialchars($row['address']) . '\', 
                            \'' . htmlspecialchars($row['zipcode']) . '\', 
                            \'' . htmlspecialchars($row['postplace']) . '\', 
                            \'' . htmlspecialchars($row['email']) . '\', 
                            \'' . htmlspecialchars($row['phone_number']) . '\', 
                            \'' . htmlspecialchars($row['slogan']) . '\' )">
                        Muokkaa
                    </button>
                </td>';
            echo '</tr>';
        } 
    } else {
        echo '<tr><td colspan="11">Ei yrityksiä löytynyt.</td></tr>';
    }
    $conn->close();

} else {
    die("Käyttäjällä ei ole admin -oikeuksia.");
}

?>