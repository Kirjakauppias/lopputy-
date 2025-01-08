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
            <img src="../../../images/LeVaLogo1.png" class="logo">
            <div class="titleInfo">
                <div>
                    <a class="companyName"><?= htmlspecialchars(\$company['company_name']) ?></a>
                </div>
                <div>
                    <a class="companySlogan"><?= htmlspecialchars(\$company['slogan']) ?></a>
                </div>
            </div> 
        </header>
        <!-- <div class="navigaatio">
            <a href="userpage.php">Navigaatio 1</a>
            <a href="edit_user.php">Navigaatio 2</a>
            <a href="edit_company.php">Navigaatio 3</a>
        </div> --><!--/navigaatio-->
        <main>
            <div class="imageContainer">
                <div class="imageDiv"><img src="../../../images/LeVaLogo1.png" alt="image1" ></div>
                <div class="imageDiv"><img src="../../../images/LeVaLogo1.png" alt="image1" ></div>
                <div class="imageDiv"><img src="../../../images/LeVaLogo1.png" alt="image1" ></div>
            </div>
            <div class="description">
                <p><?= nl2br(htmlspecialchars(\$company['description'])) ?></p>
            </div>
        </main>
        <footer>
            <h3>Yhteystietomme</h3>
            <P><b><?= htmlspecialchars(\$company['company_name']) ?></b></p>
            <p>Y-tunnus: <?= htmlspecialchars(\$company['company_number']) ?></p>
            <p>Osoite: <?= htmlspecialchars(\$company['address']) ?>, <?= htmlspecialchars(\$company['zipcode']) ?> <?= htmlspecialchars(\$company['postplace']) ?></p>
            <p>E-mail: <?= htmlspecialchars(\$company['email']) ?></p>
            <p>Puheliln: <?= htmlspecialchars(\$company['phone_number']) ?></p>
            <hr>
            <p>© Copyright LeVa-verkkosivut.fi • 2024 •</p>
            <!--<img src="../../../images/LeVaLogo1.png" alt="">-->
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
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
        }
        header {
            width: 70%;
            margin: 0 auto;
            padding: 32px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            display: flex;
            align-items: center;
        }
        .titleInfo {
            width: 80%;
            text-align: center;
        }
        .companyName {
            font-size: 5vw; 
            font-weight: bold;
            color: white;
            text-decoration: none;
        }
        .companySlogan {
            font-size: 2vw; 
            color: white;
            text-decoration: none;
        }
        main {
            width: 70%;
            margin: 0 auto;
            min-height: 50vh;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        .description {
            padding: 32px;
        }

        footer {
            width: 70%;
            padding: 10px;
            margin: 0 auto;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        /*Responsiivinen kuva 20.11.*/
        .logo {
            width: 120px;
            height: 125px;
            margin-left: 4rem;
        }

        .imageContainer {
            display: flex;
            flex-wrap: wrap;
            background-color: #f1f1f1;
            justify-content: space-between;
            padding-top: 6px;
        }

        .imageDiv {
            flex: 33%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            margin: 1px;
        }

        .imageDiv img {
            width: 100%;
        }

        @media screen and (max-width: 869px) {

            .imageContainer {
                justify-content: center;
            }

            .imageDiv {
                flex: 100%;
                max-width: 70%;
                height: 50%;
            }

            header, main, footer {
                width: 100%;
            }
        }
        ";

        return $cssContent;
}