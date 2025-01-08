<?php
session_start();
// TÄLLÄ SIVULLA KÄYTTÄJÄ VOI MUOKATA OMIA TIETOJAAN.

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

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
            <h1>Vaihda salasana</h1> 
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
        <h1>Vaihda salasana</h1>
        <hr></hr>
        <form 
          hx-post="password_change_check.php" 
          hx-target="#result"
          hx-swap="outerHTML"
        >  
          <div class="row">
            <div class="col-25">              
              <label for="oldpassword">Nykyinen salasana: </label>
            </div>
            <div class="col-75">
              <input type="password" id="oldpassword" name="oldpassword" placeholder="Nykyinen salasana.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">              
              <label for="newpassword">Uusi salasana: </label>
            </div>
            <div class="col-75">
              <input type="password" id="newpassword" name="newpassword" placeholder="Uusi salasana.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">              
              <label for="repeatpassword">Toista uusi salasana: </label>
            </div>
            <div class="col-75">
              <input type="password" id="repeatpassword" name="repeatpassword" placeholder="Toista uusi salasana.." required>
            </div>
          </div><!--/row-->
          <hr></hr>
          <div class="row">
            <input type="submit" value="Uusi salasana">
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