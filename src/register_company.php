<?php 
session_start(); // Aloitetaan sessio
//SESSION[user_id]
//checkCompanyByUser()
include "database/db_enquiry.php";
//include "funcs.php";
//printSessionData();
// SIVU JOSSA KÄYTTÄJÄ VOI TÄYTTÄÄ YRITYKSEN TIEDOT.

if (!isset($_SESSION['user_id'])) {
  die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut sivulle.
}                                             // Tarkistetaan onko user_id tallennettu sessioon, jos ei ole estetään pääsy sivulle.
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER COMPANY</title>
    <link rel="stylesheet" href="./styles/register.css">
    <script src="htmx.js" defer></script>
</head>
<body>
  <header>
    <h1>Luo yritystiedot</h1>
  </header>
  <div class="container"> <!-- Tämän sisällä lomake 22.10. ML -->
<?php
$user_id = $_SESSION['user_id'];  // Määritellään user_id
// Tarkistetaan, läytyykö session id:llä jo company_id.
if (checkCompanyByUser($conn, $user_id)) {
  echo "Sinulla on jo rekisteröity yritys. <a href='userpage.php'><button>Takaisin</button></a>";
} else {
  ?>
  <h1>Lisää yritys</h1>
  <hr></hr>
  <form
    hx-post="register_company_check.php" 
    hx-target="#result"
    hx-swap="outerHTML"
  > 
    <div class="row">
      <div class="col-25">
        <label for="company_name">Yrityksen nimi</label>
      </div>
      <div class="col-75">
        <input type="text" id="company_name" name="company_name" placeholder="Yrityksen nimi.." required>
      </div>
    </div><!--/row--> <!-- lisätty 17.11 -->
    <div class="row">
      <div class="col-25">
        <label for="slogan">Yrityksen slogan</label>
      </div>
      <div class="col-75">
        <input type="text" id="slogan" name="slogan" placeholder="Yrityksen slogan.." required>
      </div>
    </div><!--/row-->
    <div class="row">
      <div class="col-25">
        <label for="company_number">Y-tunnus</label>
      </div>
      <div class="col-75">
        <input type="text" id="company_number" name="company_number" placeholder="Y-tunnus.." required>
      </div>
    </div><!--/row-->
    <div class="row">
      <div class="col-25">
        <label for="company_email">Yrityksen sähköposti</label>
      </div>
      <div class="col-75">
        <input type="email" id="company_email" name="company_email" placeholder="Yrityksen sähköposti.." required>
      </div>
    </div><!--/row-->
    <div class="row">
      <div class="col-25">
        <label for="company_phone">Yrityksen puhelinnumero</label>
      </div>
      <div class="col-75">
        <input type="text" id="company_phone" name="company_phone" placeholder="Yrityksen puhelinnumero.." required>
      </div>
    </div><!--/row-->
    <div class="row">
      <div class="col-25">
        <label for="company_address">Yrityksen katuosoite</label>
      </div>
      <div class="col-75">
        <input type="text" id="company_address" name="company_address" placeholder="Yrityksen katuosoite.." required>
      </div>
    </div><!--/row-->
    <div class="row">
      <div class="col-25">
        <label for="company_zipcode">Postinumero</label>
      </div>
      <div class="col-75">
        <input type="text" id="company_zipcode" name="company_zipcode" placeholder="Postinumero.." required>
      </div>
    </div><!--/row-->
    <div class="row">
      <div class="col-25">
        <label for="company_postplace">Postitoimipaikka</label>
      </div>
      <div class="col-75">
        <input type="text" id="company_postplace" name="company_postplace" placeholder="Postitoimipaikka.." required>
      </div>
    </div><!--/row-->
    <div class="row">
      <div class="col-25">
        <label for="company_info">Tietoa yrityksestä</label>
      </div>
      <div class="col-75">
        <textarea id="company_info" name="company_info" placeholder="Tietoa yrityksestä.." style="height:200px"></textarea>
      </div>
    </div><!--/row-->
    <hr></hr>
    <div class="row">
      <input type="submit" value="Tallenna">
    </div>
    <div id="result">
      <!-- Tänne tulee rekisteröinti -ilmoitukset käytäjälle -->
      <!-- 28.10. ML -->
    </div>
  </form>
  <?php
  }
  ?>
  </div><!--/container-->
</body>
</html>




