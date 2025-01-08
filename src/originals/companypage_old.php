<?php

// Funktio joka tuottaa yritysten index.php -tiedoston sisällön
function generatePageContent($conn, $user_id) {
    // Luodaan sisältö muuttujaan heredoc-syntaksilla.
    $indexContent = <<<HTML
    <?php
    // Tämä tiedosto näyttää yrityksen tiedot
    include_once "../../../database/db_enquiry.php";

    // Haetaan yrityksen id ja tyylit tietokannasta 17.11.
    \$company_id = getCompanyIdByUser(\$conn, $user_id);
    \$company_styles = getCompanyStyles(\$conn, \$company_id);

    // Jos tyylejä ei löydy, määritellään oletusarvot 17.11.
    if (\$company_styles) {
        \$background_color = \$company_styles['background_color'];
        \$text_color = \$company_styles['text_color'];
        \$header_color = \$company_styles['header_color'];
        \$footer_color = \$company_styles['footer_color'];
        \$header_font = \$company_styles['header_font'];
        \$display_font = \$company_styles['display_font'];
        \$footer_font = \$company_styles['footer_font'];
    }else {
        // Oletusarvot, jos tyylejä ei löydy 17.11.
        \$background_color = '#FFFFFF';
        \$text_color = '#333333';
        \$header_color = '#004080';
        \$footer_color = '#333333';
        \$header_font = 'Arial, sans-serif';
        \$display_font = 'Verdana, sans-serif';
        \$footer_font = 'Tahoma, sans-serif';
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
        <script src="../../../../htmx.js" defer></script>
        <!-- Dynaamiset tyylit tietokannasta 17.11.-->
        <style>
            body {
                background-color: <?php echo htmlspecialchars(\$background_color); ?>;
                color: <?php echo htmlspecialchars(\$text_color); ?>;
                font-family: <?php echo htmlspecialchars(\$display_font); ?>;
            }
            
            header {
                background-color: <?php echo htmlspecialchars(\$header_color); ?>;
                font-family: <?php echo htmlspecialchars(\$header_font); ?>;
            }
            
            footer {
                background-color: <?php echo htmlspecialchars(\$footer_color); ?>;
                font-family: <?php echo htmlspecialchars(\$footer_font); ?>;
            }
        </style>
    </head>
    </head>
<body>
<?php
    // Tarkistetaan, onko yritys olemassa tietokannassa
    \$company = getCompanyByUser(\$conn, $user_id);
    
    if (\$company) 
    {
        ?>
<header>
    <div class="headerContainer">
        <img src="../../../images/LeVaLogo1.png" class="logo">
        <div class="companyInfo">
            <div class="companyName">
                <a><?= htmlspecialchars(\$company['company_name']) ?></a>
            </div>
            <div class="companySlogan">
                <a><?= htmlspecialchars(\$company['slogan']) ?></a> 
            </div>
        </div>
    </div>
</header>
<div class="centerBase">
<!-- <div class="navigaatio">
        <a href="userpage.php">Navigaatio 1</a>
        <a href="edit_user.php">Navigaatio 2</a>
        <a href="edit_company.php">Navigaatio 3</a>
    </div> --><!--/navigaatio-->
        <div class="description">
            <p><?= nl2br(htmlspecialchars(\$company['description'])) ?></p>
        </div>
    </div>
    <footer>
        <div class="footerContainer">
            <div class="footerSection">
                <h3><?= htmlspecialchars(\$company['company_name']) ?></h3>
                <p><?= htmlspecialchars(\$company['address']) ?>, <?= htmlspecialchars(\$company['zipcode']) ?> <?= htmlspecialchars(\$company['postplace']) ?></p>
                <p><?= htmlspecialchars(\$company['email']) ?></p>
                <p><?= htmlspecialchars(\$company['phone_number']) ?></p>
                <p><?= htmlspecialchars(\$company['company_number']) ?></p>
            </div>
            <div class="footerLogo">
                <!--<img src="../../../images/LeVaLogo1.png" alt="">-->
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
HTML;

    return $indexContent;
}

// Funktio joka luo yritys-sivun tyylitiedoston sisällön 16.11.
// 18.11. Poistettu muuttujat $conn ja $company_id
function generateStyleContent() {
    
        // Rakennetaan CSS-tiedosto
        $cssContent = "
        body /*TESTI TESTI TESTI*/{
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            flex-direction: column;
        }
        
        header {
            color: #fff;
            width: 80%;
        }

        footer {
            color: #fff;
            position: relative;
            width: 80%;
        }

        .headerContainer 
        {
            display: flex;
            align-items: center; 
            justify-content: space-between; 
            margin: 0 auto; 
            padding:4%;
        }

        .logo 
        {
            max-width: 12vw; 
        }

        .companyInfo 
        {
            text-align: center;
            margin-right: 10%;
        }

        .companyName a 
        {
            font-size: 5vw; 
            font-weight: bold;
            color: white;
            text-decoration: none;
        }

        .companySlogan a 
        {
            font-size: 2vw; 
            color: white;
            text-decoration: none;
        }
        .navigaatio 
        {
            width: 60%;
            display: flex;
            margin:auto;
            justify-content: flex-start;
            align-items: center;
            padding-bottom: 0;
        }

        .navigaatio a 
        {
            display: inline-block;
            background-color: rgb(70, 68, 68);
            color: white;
            padding: 10px 12px;
            border: none;
            border-radius: 4px 4px 0 0;
            text-decoration: none;
            margin: 0 8px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border:2px white solid;
        }

        .navigaatio a:hover 
        {
            background-color: rgb(187, 185, 185);
        }

        .centerBase 
        {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            flex-direction: column;
            width: 80%;
            min-height: 50vh;
            border-left: 1px rgb(173, 172, 172) solid;
            border-right: 1px rgb(173, 172, 172) solid;
        }

        .description 
        {
            font-size: 1.2vw;
            margin: auto;
            text-align: center;
            width: 80%;
        }

        ";

        return $cssContent;
}