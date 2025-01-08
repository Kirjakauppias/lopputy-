<?php
session_start();
// TÄLLÄ SIVULLA SUORITETAAN KÄYTTÄJÄN TIETOJEN TARKISTUS JA PÄIVITYS

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

// verifyUserPassword()
include_once "./database/db_enquiry.php";
include_once "./database/db_add_data.php";

// Tarkistetaan, että pyyntö on lähetetty POST -metodilla
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Estetään XSS-hyökkäykset (htmlspecialchars).
    // Trim poistaa syötteen alusta ja lopusta ylimääräiset välilyönnit tai
    // muut ylimääräiset merkit.
    // 25.11. Lisätty $company_description
    $slogan = htmlspecialchars(trim($_POST['slogan'] ?? ''));
    $company_phone = htmlspecialchars(trim($_POST['company_phone'] ?? ''));
    $company_address = htmlspecialchars(trim($_POST['company_address'] ?? ''));
    $company_zipcode = htmlspecialchars(trim($_POST['company_zipcode'] ?? ''));
    $company_postplace = htmlspecialchars(trim($_POST['company_postplace'] ?? ''));
    $company_description = htmlspecialchars(trim($_POST['company_info'] ?? ''));

    // filter_var: jos syöte ei ole kelvollinen sähköpostiosoite, palauttaa FALSE
    $company_email = filter_var(trim($_POST['company_email'] ?? ''), FILTER_VALIDATE_EMAIL);

    $password = htmlspecialchars(trim($_POST['password'] ?? ''));
    // Haetaan funktio jolla tarkistetaan annettu salasana
    if(!verifyUserPassword($conn, $user_id, $password)) {
        die("Virheellinen salasana.");
    }
    // Tarkistetaan puhelinnumeron oikeellisuus (kotimainen tai kansainvälinen muoto).
    // ^ = aloitusmerkki.
    // 0 = numero alkaa nollalla.
    // \d{5,9} = seuraavat 5-9 numeroa.
    // (?:\+358) = numero alkaa +358.
    // \d{7,9} = voi olla 7-9 numeroa.
    // $ = päätösmerkki.
    if (preg_match('/^(?:0\d{5,9}|(?:\+358)\d{7,9})$/', $company_phone)) {
        // Tarkistetaan postinumeron oikeellisuus (muoto 12345)
        if(preg_match('/^\d{5}$/', $company_zipcode)) {
            if($company_email != FALSE) {
                // Päivitetään yrityksen tiedot
                // 25.11. Lisätty $company_description
                echo updateCompanyData($conn, $company_address, $company_zipcode, $company_postplace, $company_email, $company_phone, $company_description, $user_id, $slogan);
           } else {
                    echo "
                    <div id='result'>
                        <p>Sähköposti ei ole oikea.</p>
                    </div>
                    ";
                    exit();
           }
        } else {
            echo "
            <div id='result'>
                <p>Virheellinen postinumero. Sen tulee olla muodossa 12345.</p>
            </div>
            ";
            exit();
            }
    } else {
            // Näytetään virheilmoitus, jos puhelinnumero ei ole kelvollinen
            echo "
                <div id='result'>
                <p>Virheellinen puhelinnumero. Anna numero muodossa 0401234567 tai +358401234567.</p>
                </div>
            ";
            exit();
        } 
} else {
    // Jos pyyntö ei ole POST, näytetään ilmoitus.
    echo "Ei ole POST";
}