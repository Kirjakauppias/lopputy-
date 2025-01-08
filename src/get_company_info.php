<?php
session_start(); // Varmista, että sessio on aloitettu
require "database/db_connect.php";

// Tarkistetaan, että user_id on asetettu sessioon
$user_id = $_SESSION['user_id'] ?? null;

if ($user_id && is_numeric($user_id)) 
{
    // Haetaan kaikki yrityksen tiedot käyttäjän user_id:n perusteella
    $query = $conn->prepare("SELECT company_id, company_name, company_number, address, zipcode, postplace, email, phone_number, description FROM company WHERE user_id = ?");
    
    if (!$query) 
    {
        die("Kyselyn valmistelu epäonnistui: " . $conn->error);
    }

    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($row = $result->fetch_assoc()) 
    {
        // Tulostetaan yrityksen tiedot
        //echo "Yrityksen ID: " . htmlspecialchars($row['company_id']) . "<br>";
        echo htmlspecialchars($row['company_name']) . "<br>";
        // Lisää haluamasi kentät
    } 
    else 
    {
        echo "Yrityksen tietoja ei löytynyt.";
    }

    $query->close();
} 
else 
{
    echo "Virheellinen tai puuttuva käyttäjän ID.";
}

$conn->close();