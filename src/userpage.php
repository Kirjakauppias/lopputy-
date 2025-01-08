<?php
session_start(); // Aloitetaan sessio
require "database/db_connect.php"; // Lisää tämä

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

// 1.12. Haetaan käyttäjän tiedot, mukaan lukien status 
$query = $conn->prepare("SELECT status FROM user WHERE user_id =?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user_status = $result->num_rows > 0 ? $result->fetch_assoc()['status'] : null;

$query->close();

// Tarkistetaan, onko käyttäjällä rekisteröity yritys tietokantaan
$query = $conn->prepare("SELECT company_id, company_name FROM company WHERE user_id = ?");
$query->bind_param("i", $user_id); // sidotaan muuttuja user_id kyselyyn
$query->execute();
$result = $query->get_result();
$company_exists = $result->num_rows > 0; // Tarkistetaan, löytyykö yrityksen tietoja
$company_name = $company_exists ? $result->fetch_assoc()['company_name'] : ""; // Hae yrityksen nimi, jos olemassa

$query->close();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/userpage.css">
    <script src="https://unpkg.com/htmx.org@1.8.4"></script>
    <script src="htmx.js" defer></script> 
</head>
    <header>
        <div class="companyName">
            <h1>Oman sivun hallinta</h1> 
        </div>
    </header>
    <div class="navigaatio">
        <a href="userpage.php">Oman sivun hallinta</a>
        <a href="edit_user.php">Muokkaa omia tietoja</a>
        <a href="edit_company.php">Muokkaa yrityksen tietoja</a>
        <!-- <a href="image_upload.php">Lataa logo</a> -->
        <a href="password_change.php">Vaihda salasana</a>

        <!-- 1.12. Näytetään admin -nappi vain, jos käyttäjän status on admin -->
        <?php if ($user_status === 'admin'): ?> 
            <a href="admin/admin_edit_user.php">
                Admin-sivut
            </a>
        <?php endif; ?>

    </div> <!--/navigaatio-->
    <div class="loginOut">
    <!-- Käytä suoraan href:ia ilman a-tagia -->
    <button onclick="window.location.href='log_out.php'">Kirjaudu ulos</button>
    </div>

    <div class="centerBase">
        <!-- Käyttäjän nimen ja yrityksen nimen näyttäminen -->
        <H1>Hei <span id="customerName" hx-get="get_user_info.php" hx-trigger="load" hx-swap="innerHTML"></span>,</H1>
        
        <!-- Tarkistetaan, onko yrityksen tietoja olemassa -->
        <?php if ($company_exists): ?>
            <!-- Näytetään tervehdysteksti yrityksen nimellä, jos yritys löytyy -->
            <p>tervetuloa muokkaamaan yrityksesi <?php echo htmlspecialchars($company_name); ?> verkkosivuja.</p>
            <a href="testi.php">
            <button>Muokkaa verkkosivuja</button></a>

            <!-- Lisätään painike josta pääsee näkemään omat yritys-sivut 14.11.-->
            <!-- $user_id määrittelee oikean kansion josta haetaan käyttäjän oma index.php 14.11. -->
            <!-- 18.11. Lisätty target="_blank"-->
            <a href="users/<?php echo $user_id; ?>/public_html/index.php" target="_blank">
            <button>Kotisivullesi</button></a>
        <?php else: ?>
            <!-- Näytetään vaihtoehtoinen teksti ja ohjataan luomaan yritys, jos yritystä ei vielä tiedoista löydy -->
            <p> Mikäli et ole vielä rekisteröinyt yritystä, pääset tekemään sen tästä.</p> 
            <a href="register_company.php">
                <button>Luo yritys</button>
            </a>
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