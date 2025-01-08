<?php
session_start(); // Käynnistää session

// Tarkistetaan, onko käyttäjä kirjautunut sisään
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) 
{
    die("Käyttäjä ei ole kirjautunut sisään.");
}

// Yhteyden luominen tietokantaan
include_once "./database/db_connect.php";

// Funktio, jolla tarkistetaan vanha salasana
function verifyOldPassword($conn, $user_id, $oldPassword) 
{
    $sql = "SELECT password FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) 
    {
        $user = $result->fetch_assoc();
        if (password_verify($oldPassword, $user['password'])) 
        {
            return true;
        }
    }
    return false;
}

// Funktio, jolla päivitetään salasana
function updatePassword($conn, $user_id, $newPassword) 
{
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE user SET password = ? WHERE user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $hashedPassword, $user_id);
    
    if ($stmt->execute()) 
    {
        return "Salasana on päivitetty onnistuneesti!";
    } else {
        // Jos päivityksessä on virhe, tulostetaan virheviesti
        return "Virhe salasanan päivittämisessä: " . $stmt->error;
    }
}

// Tarkistetaan, onko lomake lähetetty
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $oldPassword = trim($_POST['oldpassword'] ?? '');
    $newPassword = trim($_POST['newpassword'] ?? '');
    $confirmPassword = trim($_POST['repeatpassword'] ?? ''); 

    // Tarkistetaan, että kaikki kentät on täytetty
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) 
    {
        echo "Kaikki kentät täytyy täyttää.";
        exit();
    }

    // Tarkistetaan, että uusi salasana ja varmistus salasana täsmäävät
    if ($newPassword !== $confirmPassword) 
    {
        echo "Uusi salasana ja sen vahvistus eivät täsmää.";
        exit();
    }
    
    // Varmistetaan, että vanha salasana on oikein
    if (!verifyOldPassword($conn, $user_id, $oldPassword)) 
    {
        echo "Vanha salasana on väärin.";
        exit();
    }
    
    // Tarkistetaan että uusi salasana on vähintään 8 merkkiä pitkä.
    if (strlen($newPassword) < 8) 
    {
        echo "Salasanan täytyy olla ainakin 8 merkkiä pitkä.";
        exit();
    } 

    // Päivitetään salasana tietokannassa
    $resultMessage = updatePassword($conn, $user_id, $newPassword);
    echo $resultMessage; // Tulostetaan virhe tai onnistumisviesti
}
?>