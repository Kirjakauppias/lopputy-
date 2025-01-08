<?php
session_start();
// TÄLLÄ SIVULLA SUORITETAAN KÄYTTÄJÄN TIETOJEN TARKISTUS JA PÄIVITYS

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

// verifyUserPassword()
include_once "./database/db_enquiry.php";

// Tarkistetaan, että pyyntö on lähetetty POST -metodilla
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Muuttujiin arvot inputeista
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Virheiden tarkistus ja tulostus
    $errors = [];
    if (empty($firstname)) {
        $errors[] = "Etunimi ei voi olla tyhjä.";
    }
    if (empty($lastname)) {
        $errors[] = "Sukunimi ei voi olla tyhjä.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Virheellinen sähköposti.";
    }
    if (empty($password)) {
        $errors[] = "Nykyinen salasana on pakollinen.";
    }

    if (!empty($errors)) {
        // Tulostetaan virheet
        echo "<div id='result'><ul>";
        foreach ($errors as $error) {
            echo "<li>" . htmlspecialchars($error) . "</li>";
        }
        echo "</ul></div>";
        exit;
    }
    // Haetaan funktio jolla tarkistetaan annettu salasana
    if(!verifyUserPassword($conn, $user_id, $password)) {
        die("Virheellinen salasana.");
    }

    // Haetaan funktio jolla päivitetään käyttäjän tiedot
    include_once "./database/db_add_data.php";
    echo updateUserData($conn, $user_id, $firstname, $lastname, $email);

    $conn->close();
}
else {
    // Jos pyyntö ei ole POST, näytetään ilmoitus.
    echo "Ei ole POST";
}