<?php
// TÄÄLLÄ SUORITETAAN USER REGISTER -TARKASTUS
// Tarkistetaan, että pyyntö on lähetetty POST -metodilla
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Alustetaan muuttujat ja suodatetaan syöte
    // Tarkistetaan onko POSTissa avaimet, jos ei ole, käytetään tyhjää ''.
    // tämä estää virheet, jotka johtuvat olemattomien POST-arvojen käyttämisestä
    $password = $_POST['password'] ?? '';
    $repassword = $_POST['re_password'] ?? '';

    // Estetään XSS-hyökkäykset (htmlspecialchars).
    // Trim poistaa syötteen alusta ja lopusta ylimääräiset välilyönnit tai
    // muut ylimääräiset merkit.
    $firstname = htmlspecialchars(trim($_POST['firstname'] ?? ''));
    $lastname = htmlspecialchars(trim($_POST['lastname'] ?? ''));
    $username = htmlspecialchars(trim($_POST['username'] ?? ''));

    // filter_var: jos syöte ei ole kelvollinen sähköpostiosoite, palauttaa FALSE
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

    // Varmistetaan että salasana on oikein
    if ($password === $repassword) {
        // Vähintään 8 merkkiä salasanassa
        if (strlen($password) >= 8) {
            // Varmistetaan että sähköposti-osoite on kunnollinen
            if($email != FALSE) {
                // Hashataan salasana turvallisesti
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                // checkUsernameExists()
                include "./database/db_enquiry.php";
                
                // Annetaan muuttujalle TRUE/FALSE -arvo.
                // Funktio tarkistaa että onko username jo käytössä.
                $usernameCheck = checkUsernameExists($conn, $username);
                $userEmailCheck = checkUserEmailExists($conn, $email);

                // Jos käyttäjätunnus ei ole vielä olemassa.
                if ($usernameCheck == FALSE && $userEmailCheck == FALSE) {

                    // addUser()
                    include "./database/db_add_data.php";

                    // Lisätään uudelle käyttäjälle oletuksena customer -status
                    $status = "customer";
                    // Lisätään käyttäjä tietokantaan
                    addUser($conn, $firstname, $lastname, $username, $email, $hashedPassword, $status);

                    // Haetaan juuri lisätty käyttäjän id 12.11.
                    $query = "SELECT user_id FROM user WHERE username = ? AND email = ? LIMIT 1";
                    $stmt = $conn->prepare($query);
                                    
                    $stmt->bind_param("ss", $username, $email);
                    $stmt->execute();
                    $result = $stmt->get_result();
                                    
                    // Oletetaan, että kysely palauttaa tuloksen
                    $row = $result->fetch_assoc();
                    $user_id = $row['user_id'];

                    // Kansion luonti käyttäjälle 12.11.
                    // Lisätty is_numeric funktio varmistamaan että muuttuja on kokonaisluku 13.11.
                    if (is_numeric($user_id)) {
                        // Määritellään polku käyttäjän kansiolle
                        $userDir = __DIR__ . "/users/$user_id";
                        $publicHtmlDir = $userDir . "/public_html";
                        $imagesDir = $userDir . "/images";

                        // Luodaan pääkansio käyttäjälle, jos sitä ei ole
                        if(!is_dir($userDir)) {
                            mkdir($userDir, 0755, true);
                        }

                        // Luodaan alikansiot public_html ja images
                        if(!is_dir($publicHtmlDir)) {
                            mkdir($publicHtmlDir, 0755, true);
                        }
                        if(!is_dir($imagesDir)) {
                            mkdir($imagesDir, 0755, true);
                        }
                    } else {
                        echo "<div id='result'><p>Käyttäjän kansion luominen epäonnistui.</p></div>";
                        exit();
                    }

                    // Annetaan käyttäjälle tieto että rekisteröinti tietokantaan onnistui
                    echo "
                    <div id='result'>
                        <h3>Sinut on lisätty onnistuneesti!</h3>
                    </div>
                ";
                
                // Odotetaan lyhyesti ennen uudelleenohjausta, jos haluat näyttää onnistumisviestin
                echo "<script>
                    setTimeout(function() {
                        window.location.href = 'index.php'; // Uudelleenohjaus index.php:hen
                    }, 1000); // 1000 ms = 1 sekuntia
                </script>";
                exit();

                } else if ($usernameCheck == TRUE || $userEmailCheck == TRUE){
                    // Annetaan käyttäjälle virheilmoitus että käyttäjätunnus on jo olemassa.
                    echo "
                <div id='result'>
                    <p>Rekisteröinti epäonnistui. Yritä toista käyttäjätunnusta tai sähköpostia.</p>
                </div>
                ";
                exit();
                }
                
            } else {
                echo "
                <div id='result'>
                    <p>Sähköposti ei ole oikea.</p>
                </div>
                ";
                exit();
            }
        } else {
            echo "
                <div id='result'>
                    <p>Salasanan tulee olla vähintään 8 merkkiä pitkä.</p>
                </div>
            ";
            exit();
        }
    }
    else {
        echo "
            <div id='result'>
                <p>Salasana ei täsmää.</p>
            </div>
        ";
        exit();
    } 
} else {
    // Jos pyyntö ei ole POST, näytetään ilmoitus.
    echo "Ei ole POST";
}
?>