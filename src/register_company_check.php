<?php
session_start();
// SESSION[user_id]
include_once "./database/db_enquiry.php";
include_once "./database/db_add_data.php";

// TÄÄLLÄ SUORITETAAN COMPANY REGISTER -TARKASTUS
// Tarkistetaan, että pyyntö on lähetetty POST -metodilla
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Haetaan user_id session tiedoista
    $user_id = $_SESSION['user_id'];
    // Tarkistetaan, onko käyttäjällä jo rekisteröity yritys
    if (checkCompanyByUser($conn, $user_id)) {
        echo "
        <div id='result'>
            <p>Sinulla on jo rekisteröity yritys. Et voi lisätä toista yritystä.</p>
            <a href='userpage.php'><button type='button'>Takaisin</button></a>
        </div>
        ";
    exit();
    }

    // Estetään XSS-hyökkäykset (htmlspecialchars).
    // Trim poistaa syötteen alusta ja lopusta ylimääräiset välilyönnit tai
    // muut ylimääräiset merkit.
    $company_name = htmlspecialchars(trim($_POST['company_name'] ?? ''));
    $slogan = htmlspecialchars(trim($_POST['slogan'] ?? ''));
    $company_number = htmlspecialchars(trim($_POST['company_number'] ?? ''));
    $company_phone = htmlspecialchars(trim($_POST['company_phone'] ?? ''));
    $company_address = htmlspecialchars(trim($_POST['company_address'] ?? ''));
    $company_zipcode = htmlspecialchars(trim($_POST['company_zipcode'] ?? ''));
    $company_postplace = htmlspecialchars(trim($_POST['company_postplace'] ?? ''));
    $company_info = htmlspecialchars(trim($_POST['company_info'] ?? ''));



    // filter_var: jos syöte ei ole kelvollinen sähköpostiosoite, palauttaa FALSE
    $company_email = filter_var(trim($_POST['company_email'] ?? ''), FILTER_VALIDATE_EMAIL);

    // Tarkistetaan y-tunnuksen oikeellisuus (muoto 1234567-8).
    // ^ = aletaan etsiä merkkejä heti alusta, varmistetaan ettei ole
    //      ylimääräisiä merkkejä ennen y-tunnusta.
    // \d = mitä tahansa numeroa väliltä 0-9.
    // {7} = täsmälleen 7 numeroa peräkkäin.
    // - = 7 ensimmäistä ja viimeinen numero erotetaan väliviivalla.
    // \d = varmistetaan että viimeisenä on yksi numero 0-9.
    // $ = lausekkeen tulee päättyä tähän kohtaan merkkijonossa, varmistetaan ettei ole
    //      ylimääräisiä merkkejä y-tunnuksen lopussa.
    if (preg_match('/^\d{7}-\d$/', $company_number)) {
        // Tarkistetaan puhelinnumeron oikeellisuus (kotimainen tai kansainvälinen muoto).
        // ^ = aloitusmerkki.
        // 0 = numero alkaa nollalla.
        // \d{5,9} = seuraavat 5-9 numeroa.
        // (?:\+358) = numero alkaa +358.
        // \d{7,9} = voi olla 7-9 numeroa.
        // $ = päätösmerkki.
        if (preg_match('/^(?:0\d{5,9}|(?:\+358)\d{7,9})$/', $company_phone)) {
            // Tarkistetaan postinumeron oikeellisuus (muoto 12345)
            if(preg_match('/^\d{5}$/', $company_zipcode)) {
                if($company_email != FALSE) {
                    // checkCompanyName()
                    // checkCompanyNumber()
                    // checkCompanyEmail()
                    // include "./database/db_enquiry.php";

                    // Varmistetaan että annettuja tietoja ei ole jo tietokannassa.
                    $companyNameCheck = checkCompanyName($conn, $company_name);
                    $companyNumberCheck = checkCompanyNumber($conn, $company_number);
                    $companyEmailCheck = checkCompanyEmail($conn, $company_email);

                    // Jos annetut tiedot eivät löydy tietokannasta.
                    if($companyNameCheck == FALSE && $companyNumberCheck == FALSE && $companyEmailCheck == FALSE) {
                        // addCompany()
                        include_once "./database/db_add_data.php";

                        // Muotoillaan URL-osoite yrityksen nimen perusteella 9.11.
                        $company_url = strtolower(trim(preg_replace('/[^A-Za-z0-0]+/', '-', $company_name), '-'));
                        $company_url = $company_url . ".php";

                        // Tarkistetaan ettei samanlaista URL -osoitetta ole jo olemassa 9.11.
                        if (checkCompanyUrl($conn, $company_url)) {
                            echo "
                            <div id='result'>
                                <p>Yritykselle muodostettu URL-osoite on jo käytössä. Kokeile toista yrityksen nimeä.</p>
                            </div>
                            ";
                            exit();
                        }

                        // Lisätään uusi yritys tietokantaan
                        // Lisätty $company_url 9.11.
                        addCompany($conn, $company_name, $company_number, $company_address, $company_zipcode, $company_postplace, $company_email, $company_phone, $company_info, $user_id, $company_url, $slogan);
                        
                        // Lisätään oletustyyli yritykselle company_style-tauluun 15.11.
                        $company_id = $conn->insert_id;  // Hakee juuri lisätyn yrityksen ID:n 15.11.
                        addCompanyStyle($conn, $company_id);

                        // generatePageContent() 13.11.
                        include_once "companypage.php";

                        // Lisätään users/$user_id/public_html/ -kansioon index.php -tiedosto. 13.11.
                        // Lisätään users/$user_id/public_html/ -kansioon companypage.css -tiedosto. 16.11.
                        $companyDir = __DIR__ . "/users/$user_id/public_html";
                        $indexFile = $companyDir . "/index.php";
                        $cssFile = $companyDir . "/companypage.css";

                        // Tarkistetaan että $companyDir kansio on olemassa 13.11.
                        if (is_dir($companyDir)) {

                            // Luodaan index.php-tiedosto yrityksen tietojen näyttämistä varten 13.11.
                            // Haetaan funktiosta generatePageContent() sisältö index.php -sivulle 13.11.
                            // Haetaan funktiosta generateStyleContent() sisältö companypage.css -sivulle 16.11.
                            $indexContent = generatePageContent($conn, $user_id);
                            $cssContent = generateStyleContent($conn, $company_id);

                            // Luodaan index.php tiedosto ja kirjoitetaan siihen sisältö 13.11.
                            if (file_put_contents($indexFile, $indexContent) === false) {
                                echo "
                                    <div id='result'>
                                        <p>Index.php -tiedoston luominen epäonnistui</p>
                                    </div>
                                ";
                            }
                            
                            // Luodaan companypage.css -tiedosto ja kirjoitetaan siihen sisältö 16.11.
                            if( $cssContent !== null) 
                            {
                                if (file_put_contents($cssFile, $cssContent) === false) {
                                    echo "
                                        <div id='result'>
                                            <p>Companypage.css -tiedoston luominen epäonnistui</p>
                                        </div>
                                    ";
                                } 
                            } 
                        }
                        
                        // Annetaan käyttäjälle tieto että rekisteröinti tietokantaan onnistui
                        echo "
                        <div id='result'>
                            <h3>Yrityksesi on lisätty onnistuneesti!</h3>
                            <p>Yrityksen tiedot näkyvät osoitteessa <a href='/users/$user_id/public_html/index.php'>Yrityksesi sivu</a></p>
                            <a href='userpage.php'>Takaisin</a>
                        </div>
                        ";
                        
                    } else if ($companyNameCheck == TRUE || $companyNumberCheck == TRUE || $companyEmailCheck == TRUE){
                        // Annetaan käyttäjälle virheilmoitus että joko yrityksen nimi tai email tai y-tunnus on jo olemassa.
                        echo "
                    <div id='result'>
                        <p>Rekisteröinti epäonnistui. Yritä toista yrityksen nimeä, sähköpostia tai y-tunnusta.</p>
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
                    <p>Virheellinen postinumero. Sen tulee olla muodossa 12345.</p>
                </div>
                ";
                exit();
            }
        } else {
            // Näytetään virheilmoitus, jos puhelinnumero ei ole kelvollinen
            echo "
            <div id='result'>
                <p>Virheellinen puhelinnumero. Anna numero muodossa 0401234567 tai +358401234567.</p>
            </div>
            ";
            exit();
        }
    } else {
        echo "
        <div id='result'>
            <p>Virheellinen Y-tunnus. Sen tulee olla muodossa 1234567-8.</p>
        </div>
        ";
        exit();
    }
} else {
    // Jos pyyntö ei ole POST, näytetään ilmoitus.
    echo "Ei ole POST";
    exit();
}
