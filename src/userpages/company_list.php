<?php
// TÄÄLLÄ LISTATAAN KAIKKI YRITYKSET URL -OSOITTEINEEN
include_once "../database/db_connect.php";

// Haetaan kaikki yritykset tietokannasta
$sql = "SELECT company_id, company_name FROM company";
$result = $conn->query($sql);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yritysten Lista</title>
</head>
<body>
    <h1>Kaikki yritykset</h1>
    <ul>
        <?php
            // Tarkistetaan, löytyykö yrityksiä
            if($result->num_rows > 0) {
                // Listataan jokainen yritys linkkinä
                while ($row = $result->fetch_assoc()) {
                    $company_id = $row['company_id'];
                    $company_name = htmlspecialchars($row['company_name']);
                    echo "<li><a href='companyPage.php?id=$company_id'>$company_name</a></li>";
                }
            } else {
                echo "<li>Ei yrityksiä löytynyt.</li>";
            }
            ?>
    </ul>
</body>
</html>