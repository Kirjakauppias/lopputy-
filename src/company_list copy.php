<?php
include_once "./database/db_connect.php";
// Alustetaan taulukko, joka sisältää kaikki yritykset ja niiden tiedot
$companies = [];
// Suoritetaan SQL-kysely yrityksen tietojen hakemiseksi
$sql = "SELECT c.company_name, u.user_id FROM company c JOIN user u ON c.user_id = u.user_id";
$result = $conn->query($sql);
// Tarkistetaan, onnistuiko kysely
if($result && $result->num_rows > 0) {
    // Tallennetaan tulokset taulukkoon
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row;
    }
} else {
    echo "Virhe kyselyssä tai ei tuloksia.";
}

// Suljetaan kyselyn tulokset
$result->free();

// Kansiorakenne, jossa index.php-tiedostot sijaitsevat
$baseDir = __DIR__ . '/users';

function findIndexFiles($baseDir) {
    $indexFiles = [];
    // Hakee kaikki käyttäjäkansiot (esim. users/1, users/2 jne.)
    $directories = glob($baseDir . '/*', GLOB_ONLYDIR);

    foreach ($directories as $dir) {
        $filePath = $dir . '/public_html/index.php';
        if (file_exists($filePath)) {
            // Haetaan käyttäjän ID kansio nimestä, esim users/123 -> 123
            $userId = basename($dir);
            $indexFiles[$userId] = $filePath;
        }
    }
    return $indexFiles;
}

// Etsitään kaikki index.php-tiedostot käyttäjien kansioista
$indexFiles = findIndexFiles($baseDir);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yritysten lista</title>
</head>
<body>
    <h1>Yritysten lista</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Yrityksen nimi</th>
                <th>Linkki</th>
            </tr>
            <tbody>
                <?php 
                    if (!empty($companies)) {
                        foreach ($companies as $company) {
                            $userId = $company['user_id'];
                            $companyName = htmlspecialchars($company['company_name']);
                            if (isset($indexFiles[$userId])) {
                                $linkPath = 'users/' . $userId . '/public_html/index.php';
                                echo "
                                    <tr>
                                        <td>{$companyName}</td>
                                        <td><a href='{$linkPath}' target='_blank'>{$companyName}</a></td>
                                    </tr>
                                ";
                            } else {
                                echo "
                                    <tr>
                                        <td>{$companyName}</td>
                                        <td>Ei löydy</td>
                                    </tr>
                                ";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='2'>Ei yrityksiä tietokannassa.</td></tr>";
                    }
                ?>
            </tbody>
        </thead>
    </table>
</body>
</html>