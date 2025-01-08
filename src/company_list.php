<?php
include_once "./database/db_connect.php";

// Kansiorakenne, jossa index.php-tiedostot sijaitsevat
$baseDir = __DIR__ . '/users';

// Funktio etsii kaikki public_html/index.php -tiedostot käyttäjien kansioista
function findIndexFiles($baseDir) {
    $indexFiles = [];
    $directories = glob($baseDir . '/*', GLOB_ONLYDIR);
    foreach ($directories as $dir) {
        $filePath = $dir . '/public_html/index.php';
        if (file_exists($filePath)) {
            $userId = basename($dir);
            $indexFiles[$userId] = $filePath;
        }
    }
    return $indexFiles;
}

// Etsitään kaikki index.php-tiedostot käyttäjien kansioista
$indexFiles = findIndexFiles($baseDir);

if (!empty($indexFiles)) {
    $userIds = implode(',', array_map('intval', array_keys($indexFiles)));

    $sql = "SELECT c.company_name, u.user_id 
            FROM company c 
            JOIN user u ON c.user_id = u.user_id 
            WHERE u.user_id IN ($userIds)";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $companies[] = $row;
        }
    }

    $result->free();
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yritysten lista</title>
    <link rel="stylesheet" href="./styles/companylist.css">
</head>
<body>

<h1>Yritysten lista</h1>
<main>
<div class="company-container">
    <?php 
    if (!empty($companies)) {
        foreach ($companies as $company) {
            $userId = $company['user_id'];
            $companyName = htmlspecialchars($company['company_name']);
            $linkPath = "users/{$userId}/public_html/index.php";

            if (isset($indexFiles[$userId])) {
                echo "
                    <div class='company-card'>
                        <div class='company-name'>{$companyName}</div>
                        <a class='fullscreen-link' href='{$linkPath}' target='_blank'>
                            <div class='iframe-container'>
                                <iframe src='{$linkPath}' sandbox='allow-same-origin allow-scripts'></iframe>
                            </div>
                        </a>
                    </div>
                ";
            } else {
                echo "
                    <div class='company-card'>
                        <div class='company-name'>{$companyName}</div>
                        <div>Ei näkymää</div>
                    </div>
                ";
            }
        }
    } else {
        echo "<p>Ei yrityksiä, joilla olisi kansio users/</p>";
    }
    ?>
</div>
</main>
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


