

<!-- SIVU JOSSA KÄYTTÄJÄ VOI REKISTERÖITYÄ -->
<!-- Muokattu 23.10. 11:10 ML -->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER USER</title>
    <link rel="stylesheet" href="./styles/register.css">
    <script src="htmx.js" defer></script>
</head>
<body>
  <header> 
    <img src="Images/LeVaLogo1.png"></img>
    <h1>Helppo, nopea ja vaivaton tapa tehdä verkkosivut</h1> 
  </header>
    <div class="container"> <!-- Tämän sisällä lomake 22.10. ML -->
        <h1>Rekisteröidy käyttäjäksi</h1>
        <p>Oletko jo rekisteröitynyt? <a href="Index.php" alt="kirjautumis linkki">Kirjaudu sisään täältä</a></p>
        <hr></hr>
        <form 
          hx-post="register_check.php" 
          hx-target="#result"
          hx-swap="outerHTML"
        >  
          <div class="row">
            <div class="col-25">
              <label for="firstname">Etunimi</label>
            </div>
            <div class="col-75">
              <input type="text" id="firstname" name="firstname" placeholder="Etunimi.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="lastname">Sukunimi</label>
            </div>
            <div class="col-75">
              <input type="text" id="lastname" name="lastname" placeholder="Sukunimi.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="username">Käyttäjätunnus</label>
            </div>
            <div class="col-75">
              <input type="text" id="username" name="username" placeholder="Käyttäjätunnus.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="email">Sähköposti</label>
            </div>
            <div class="col-75">
              <input type="email" id="email" name="email" placeholder="Sähköposti.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="password">Salasana</label>
            </div>
            <div class="col-75">
              <input type="password" id="password" name="password" placeholder="Salasanan on oltava vähintään 8 merkkiä pitkä.." required>
            </div>
          </div><!--/row-->
          <div class="row">
            <div class="col-25">
              <label for="re_password">Salasana uudelleen</label>
            </div>
            <div class="col-75">
              <input type="password" id="re_password" name="re_password" placeholder="Salasana uudelleen.." required>
            </div>
          </div><!--/row-->
          <hr></hr>
          <div class="row">
            <input type="submit" value="Tallenna">
          </div>
          <div id="result">
            <!-- Tänne tulee rekisteröinti -ilmoitukset käytäjälle -->
            <!-- 24.10. ML -->
          </div>
        </form>        
    </div><!--/container-->
</body>
</html>