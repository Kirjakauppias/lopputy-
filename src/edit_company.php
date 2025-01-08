<?php
session_start();
// TÄLLÄ SIVULLA KÄYTTÄJÄ VOI MUOKATA OMIA YRITYKSEN TIETOJAAN.

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

include_once "./database/db_connect.php";

// Haetaan yrityksen tiedot tietokannasta, käytetään user_id -avainta.
// 18.11. Lisätty slogan ja $cSlogan
// 25.11. Lisätty description ja $cDescription
$sql = "SELECT address, zipcode, postplace, email, phone_number, description, slogan FROM company WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$companyData = $result->fetch_assoc();

// Sijoitetaan muuttujiin tietokannan tiedot tai null jos ei ole tietoja.
$cAddress = $companyData['address'] ?? '';
$cZipcode = $companyData['zipcode'] ?? '';
$cPostplace = $companyData['postplace'] ?? '';
$cEmail = $companyData['email'] ?? '';
$cPhone = $companyData['phone_number'] ?? '';
$cSlogan = $companyData['slogan'] ?? '';
$cDescription = $companyData['description'] ?? '';


$stmt->close();
$conn->close();
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
            <h1>Muokkaa yrityksen tietoja</h1> 
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
    <div class="container"> <!-- Tämän sisällä lomake 22.10. ML -->
        <h1>Muokkaa yrityksen tietoja</h1>
        <p>Yrityksen nimen tai y-tunnuksen voi vaihtaa vain ylläpitäjä.</p>
        <hr></hr>
        <form
          hx-post="edit_company_check.php" 
          hx-target="#result"
          hx-swap="outerHTML"
        > 
          <div class="row">
            <div class="col-25">
              <label for="slogan">Slogan:<br> <?php echo htmlspecialchars($cSlogan); ?></label>
            </div>
            <div class="col-75">
              <input type="text" id="slogan" name="slogan" placeholder="Yrityksen slogan.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="company_email">Yrityksen sähköposti:<br> <?php echo htmlspecialchars($cEmail); ?></label>
            </div>
            <div class="col-75">
              <input type="email" id="company_email" name="company_email" placeholder="Yrityksen sähköposti.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="company_phone">Yrityksen puhelinnumero:<br> <?php echo htmlspecialchars($cPhone); ?></label>
            </div>
            <div class="col-75">
              <input type="text" id="company_phone" name="company_phone" placeholder="Yrityksen puhelinnumero.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="company_address">Yrityksen katuosoite: <br><?php echo htmlspecialchars($cAddress); ?></label>
            </div>
            <div class="col-75">
              <input type="text" id="company_address" name="company_address" placeholder="Yrityksen katuosoite.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="company_zipcode">Postinumero:<br> <?php echo htmlspecialchars($cZipcode); ?></label>
            </div>
            <div class="col-75">
              <input type="text" id="company_zipcode" name="company_zipcode" placeholder="Postinumero.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="company_postplace">Postitoimipaikka:<br><?php echo htmlspecialchars($cPostplace); ?></label>
            </div>
            <div class="col-75">
              <input type="text" id="company_postplace" name="company_postplace" placeholder="Postitoimipaikka.." required>
            </div>
          </div><!--/row-->
          <!--25.11. Lisätty description-->
          <div class="row">
            <div class="col-25">             
              <label for="Yrityksen kuvaus">Yrityksen kuvaus:</label>
            </div>
            <div class="col-75">
              <textarea id="company_info" name="company_info" placeholder="<?php echo htmlspecialchars($cDescription); ?>" style="height:200px"><?php echo htmlspecialchars($cDescription); ?></textarea>
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
            <input type="submit" value="Päivitä tiedot">
          </div>
          <div id="result">
            <!-- Tänne tulee rekisteröinti -ilmoitukset käytäjälle -->
            <!-- 28.10. ML -->
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