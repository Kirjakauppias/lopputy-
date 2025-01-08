<?php
session_start(); // Aloitetaan sessio
//session_destroy();

//include "funcs.php";
//printSessionData();

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/index.css">
    <script src="https://unpkg.com/htmx.org@1.9.3"></script> <!-- HTMX-kirjaston linkitys-->
</head>
<body>
    <header>
        <div>
            <div class="companyName">
                <img src="images/LeVaLogo1.png">Verkkosivut</img>
            </div>
            <div class="companySlogan">
                <a>Helppo, nopea ja vaivaton tapa tehdä verkkosivut</a><br><br>
                <a href="company_list.php" target="_blank">LeVa -verkkosivuilla luodut yritykset</a> 
            </div>
        </div>
    </header>
    <div class="centerBase">
        <div class="description">
        Luo helposti omat verkkosivusi - ilman teknistä osaamista!

        <p>Tervetuloa LeVa verkkosivuille, täällä oman kotisivun rakentaminen on tehty helpoksi ja vaivattomaksi. 
        Olitpa aloittamassa yritystoimintaa tai päivittämässä brändiäsi, kotisivukoneemme tarjoaa sinulle 
        kaikki tarvittavat työkalut tyylikkäiden ja ammattimaisten verkkosivujen luomiseen. Valitse fontit, 
        värit ja tyyli - anna kotisivusi kertoa tarinasi juuri omalla tavallasi!</p>

        Luo kotisivusi jo tänään ja tee vaikutus verkossa!
        </div>
        <?php if(!isset($_SESSION['user_id'])): ?> <!-- Näytä kirjautumislomake vain, jos käyttäjä ei ole kirjautunut -->
        <div class="loginForm"> <!-- Kirjautumislomake -->
        <form  
            hx-post="username_exists.php"  
            hx-target=".error-messages" 
            hx-swap="innerHTML"
            hx-push-url="false">
            <!-- hx-post="username_exists.php"  Lähetetään tiedot username_exists.php-tiedostoon
             hx-target=".loginForm" määritetään mihin kohtaan tulokset näytetään
             hx-swap="innerHTML" vaihdetaan vain sisällön html
             hx-push-url="false" ei vaihdeta URL-osoitetta -->
            <label for="username">Käyttäjätunnus:</label>
            <input type="username" id="username" name="username" placeholder="Käyttäjätunnus" required>

            <label for="password">Salasana:</label>
            <input type="password" id="password" name="password" placeholder="Salasana" required>

            <button type="submit">Kirjaudu</button>            
        </form>
        <div class="addUser">
            <p> Mikäli sinulla ei vielä ole käyttäjätunnusta, pääset luomaan sen tästä. 
                <a href="register.php">Rekisteröidy</a> <!-- Tämä toimii suorana linkkinä -->
            </p>
        </div>
        <div class="error-messages"></div> <!-- Virheviesti näkyy täällä -->
        </div>
        <?php else: ?>
            <!-- Tämä näytetään, jos käyttäjä on jo kirjautunut --> 
            <H1>Hei <span id="customerName" hx-get="get_user_info.php" hx-trigger="load" hx-swap="innerHTML"></span>,</H1> 
            <p>tästä pääset muokkaamaan omia verkkosivuja.</p>
            <a href="userpage.php">
            <button>Oman sivun hallinta</button>
        <?php endif; ?>
            
    </div>
    <footer>
        <div class="footerContainer">
            <div class="footerSection">
                <h3>LeVa Verkkosivut</h3>
                <p>Osoite: Verkkosivukoneentie 1</p>
                <p>Sähköposti: leva@leva.fi</p>
                <p>Puhelin: 017 007 007</p>
            </div>
            <div class="footerLogo">
                <img src="images/LeVaLogo1.png" alt="LeVa Logo">
            </div>
        </div>
    </footer>
</body>
</html>