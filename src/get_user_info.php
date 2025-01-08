<?php
session_start();
require "database/db_connect.php";
// Tarkistetaan, että user_id on asetettu sessioon
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id && is_numeric($user_id)) 
{
    // Haetaan kaikki tarvittavat tiedot paitsi salasana
    $query = $conn->prepare("SELECT firstname, lastname, username, email FROM user WHERE user_id = ?");
    
    // Tarkistetaan, että kysely valmistui onnistuneesti
    if (!$query) 
    {
        die("Kyselyn valmistelu epäonnistui: " . $conn->error);
    }

    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($row = $result->fetch_assoc()) 
    {
        // Tulostetaan vain etunimi
        echo htmlspecialchars($row['firstname']);
        
        // Tallennetaan kaikki haetut tiedot sessioon myöhempää käyttöä varten
        // $_SESSION['user_info'] = $row;
    } else 
    {
        echo "Käyttäjää ei löytynyt";
    }

    $query->close();
} else 
{
    echo "Virheellinen tai puuttuva käyttäjän ID.";
}

$conn->close();