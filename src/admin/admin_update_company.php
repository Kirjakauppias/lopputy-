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
    // Tarkistetaan, onko pyyntö tehty POST-metodilla
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include_once "../database/db_connect.php";
        // Tarkistetaan tietokantayhteys ja lopetetaan suoritus, jos yhteys epäonnistuu
        if ($conn->connect_error) {
            die("Tietokantayhteys epäonnistui: " . $conn->connect_error);
        }
    
        // Otetaan tiedot talteen ja suojataan SQL-injektiolta
        $company_id = (int) $_POST['company_id'];
        $company_name = trim($_POST['company_name']);
        $company_number = isset($_POST['company_number']) ? trim($_POST['company_number']) : null;
        $address = isset($_POST['address']) ? trim($_POST['address']) : null;
        $zipcode = isset($_POST['zipcode']) ? trim($_POST['zipcode']) : null;
        $postplace = trim($_POST['postplace']);
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $phone_number = isset($_POST['phone_number']) ? trim($_POST['phone_number']) : null;
        $slogan = isset($_POST['slogan']) ? trim($_POST['slogan']) : null;

        // Päivitetään tiedot tietokantaan
        $query = $conn->prepare("UPDATE 
            company SET 
            company_name = ?, 
            company_number = ?, 
            address = ?, 
            zipcode = ?, 
            postplace = ?, 
            email = ?, 
            phone_number = ?, 
            slogan = ?
            WHERE 
            company_id = ?
            ");
        $query->bind_param(
            "ssssssssi",
            $company_name,
            $company_number,
            $address,
            $zipcode,
            $postplace,
            $email,
            $phone_number,
            $slogan,
            $company_id
            );
        // Suoritetaan kysely
        $query->execute();
        $query->close();
        $conn->close();
    } else {
        die("Ei ole POST");
    }
    
} else {
    die("Käyttäjällä ei ole admin -oikeuksia.");
}


