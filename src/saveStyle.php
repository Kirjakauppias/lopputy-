<?php
session_start();
include "database/db_connect.php";
include "database/db_enquiry.php";

$user_id = $_SESSION['user_id'];

if (isset($_POST['company_id']) && is_numeric($_POST['company_id'])) {
    $company_id = intval($_POST['company_id']); // Varmistetaan, että se on kokonaisluku
} else {
    // Jos company_id ei ole validi
    echo "Virheellinen company_id";
    exit;
}

include "funcs.php";
ob_start(); // lisätty 20.11.2024, kun yritin saada takaisin ohjauksen toimimaan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $background_color = $_POST['background_color'] ?? '#FFFFFF';
    $text_color = $_POST['text_color'] ?? '#333333';
    $header_color = $_POST['header_color'] ?? '#004080';
    $footer_color = $_POST['footer_color'] ?? '#333333';
    $header_font = $_POST['header_font'] ?? 'Arial, sans-serif';
    $display_font = $_POST['display_font'] ?? 'Verdana, sans-serif';
    $footer_font = $_POST['footer_font'] ?? 'Tahoma, sans-serif';

    // Tarkistetaan, onko rivi olemassa
    $sqlCheck = "SELECT COUNT(*) FROM company_style WHERE company_id = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("i", $company_id);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();
    print_r($company_id);
    if ($count > 0) {
        // Päivitetään arvot
        $sqlUpdate = "UPDATE company_style SET background_color = ?, text_color = ?, header_color = ?, footer_color = ?, header_font = ?, display_font = ?, footer_font = ? WHERE company_id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sssssssi", $background_color, $text_color, $header_color, $footer_color, $header_font, $display_font, $footer_font, $company_id);

        if ($stmtUpdate->execute()) {
            echo "Tyylit päivitetty onnistuneesti.";
        } else {
            echo "Virhe tyylejä päivittäessä: " . $stmtUpdate->error;
        }

        $stmtUpdate->close();
    } else {
        // Luodaan uusi rivi, jos sitä ei ole
        $sqlInsert = "INSERT INTO company_style (company_id, background_color, text_color, header_color, footer_color, header_font, display_font, footer_font) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("isssssss", $company_id, $background_color, $text_color, $header_color, $footer_color, $header_font, $display_font, $footer_font);

        if ($stmtInsert->execute()) {
            echo "Uudet tyylit tallennettu.";
        } else {
            echo "Virhe tyylejä tallentaessa: " . $stmtInsert->error;
        }

        $stmtInsert->close();
    }
}

$conn->close();

// Ohjaa takaisin 'testi.php' -sivulle
header("Location: testi.php");
exit; // Lopettaa skriptin suorituksen