<?php
    if (isset($_GET['user_id'])) {
        include_once "../database/db_connect.php";

        // 30.11. Tarkistetaan yhteys.
        if ($conn->connect_error) {
            die("Tietokantayhteys epäonnistui: " . $conn->connect_error);
        }

        $user_id = intval($_GET['user_id']);

        // Päivitetään deleted_at takaisin NULL:iksi
        $sql = "UPDATE user SET deleted_at = NULL WHERE user_id = $user_id";

        if ($conn->query($sql) === TRUE) {
            http_response_code(200); // Palautus onnistui
            echo "Käyttäjä palautettu onnistuneesti.";
        } else {
            http_response_code(500); // Virhe
            echo "Virhe käyttäjän palautuksessa: " . $conn->error;
        }
        $conn->close();
    } else {
        http_response_code(400);
        echo "Virheellinen pyyntö.";
    }
?>