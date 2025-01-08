<?php
session_start();

include "database/db_connect.php";
include "database/db_enquiry.php";

$user_id = $_SESSION['user_id'];
$company_id = getCompanyIdByUser($conn, $user_id);

include "funcs.php";
printSessionData();

echo "company_id ennen kyselyä: ";
var_dump($company_id); // Näyttää tarkasti, onko se yksittäinen arvo vai taulukko

// Haetaan nykyiset arvot tietokannasta
$sql = "SELECT background_color, text_color, header_color, footer_color, header_font, display_font, footer_font FROM company_style WHERE company_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();
$stmt->bind_result($background_color, $text_color, $header_color, $footer_color, $header_font, $display_font, $footer_font);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyylin hallinta</title>
    <style>
        body {
            background-color: <?php echo $background_color ?: '#FFFFFF'; ?>;
            color: <?php echo $text_color ?: '#333333'; ?>;
            font-family: <?php echo $display_font ?: 'Verdana, sans-serif'; ?>;
        }
        header, footer {
            background-color: <?php echo $header_color ?: '#004080'; ?>;
            color: <?php echo $footer_color ?: '#333333'; ?>;
        }
    </style>
</head>
<body>
    <h1>Tyylien hallinta</h1>
    <!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyylin hallinta</title>
    <style>
        body {
            background-color: <?php echo $background_color ?: '#FFFFFF'; ?>;
            color: <?php echo $text_color ?: '#333333'; ?>;
            font-family: <?php echo $display_font ?: 'Verdana, sans-serif'; ?>;
        }
        header, footer {
            background-color: <?php echo $header_color ?: '#004080'; ?>;
            color: <?php echo $footer_color ?: '#333333'; ?>;
        }
    </style>
</head>
<body>
    <h1>Tyylien hallinta</h1>
    <form action="saveStyle.php" method="post">
        <input type="hidden" name="company_id" value="<?php echo htmlspecialchars($company_id); ?>">
        <label for="background_color">Taustaväri:</label>
        <input type="color" id="background_color" name="background_color" value="<?php echo $background_color; ?>"><br>

        <label for="text_color">Tekstin väri:</label>
        <input type="color" id="text_color" name="text_color" value="<?php echo $text_color; ?>"><br>

        <label for="header_color">Otsikon väri:</label>
        <input type="color" id="header_color" name="header_color" value="<?php echo $header_color; ?>"><br>

        <label for="footer_color">Alatunnisteen väri:</label>
        <input type="color" id="footer_color" name="footer_color" value="<?php echo $footer_color; ?>"><br>

        <label for="header_font">Otsikon fontti:</label>
        <select id="header_font" name="header_font">
            <option value="Arial, sans-serif" <?php echo $header_font == 'Arial, sans-serif' ? 'selected' : ''; ?>>Arial</option>
            <option value="Verdana, sans-serif" <?php echo $header_font == 'Verdana, sans-serif' ? 'selected' : ''; ?>>Verdana</option>
            <option value="Tahoma, sans-serif" <?php echo $header_font == 'Tahoma, sans-serif' ? 'selected' : ''; ?>>Tahoma</option>
            <option value="Georgia, serif" <?php echo $header_font == 'Georgia, serif' ? 'selected' : ''; ?>>Georgia</option>
            <option value="Times New Roman, serif" <?php echo $header_font == 'Times New Roman, serif' ? 'selected' : ''; ?>>Times New Roman</option>
        </select><br>

        <label for="display_font">Näytön fontti:</label>
        <select id="display_font" name="display_font">
            <option value="Arial, sans-serif" <?php echo $display_font == 'Arial, sans-serif' ? 'selected' : ''; ?>>Arial</option>
            <option value="Verdana, sans-serif" <?php echo $display_font == 'Verdana, sans-serif' ? 'selected' : ''; ?>>Verdana</option>
            <option value="Tahoma, sans-serif" <?php echo $display_font == 'Tahoma, sans-serif' ? 'selected' : ''; ?>>Tahoma</option>
            <option value="Georgia, serif" <?php echo $display_font == 'Georgia, serif' ? 'selected' : ''; ?>>Georgia</option>
            <option value="Times New Roman, serif" <?php echo $display_font == 'Times New Roman, serif' ? 'selected' : ''; ?>>Times New Roman</option>
        </select><br>

        <label for="footer_font">Alatunnisteen fontti:</label>
        <select id="footer_font" name="footer_font">
            <option value="Arial, sans-serif" <?php echo $footer_font == 'Arial, sans-serif' ? 'selected' : ''; ?>>Arial</option>
            <option value="Verdana, sans-serif" <?php echo $footer_font == 'Verdana, sans-serif' ? 'selected' : ''; ?>>Verdana</option>
            <option value="Tahoma, sans-serif" <?php echo $footer_font == 'Tahoma, sans-serif' ? 'selected' : ''; ?>>Tahoma</option>
            <option value="Georgia, serif" <?php echo $footer_font == 'Georgia, serif' ? 'selected' : ''; ?>>Georgia</option>
            <option value="Times New Roman, serif" <?php echo $footer_font == 'Times New Roman, serif' ? 'selected' : ''; ?>>Times New Roman</option>
        </select><br>

        <input type="submit" value="Tallenna muutokset">
    </form>
</body>
</html>