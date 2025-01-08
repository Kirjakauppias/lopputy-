<?php
    include_once "../database/db_connect.php";
    include_once "../companypage.php";
    
    // 18.11. Funktio jolla päivitetään users/$user_id/public_html/index.php ja companypage.css
    function updateAllCompanyIndexPages($conn) {
        $sql = "SELECT user_id FROM user";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user_id = $row['user_id'];
                // Määritellään kansioiden osoitteet
                $directoryPath = "../users/$user_id/public_html";
                $filePath = "$directoryPath/index.php";
                $cssPath = "$directoryPath/companypage.css";
                // Tarkistetaan, onko käyttäjällä kansio luotuna, jos ei ole, siirrytään seuraavaan id:hen.
                if (!is_dir($directoryPath)) {
                    echo "Ohitettiin käyttäjän $user_id päivitys, koska kansiorakennetta ei ole olemassa.<br>";
                    continue;
                }
                // Haetaan sisältö users/$user_id/public_html/index.php -tiedostoon
                // ja ylikirjoitetaan vanha tiedosto.
                $newContent = generatePageContent($conn, $user_id);
    
                if (file_put_contents($filePath, $newContent) !== false) {
                    echo "Päivitettiin käyttäjän $user_id index.php onnistuneesti.<br>";
                } else {
                    echo "Virhe päivittäessä käyttäjä $user_id index.php.<br>";
                }

                // Haetaan sisältö users/$user_id/public_html/companypage.css -tiedostoon
                // ja ylikirjoitetaan vanha tiedosto.
                $newCssContent = generateStyleContent();

                if (file_put_contents($cssPath, $newCssContent) !== false) {
                    echo "Päivitettiin käyttäjän $user_id companypage.css onnistuneesti.<br>";
                } else {
                    echo "Virhe päivittäessä käyttäjä $user_id companypage.css.<br>";
                }
            }
        } else {
            echo "Käyttäjiä ei löytynyt tietokannasta. <br>";
        }
    }
    
    // Tarkistetaan, onko lomake lähetetty ja kutsutaan funktiota updateAllCompanyIndexPages()
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_indexes'])) {
    
        // Tarkistetaan yhteyden onnistuminen
        if ($conn->connect_error) {
            die("Yhteyden muodostaminen epäonnistui: " . $conn->connect_error);
        }
    
        // Kutsutaan funktiota
        updateAllCompanyIndexPages($conn);
    
        // Suljetaan yhteys
        $conn->close();
    }

?>

