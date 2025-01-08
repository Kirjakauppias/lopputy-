<?php
session_start();
include "database/db_connect.php";
include "database/db_enquiry.php";

print_r($_POST);
$user_id = $_SESSION['user_id'];
$company_id = getCompanyIdByUser($conn, $user_id);

if (isset($_POST['color'])) {
    $color = $_POST['color'];

    // Varmistetaan, että väri on suojattu (oletus: hex-koodi)
    $color = htmlspecialchars($color);

    // Tarkistetaan, onko rivi olemassa company_id:lle
    $sqlCheck = "SELECT COUNT(*) FROM company_styles WHERE company_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $company_id);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($count > 0) {
        // Jos rivi löytyy, päivitetään se
        $sqlUpdate = "UPDATE company_styles SET background_color = ? WHERE company_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("si", $color, $company_id);

        if ($stmtUpdate->execute()) {
            echo "Väri päivitetty onnistuneesti: " . $color;
        } else {
            echo "Virhe väriä tallentaessa: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        // Jos riviä ei löydy, lisätään uusi rivi
        $sqlInsert = "INSERT INTO company_styles (company_id, background_color) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("is", $company_id, $color);

        if ($stmtInsert->execute()) {
            echo "Väri lisätty ja tallennettu onnistuneesti: " . $color;
        } else {
            echo "Virhe väriä lisättäessä: " . $stmtInsert->error;
        }

        $stmtInsert->close();
    }
}

$conn->close();

