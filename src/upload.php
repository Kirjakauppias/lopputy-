<?php
// Luodaan yhteys tietokantaan
include "./database/db_connect.php";

// Tarkistetaan, että tiedosto on ladattu oikein
if (isset($_FILES['userImage']) && $_FILES['userImage']['error'] === UPLOAD_ERR_OK) 
{
    // Tunnisteet tulevat POST-tiedostosta
    $userId = $_POST['user_id'];
    $imageType = $_POST['image_type']; // 'logo', 'kuva1', 'kuva2', 'kuva3'

    // Määritellään hakemisto, johon kuva tallennetaan
    $uploadDir = './users/' . $userId . '/images/' . $imageType . '/';

    // Luodaan hakemisto, jos sitä ei vielä ole
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0777, true)) 
        {
            echo "<p>Hakemiston luominen epäonnistui.</p>";
            exit;
        }
    }

    // Poistetaan vanha kuva, jos se on olemassa
    $oldFilePath = $uploadDir . $imageType . '.png';
    if (file_exists($oldFilePath)) 
    {
        if (unlink($oldFilePath)) {
            echo "<p>Vanha kuva poistettu.</p>";
        } else {
            echo "<p>Vanhan kuvan poistaminen epäonnistui.</p>";
        }
    }

    // Haetaan tiedoston alkuperäinen päätteen laajennus
    $fileExtension = pathinfo($_FILES['userImage']['name'], PATHINFO_EXTENSION);

    // Määritellään tiedostonnimi sen tyypin mukaan (kuva1.png, kuva2.png jne.)
    $newFileName = $imageType . '.png'; // Käytetään image_type arvoa ja lisätään .png-pääte

    // Määritellään tiedostopolku
    $uploadFilePath = $uploadDir . $newFileName;

    // Siirretään ladattu tiedosto lopulliseen hakemistoon
    if (move_uploaded_file($_FILES['userImage']['tmp_name'], $uploadFilePath)) 
    {
        echo "<p>Tiedosto ladattu onnistuneesti: 
        <img src='$uploadFilePath?" . time() . "' alt='Ladattu kuva' style='max-width: 100%; border-radius:4px;'></p>";
    // Lisätään automaattinen sivun päivitys
    echo "<script>
        setTimeout(function() 
        {
            location.reload(true); // true pakottaa välimuistin ohittamisen
        }, 1000); // 1000 ms = 1 sekunti
        </script>";
    } 
    else 
    {
        echo "<p>Tiedoston tallentaminen epäonnistui. Tarkista tiedostokoko ja oikeudet.</p>";
    }
} 
else 
{
    echo "<p>Kuvan lataus epäonnistui. Varmista, että tiedosto on valittu oikein.</p>";
}

// Suljetaan tietokantayhteys, jos se on määritelty
if (isset($conn)) {
    $conn->close();
}
