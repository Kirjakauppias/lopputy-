<?php
// Luodaan yhteys tietokantaan
include "./database/db_connect.php";

// Tarkistetaan että tiedosto on ladattu oikein
if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] === UPLOAD_ERR_OK) {

    // Tunnisteet tulevat POST-tiedostosta
    $userId = $_POST['user_id'];
    $companyId = $_POST['user_id'];

    // Määritellään tallennushakemisto
    $uploadDir = './userImages/';

    // Luodaan hakemisto, jos sitä ei vielä ole
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Määritellään tiedostonnimi ja polku
    $fileName = uniqid() . '_' . basename($_FILES['userImage']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    // Siirretään ladattu tiedosto lopulliseen hakemistoon
    if (move_uploaded_file($_FILES['userImage']['tmp_name'], $uploadFilePath)) {

        // Valmistellaan SQL -lause kuvan tallentamiseksi tietokantaan
        $sql = "INSERT INTO user_image (user_id, company_id, file_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $userId, $companyId, $uploadFilePath);

        // Suoritetaan kysely
        if ($stmt->execute()) {
            echo "<p>Kuva ladattu onnistuneesti: <a href='$uploadFilePath'>Näytä kuva</a></p>";
        } else {
            echo "<p>Tiedoston tallentaminen tietokantaan epäonnistui: " . $stmt->error . "</p>";
        }

        // Suljetaan valmisteltu lauseke
        $stmt->close();
    } else {
        echo "<p>Tiedoston tallentaminen epäonnistui.</p>";
    }
} else {
    echo "<p>Kuvan lataus epäonnistui.</p>";
}

// Suljetaan tietokantayhteys
$conn->close();