<?php
session_start();
// TÄLLÄ SIVULLA KÄYTTÄJÄ VOI MUOKATA OMIA TIETOJAAN.

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

include_once "./database/db_connect.php";
include "funcs.php";

// Haetaan käyttäjän tiedot tietokannasta. Käytetään user_id:tä hakusanana
$sql = "SELECT firstname, lastname, email FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

// Sijoitetaan muuttujiin tietokannan tiedot tai null jos ei ole tietoja.
$firstname = $userData['firstname'] ?? '';
$lastname = $userData['lastname'] ?? '';
$email = $userData['email'] ?? '';

$stmt->close();
$conn->close();


//printSessionData();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/useredit.css">
    <script src="https://unpkg.com/htmx.org@1.8.4"></script>
    <script src="htmx.js" defer></script> 
</head>
<body>
    <header>
        <div class="companyName">
            <h1>Muokkaa omia tietoja</h1> 
        </div>
    </header>
    <div class="navigaatio">
        <a href="userpage.php">Oman sivun hallinta</a>
        <a href="edit_user.php">Muokkaa omia tietoja</a>
        <a href="edit_company.php">Muokkaa yrityksen tietoja</a>
        <a href="password_change.php">Vaihda salasana</a>
    </div> <!--/navigaatio-->
    <div class="loginOut"> <!-- uloskirjauspainike -->
        <a href="log_out.php">
        <button>Kirjaudu ulos</button>
        </a>
    </div>
    <div class="container"> 
        <h1>Muokkaa omia tietoja</h1>
        <hr></hr>
        <form 
          hx-post="edit_user_check.php" 
          hx-target="#result"
          hx-swap="outerHTML"
        >  
          <div class="row">
            <div class="col-25">              <!--Lisätään labeliin muuttujan arvo-->
              <label for="firstname">Etunimi: <?php echo htmlspecialchars($firstname); ?></label>
            </div>
            <div class="col-75">
              <input type="text" id="firstname" name="firstname" placeholder="Etunimi.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">              <!--Lisätään labeliin muuttujan arvo-->
              <label for="lastname">Sukunimi: <?php echo htmlspecialchars($lastname); ?></label>
            </div>
            <div class="col-75">
              <input type="text" id="lastname" name="lastname" placeholder="Sukunimi.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">             <!--Lisätään labeliin muuttujan arvo-->
              <label for="email">Sähköposti: <?php echo htmlspecialchars($email); ?></label>
            </div>
            <div class="col-75">
              <input type="email" id="email" name="email" placeholder="Sähköposti.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">             
              <label for="email">Salasana:</label>
            </div>
            <div class="col-75">
              <input type="password" id="password" name="password" placeholder="Kirjoita tähän nykyinen salasanasi..">
            </div>
          </div><!--/row-->
          <hr></hr>
          <div class="row">
            <input type="submit" value="Päivitä tietosi">
          </div>
          <div id="result">
            <!-- Tänne tulee rekisteröinti -ilmoitukset käytäjälle -->
          </div>
        </form>        
    </div><!--/container-->
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