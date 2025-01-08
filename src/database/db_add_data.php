<?php
// TÄÄLLÄ LISÄTÄÄN DATAA TIETOKANTAAN
// Luodaan yhteys tietokantaan
include_once "db_connect.php";
// 18.11. Lisätty yhteys 
include_once "db_enquiry.php";

// Funktio, jolla lisätään uusi käyttäjä tietokantaan
function addUser($conn, $firstname, $lastname, $username, $email, $hashedPassword, $status) {
    // SQL-lause uuden käyttäjän lisäämiseksi.
    $sql = "INSERT INTO user(firstname, lastname, username, email, password, status)
            VALUES (?, ?, ?, ?, ?, ?)";

    // Valmistellaan SQL-lause
    if ($stmt = $conn->prepare($sql)) { // Tarkistetaan, onnistuiko valmistelu.
        // Bindataan (sidotaan) parametrit, joilla täytetään SQL-lause.
        // Käytetään "ssssss" -tyyppimääritystä, koska kaikki arvot ovat merkkijonoja.
        $stmt->bind_param("ssssss", $firstname, $lastname, $username, $email, $hashedPassword, $status);
        // Suoritetaan kysely tietokantaan.
        $stmt->execute();               
        // Suljetaan valmisteltu lausunto, kun sitä ei enää tarvita.
        $stmt->close();
    } else {
        // Jos kyselyn valmistelu epäonnistuu, näytetään virheilmoitus käyttäjälle
        echo "
                <div id='result'>
                    <p>Virhe kyselyn valmistelussa: " . $conn->error . "
                </div>    
            ";
    }
}

// Funktio, jolla lisätään uusi yritys tietokantaan
function addCompany($conn, $company_name, $company_number, $company_address, $company_zipcode, $company_postplace, $company_email, $company_phone, $company_info, $user_id, $url, $slogan) {
    // SQL-lause uuden käyttäjän lisäämiseksi.
    $sql = "INSERT INTO company(company_name, company_number, address, zipcode, postplace, email, phone_number, description, user_id, company_url, slogan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Valmistellaan SQL-lause
    if ($stmt = $conn->prepare($sql)) { // Tarkistetaan, onnistuiko valmistelu.
        // Bindataan (sidotaan) parametrit, joilla täytetään SQL-lause.
        // Käytetään "ssssss" -tyyppimääritystä, koska kaikki arvot ovat merkkijonoja.
        $stmt->bind_param("ssssssssiss", $company_name, $company_number, $company_address, $company_zipcode, $company_postplace, $company_email, $company_phone, $company_info, $user_id, $url, $slogan);
        // Suoritetaan kysely tietokantaan.
        $stmt->execute();               
        // Suljetaan valmisteltu lausunto, kun sitä ei enää tarvita.
        $stmt->close();
    } else {
        // Jos kyselyn valmistelu epäonnistuu, näytetään virheilmoitus käyttäjälle
        echo "
                <div id='result'>
                    <p>Virhe kyselyn valmistelussa: " . $conn->error . "
                </div>    
            ";
    }
}

// Funktio joka päivittää käyttäjän tiedot
function updateUserData($conn, $user_id, $firstname, $lastname, $email) {
    // Valmistellaan SQL -lauseke
    $sql = "UPDATE user SET firstname = ?, lastname = ?, email = ?, updated_at = NOW() WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $firstname, $lastname, $email, $user_id);

    // Suoritetaan statement ja palautetaan tulos
    if($stmt->execute()) {
        $stmt->close();
        return "<div id='result'>Tiedot päivitetty onnistuneesti!</div>";
    } else {
        $stmt->close();
        return "<div id='result'>Virhe tietojen päivittämisessä</div>";
    }
}

// Funktio joka päivittää käyttäjän yrityksen tiedot
// 25.11. Lisätty $company_description
function updateCompanyData($conn, $company_address, $company_zipcode, $company_postplace, $company_email, $company_phone, $company_description, $user_id, $slogan) {
    // Valmistetaan SQL-lauseke
    $sql = "UPDATE company SET address = ?, zipcode = ?, postplace = ?, email = ?, phone_number = ?, description = ?, updated_at = NOW(), slogan = ? WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        // Palautetaan virheilmoitus, jos SQL-Lauseen valmistelu epäonnistuu
        return "<div id='result'>Virhe SQL-lauseen valmistelussa: " . $conn->error . "</div>";
    }
    // Bindataan parametrit
    if (!$stmt->bind_param("sssssssi", $company_address, $company_zipcode, $company_postplace, $company_email, $company_phone, $company_description, $slogan, $user_id)) {
        // Palautetaan virheilmoitus, jos parametrit eivät kelpaa:
        $stmt->close();
        return "<div id='result'>Virhe parametrien bindauksessa: " . $stmt->error . "</div>";
    }

    // Suoritetaan statement ja palautetaan tulos
    if($stmt->execute()) {
        $stmt->close();
        return "<div id='result'>Tiedot päivitetty onnistuneesti!</div>";
    } else {
        $error = $stmt->error;
        $stmt->close();
        return "<div id='result'>Virhe tietojen päivittämisessä" . $error . "</div>";
    }
}

// Funktio joka lisää yritykselle oletus-sivutyylin 15.11.
function addCompanyStyle($conn, $company_id) {
    // Lisätään uuden tietueen company_style-tauluun käyttäen oletusarvoja
    $sql = "INSERT INTO company_style (company_id) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL-virhe: " . $conn->error); // Tarkistetaan, että lausekkeen valmistelu onnistui
    }

    // Bindataan parametrin arvo
    $stmt->bind_param("i", $company_id); // "i" tarkoittaa, että parameter on integer

    // Suoritetaan kysely
    if ($stmt->execute()) {
        // Kysely onnistui
        echo "Yrityksen tyylit luotu onnistuneesti!";
    } else {
        // Kysely epäonnistui
        echo "Virhe tyylien luomisessa: " . $stmt->error;
    }

    // Suljetaan lauseke
    $stmt->close();
}