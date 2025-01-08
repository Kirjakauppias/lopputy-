<?php

// Funktio joka tuottaa yritysten index.php -tiedoston sisällön 13.11.
function generatePageContent($conn, $user_id) {
    // Luodaan sisältö muuttujaan 13.11.
    // Käytetään heredoc -syntaksia.
    $indexContent = <<<HTML
    <?php
    // Tämä tiedosto näyttää yrityksen tiedot


    include_once "../../../database/db_enquiry.php";
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Yrityksen Tiedot</title>
        <link rel="stylesheet" href="../../../styles/webpage.css">
        <script src="https://unpkg.com/htmx.org@1.9.3"></script> <!-- HTMX-kirjaston linkitys -->
        <script src="../../../htmx.js" defer></script>
    </head>
    <body>
    <?php
    // Tarkistetaan, onko yritys olemassa tietokannassa
    \$company = getCompanyByUser(\$conn, $user_id);
    
    if (\$company) {
        ?>
        <div class="container">
            <header>
                <h1><?php echo htmlspecialchars(\$company['company_name'])?></h1>
            </header>
            <main>
            <?php
            echo "<div class='company-info'>";                        
            echo "<p><strong>Y-tunnus:</strong> " . htmlspecialchars(\$company['company_number']) . "</p>";
            echo "<p><strong>Puhelinnumero:</strong> " . htmlspecialchars(\$company['phone_number']) . "</p>";
            echo "<p><strong>Sähköposti:</strong> " . htmlspecialchars(\$company['email']) . "</p>";
            echo "<p><strong>Osoite:</strong> " . htmlspecialchars(\$company['address']) . ", " . htmlspecialchars(\$company['zipcode']) . " " . htmlspecialchars(\$company['postplace']) . "</p>";
            echo "<p><strong>Kuvaus:</strong> " . nl2br(htmlspecialchars(\$company['description'])) . "</p>";
            echo "</div>";
        } else {
            echo "<p>Yrityksen tietoja ei löytynyt.</p>";
        }
        ?>
            </main>
            <footer>
                <p>&copy; 2024 LeVa-Verkkosivut</p>
            </footer>
        </div>

    HTML;

    return $indexContent;
}