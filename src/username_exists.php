<?php
session_start(); // Aloitetaan sessio
require "database/db_connect.php"; // tietokantayhteyden yhdistäminen

if ($_SERVER['REQUEST_METHOD'] === 'POST') // Tarkistetaan onko lomake lähetetty POST-metodilla
{
    $username = $_POST['username'] ?? null; // haetaan käyttäjätunnus lomakkeelta
    $password = $_POST['password'] ?? null; // haetaan salasana lomakkeelta
    $errors = []; // luodaan taulukko virheviesteille

    if (!$username || !$password) // tarkistetaan onko käyttäjätunnus ja salasana syötetty
    {
        $errors[] = "Täytä kaikki kentät."; // Jos kentät ovat tyhjiä, näytetään virheviesti
    } 
    else 
    {
        // Haetaan käyttäjä tietokannasta ilman kirjainkoon tarkistamista
        $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
        $stmt->bind_param("s", $username); // sidotaan käyttäjätunnus kyselyyn
        $stmt->execute(); // suoritetaan kysely
        $result = $stmt->get_result();
        $user = $result->fetch_assoc(); // haetaan käyttäjän tiedot taulukkoon
        $stmt->close();

        if ($user) 
        {
            // Tarkistetaan onko salasana oikea
            if (password_verify($password, $user["password"])) 
            {
                // Vertaillaan käyttäjätunnusta tarkasti, jotta kirjainkoko huomioidaan
                // 30.11. Lisätty tarkastus että käyttäjää ei ole poistettu
                if ($user['username'] === $username && $user['deleted_at'] === NULL) 
                {
                    $_SESSION['user_id'] = $user['user_id']; // tallennetaan käyttäjän ID sessioon
                    echo "<script>window.location.href = 'userpage.php';</script>"; // ohjataan käyttäjä userpage.php-sivulle
                    exit;
                } 
                else 
                {
                    $errors[] = "Virheellinen käyttäjätunnus"; // Jos kirjainkoko ei täsmää
                }
            } 
            else 
            {
                $errors[] = "Virheellinen salasana."; // Jos salasana on väärä, lisätään virheviesti
            }
        } 
        else 
        {
            $errors[] = "Käyttäjätunnusta ei löydy."; // Jos käyttäjätunnusta ei löydy, lisätään virheviesti
        }
    }

    // Näytetään virheviestit
    if (!empty($errors)) 
    {
       echo "<div class='error-messages'>"; // Luodaan div virheviesteille
       foreach ($errors as $error) 
       {
           echo "<p class='error'>{$error}</p>"; // Tulostetaan jokainen virheviesti
       }
       echo "</div>"; 
   }
}
?>