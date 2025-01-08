<?php
session_start();

include "database/db_connect.php";
include "database/db_enquiry.php";

$user_id = $_SESSION['user_id'];
$company_id = getCompanyIdByUser($conn, $user_id);

//include "funcs.php";
//printSessionData();

//echo "company_id ennen kyselyä: ";
//var_dump($company_id); // Näyttää tarkasti, onko se yksittäinen arvo vai taulukko

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
    <script src="https://unpkg.com/htmx.org"></script>
    <title>Tyylin hallinta</title>
<!--
    <style>
        body 
        {
            background-color: <?php echo $background_color ?: '#FFFFFF'; ?>;
            color: <?php echo $text_color ?: '#333333'; ?>;
            font-family: <?php echo $display_font ?: 'Verdana, sans-serif'; ?>;
        }
        header, footer 
        {
            background-color: <?php echo $header_color ?: '#004080'; ?>;
            color: <?php echo $footer_color ?: '#333333'; ?>;
        }
    </style>-->
    
</head>
<body>
    <!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tyylin hallinta</title>
    <style>
        html, body 
        {
            margin: 0;
            padding: 0;
            margin:0;
            height: auto;
            display: flex;
            flex-direction: row; 

        }
        form 
        {
            display: flex;
            flex-direction: column; /* Asettaa elementit pystysuoraan */
            align-items: flex-start; /* Kohdistaa elementit vasempaan reunaan */
            background-color: #f9f9f9;
            width: 20vw;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin:0;
        }

        form label, form input, form select, form button 
        {
            width: 100%; /* Takaa, että elementit täyttävät lomakkeen leveyden */
            height:100%;
            margin-bottom: 15px;
        }

            form input[type="color"], 
            form select, 
            form input[type="submit"], 
            form button 
        {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        form input[type="submit"], form button 
        {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        form input[type="submit"]:hover, form button:hover 
        {
            background-color: #45a049;
        }

        h1 
        {
            text-align: center;
            margin-bottom: 20px;
        }
        .container 
        {

            display: flex;
            width: 100%; 
            height: 100%; 
            overflow: hidden;
            margin: 0;
            padding: 0;
        }
        .formContainer 
        {
            display: flex;
            flex-direction: column;
            gap: 0px;
            justify-content: center;
            align-items: flex-start;
        }

        .menu 
        {
            background-color: #f1f1f1;
            border: 1px solid #ccc;
            border-radius: 8px;
            flex: 1;        /* Täyttää jäljelle jäävän tilan */
            height: 120%;  
            width: 80vw;
            margin: 0;
            padding: 0;
        }

        .menu a,
        .menu button 
        {
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .menu a:hover 
        {
            background-color: #0056b3;
        }
        button
        {
            background-color: #45a049;
            width: 100%;
            display: block;
            margin-bottom: 10px;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color:white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            
        }
        button:hover 
        {
            background-color: #45a049;
        }
        .company-content 
        {
            box-sizing: border-box;
            display: flex;
            justify-content: center;  
            align-items: center;     
            height: 80%;            
            position: relative;
        }

        .company-frame 
        {
            width: 100%;  
            height: 100%; 
            border: none;
            overflow: auto; 
        }
    </style>
</head>
<body>
<div class="formContainer">
<form action="saveStyle.php" method="post" hx-post="saveStyle.php" hx-target="body">
    <h1>Tyylien hallinta</h1>
    <button type="button" onclick="window.location.href='userpage.php'">
    Palaa oman sivun hallintaan
    </button>
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

    <input type="submit" formaction="saveStyle.php" value="Tallenna muutokset" class="buttonStyles">
    <button type="button" onclick="window.location.href='users/<?php echo $user_id; ?>/public_html/index.php'">Kotisivuillesi</button>
</form>

<!-- Kuvan latauslomake -->
<form id="uploadForm" 
          hx-post="upload.php" 
          hx-target="#uploadResult" 
          hx-encoding="multipart/form-data" 
          style="border: 1px solid #ccc; border-radius: 5px; max-width: 400px; background-color: #f9f9f9;">
          <input type="hidden" name="user_id" value="<?php echo isset($user_id) ? $user_id : ''; ?>">
        
        <label for="imageType" style="font-size: 14px; font-weight: bold;">Valitse kuvatyyppi:</label>
        <select name="image_type" id="imageType" style="width: 100%; padding: 5px; margin: 5px 0;" required>
            <option value="logo">Logo</option>
            <option value="kuva1">Kuva 1</option>
            <option value="kuva2">Kuva 2</option>
            <option value="kuva3">Kuva 3</option>
        </select>

        <label for="userImage" style="font-size: 14px; font-weight: bold;">Valitse kuva:</label>
        <input type="file" name="userImage" id="userImage" accept="image/*" style="width: 100%; padding: 5px;" required>

        <button type="submit">Lataa kuva</button>

        <div id="uploadResult" style="margin-top: 10px; font-size: 14px; color: #555;"></div>
    </form>
    <div id="imageUploadSection">
</div>
</div>
        <div class="container">
            <div class="menu">   
            <div class="company-content"> <!-- Haetaan käyttäjän index.php iframen avulla -->
            <iframe src="users/<?php echo $user_id; ?>/public_html/index.php" class="company-frame" frameborder="0">
            <!--22.11. TÄSSÄ TESTILINKKIIN-->
            <!--<iframe src="users/41/public_html/testi.php" class="company-frame" frameborder="0">-->
            Tämä selain ei tue iframea.
    </iframe>
</div>
</div>
</div>
</body>
</html>