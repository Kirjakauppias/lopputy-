<?php
// TÄÄLLÄ KÄSITELLÄÄN TIETOKANTA -HAUT
// Luodaan yhteys tietokantaan
include "db_connect.php";

// Funktio joka tarkastaa, että onko haettu data jo tietokannassa
function fetchStmt($stmt){
    // Haetaan tulos
    if($stmt->fetch()) {
        // Jos data löytyy, palautetaan TRUE
        $stmt->close();
        return TRUE;
    } else {
    // Jos data ei löydy, palautetaan FALSE
    $stmt->close();
    return FALSE;
    }
}

// Funktio joka varmistaa käyttäjän salasanan oikeellisuuden
function verifyUserPassword($conn, $user_id, $input_password) {
    // SQL -lause salasanan hakemiseen
    $sql = "SELECT password FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Varmistetaan että syötetty salasana täsmää tietokannassa olevan kanssa
    if ($user && password_verify($input_password, $user['password'])) {
        return true; // Salasana täsmää
    }
    return false; // Salasana ei täsmää
}

// Funktio joka tarkistaa, onko käyttäjätunnus jo tietokannassa
function checkUsernameExists($conn, $username) {
    // SQL-lause käyttäjänimen tarkistamiseksi
    $sql = "SELECT username FROM user WHERE username = ?";

    // Valmistellaan kysely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username); // Sidotaan parametrit
    $stmt->execute(); // Suoritetaan kysely
    $stmt->bind_result($username); // Sidotaan tulos muuttujaan

    return fetchStmt($stmt);
}

// Funktio joka tarkistaa, onko sähköposti jo tietokannassa
function checkUserEmailExists($conn, $email) {
    // SQL-lause käyttäjänimen tarkistamiseksi
    $sql = "SELECT email FROM user WHERE email = ?";

    // Valmistellaan kysely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // Sidotaan parametrit
    $stmt->execute(); // Suoritetaan kysely
    $stmt->bind_result($email); // Sidotaan tulos muuttujaan

    return fetchStmt($stmt);
}

// Funktio joka tarkistaa, onko yrityksen nimi jo tietokannassa.
function checkCompanyName($conn, $company_name) {
    // SQL-lause käyttäjänimen tarkistamiseksi
    $sql = "SELECT company_name FROM company WHERE company_name = ?";

    // Valmistellaan kysely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $company_name); // Sidotaan parametrit
    $stmt->execute(); // Suoritetaan kysely
    $stmt->bind_result($company_name); // Sidotaan tulos muuttujaan

    return fetchStmt($stmt);
}

function checkCompanyNameById($conn, $company_name, $user_id) {
    $sql = "SELECT company_name FROM company WHERE company_name = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $company_name, $user_id); // Bind parameters
    $stmt->execute(); // Execute the query
    $stmt->bind_result($company_name); // Bind result to variable

    return fetchStmt($stmt);
}

// Funktio joka tarkistaa, onko yrityksen y-tunnus jo tietokannassa.
function checkCompanyNumber($conn, $company_number) {
    // SQL-lause käyttäjänimen tarkistamiseksi
    $sql = "SELECT company_number FROM company WHERE company_number = ?";

    // Valmistellaan kysely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $company_number); // Sidotaan parametrit
    $stmt->execute(); // Suoritetaan kysely
    $stmt->bind_result($company_number); // Sidotaan tulos muuttujaan

    return fetchStmt($stmt);
}

// Funktio joka tarkistaa, onko yrityksen y-tunnus jo tietokannassa.
function checkCompanyEmail($conn, $company_email) {
    // SQL-lause käyttäjänimen tarkistamiseksi
    $sql = "SELECT email FROM company WHERE email = ?";

    // Valmistellaan kysely
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $company_email); // Sidotaan parametrit
    $stmt->execute(); // Suoritetaan kysely
    $stmt->bind_result($company_email); // Sidotaan tulos muuttujaan

    return fetchStmt($stmt);
}

// Funktio joka hakee yrityksen user_id:n perusteella
function checkCompanyByUser($conn, $user_id) {
    // SQL-lause company_id:n tarkistamiseksi
    $sql = "SELECT company_id FROM company WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    //$stmt->bind_result();

    $exists = $stmt->fetch() ? true : false;
    $stmt->close();
    return $exists;
}

// Funktio joka tarkistaa että onko tietokannassa jo olemassa url-nimi
function checkCompanyUrl($conn, $url) {
    $sql = "SELECT 1 FROM company WHERE company_url = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $url);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Funktio, joka hakee yrityksen tiedot käyttäjän ID:n perusteella
function getCompanyByUser($conn, $user_id) {
    // SQL-lause yrityksen hakemiseksi käyttäjälle
    $sql = "SELECT company_id, company_name, company_number, phone_number, email, address, zipcode, postplace, description, slogan FROM company WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Tarkistetaan, löytyikö yritystä
    if ($result && $result->num_rows > 0) {
        // Palautetaan ensimmäinen rivi, eli yrityksen tiedot
        return $result->fetch_assoc();
    }

    $stmt->close();
    return null;  // Ei löytynyt yritystä
}

// Funktio, joka hakee yrityksen tiedot käyttäjän ID:n perusteella
// Päivitetty 17.11.
function getCompanyIdByUser($conn, $user_id) {
    // SQL-lause yrityksen hakemiseksi käyttäjälle
    $sql = "SELECT company_id FROM company WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Tarkistetaan, löytyikö yritystä
    if ($result && $result->num_rows > 0) {
        // Palautetaan suoraan 'company_id' -arvo 17.11.
        $row = $result->fetch_assoc();
        return (int) $row['company_id'];
     }

    $stmt->close();
    return null;  // Ei löytynyt yritystä
}

// Funktio joka hakee yritys-sivun tyylitiedot tietokannasta 16.11.
function getCompanyStyles($conn, $company_id) {
    $query = "SELECT background_color, text_color, header_color, footer_color, header_font, display_font, footer_font FROM company_style WHERE company_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        $stmt->close();
        return null; // Palautetaan null, jos tyylejä ei löytynyt
    }
}

// 1.12. Haetaan tietokannasta käyttäjän status
function getUserStatus($conn, $user_id) {
    $query = $conn->prepare("SELECT status FROM user WHERE user_id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
    $user_status = $result->num_rows > 0 ? $result->fetch_assoc()['status'] : null;
    $query->close();
    return $user_status;
}