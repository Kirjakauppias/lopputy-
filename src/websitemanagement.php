<?php
    // Tämä tiedosto näyttää yrityksen tiedot
    include_once "database/db_enquiry.php";

    // Haetaan yrityksen id ja tyylit tietokannasta 17.11.
    $company_id = getCompanyIdByUser($conn, 40);
    $company_styles = getCompanyStyles($conn, $company_id);

    // Jos tyylejä ei löydy, määritellään oletusarvot 17.11.
    if ($company_styles) {
        $background_color = $company_styles['background_color'];
        $text_color = $company_styles['text_color'];
        $header_color = $company_styles['header_color'];
        $footer_color = $company_styles['footer_color'];
        $header_font = $company_styles['header_font'];
        $display_font = $company_styles['display_font'];
        $footer_font = $company_styles['footer_font'];
    }else {
        // Oletusarvot, jos tyylejä ei löydy 17.11.
        $background_color = '#FFFFFF';
        $text_color = '#333333';
        $header_color = '#004080';
        $footer_color = '#333333';
        $header_font = 'Arial, sans-serif';
        $display_font = 'Verdana, sans-serif';
        $footer_font = 'Tahoma, sans-serif';
    }
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Yrityksen Tiedot</title>
        <!--Muutettu tyylitiedoston osoitetta "../../../styles/companypage2.css" 16.11.-->
        <link rel="stylesheet" href="companypage.css">
        <script src="https://unpkg.com/htmx.org@1.9.3"></script> <!-- HTMX-kirjaston linkitys -->
        <script src="htmx.js" defer></script>
<!-- TESTI TESTI TESTI TESTI -->
        <!-- Dynaamiset tyylit tietokannasta 17.11.-->
        <style>
            body {
                background-color: <?php echo htmlspecialchars($background_color); ?>;
                color: <?php echo htmlspecialchars($text_color); ?>;
                font-family: <?php echo htmlspecialchars($display_font); ?>;
            }
            
            header {
                background-color: <?php echo htmlspecialchars($header_color); ?>;
                font-family: <?php echo htmlspecialchars($header_font); ?>;
            }
            
            footer {
                background-color: <?php echo htmlspecialchars($footer_color); ?>;
                font-family: <?php echo htmlspecialchars($footer_font); ?>;
            }
        </style>
    </head>
    </head>
<body>
<?php
    // Tarkistetaan, onko yritys olemassa tietokannassa
    $company = getCompanyByUser($conn, 40);
    
    if ($company) 
    {
        ?>
<header>
    <div class="headerContainer">
        <img src="images/LeVaLogo1.png" class="logo">
        <div class="companyInfo">
            <div class="companyName">
                <a><?= htmlspecialchars($company['company_name']) ?></a>
            </div>
            <div class="companySlogan">
                <a><?= htmlspecialchars($company['slogan']) ?></a> 
            </div>
        </div>
    </div>
</header>
<div class="centerBase">
<div class="navigaatio">
        <a href="userpage.php">Navigaatio 1</a>
        <a href="edit_user.php">Navigaatio 2</a>
        <a href="edit_company.php">Navigaatio 3</a>
    </div> <!--/navigaatio-->
        <div class="description">
            <p><?= nl2br(htmlspecialchars($company['description'])) ?></p>
        </div>
    </div>
    <footer>
        <div class="footerContainer">
            <div class="footerSection">
                <h3><?= htmlspecialchars($company['company_name']) ?></h3>
                <p><?= htmlspecialchars($company['address']) ?>, <?= htmlspecialchars($company['zipcode']) ?> <?= htmlspecialchars($company['postplace']) ?></p>
                <p><?= htmlspecialchars($company['email']) ?></p>
                <p><?= htmlspecialchars($company['phone_number']) ?></p>
                <p><?= htmlspecialchars($company['company_number']) ?></p>
            </div>
            <div class="footerLogo">
                <img src="images/LeVaLogo1.png" alt="">
            </div>   
        </div>
        <div class="copyright">
            <p>© Copyright LeVa-verkkosivut.fi • 2024 •</p>
        </div>
    </footer>
<?php
    } else {
        echo "<p>Yrityksen tietoja ei löytynyt.</p>";
    }
?>
</body>
</html>