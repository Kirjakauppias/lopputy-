<?php
session_start();
include_once "../database/db_enquiry.php";

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

// 1.12. Tarkistetaan käyttäjän status
$user_status = getUserStatus($conn, $user_id);
if ($user_status === 'admin') {
    ?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="../styles/admin.css">
        <script src="https://unpkg.com/htmx.org@1.8.4"></script>
        <script src="htmx.js" defer></script> 
    </head>
    <body>
        
    <header>
        <h1>Admin - Käyttäjätietojen muokkaus</h1>
        <!-- Käytä suoraan href:ia ilman a-tagia -->
        <button id="logout" onclick="window.location.href='../../log_out.php'">Kirjaudu ulos</button>
        <!-- 18.11. Nappi jota painamalla voi päivittää käyttäjien index.php ja companypage.css -->
        <form method="post" action="updateContent.php">
            <input type="submit" name="update_indexes" value="Päivitä käyttäjien index.php:t ja css:t">
        </form> 
    </header>
    <nav>    
        <a href="admin_edit_user.php">Muokkaa käyttäjän tietoja</a>
        <a href="admin_edit_company.php">Muokkaa yritystietoja</a>
    </nav>    
    <!-- 26.11. Modaalinen muokkauslomake -->
    <div id="edit-modal">
        <form 
            hx-post="admin_update_user.php" 
            hx-target="#edit-modal" 
            hx-swap="innerHTML"
        >
            <!-- 28.11. Lisätty status-->
            <h2>Muokkaa käyttäjää</h2>
            <!-- Piilotettu kenttä käyttäjän ID:tä varten -->
            <input type="hidden" name="user_id" id="user_id" />
            <label for="firstname">Etunimi:</label>
            <input type="text" name="firstname" id="firstname" required /><br />
            <label for="lastname">Sukunimi:</label>
            <input type="text" name="lastname" id="lastname" required /><br />
            <label for="email">Sähköposti:</label>
            <input type="email" name="email" id="email" required /><br />
            <label for="status">Tila:</label>
            <!-- 29.11. Lisätty dropdown -valikko -->
            <select id="status" name="status">
                <option value="customer">customer</option>
                <option value="admin">admin</option>
            </select>
            <br>
            <button type="submit">Tallenna</button>
            <button type="button" onclick="closeModal()">Peruuta</button>
        </form>
    </div>
    <main>    
        <h2>Käyttäjätiedot</h2>
        <!-- 26.11. Taulukko johon tulostetaan käyttäjätiedot -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Etunimi</th>
                    <th>Sukunimi</th>
                    <th>Käyttäjänimi</th>
                    <th>Sähköposti</th>
                    <th>Tila</th>
                    <th>Toiminnot</th>
                </tr>
            </thead>
            <tbody 
                hx-get="admin_get_users.php" 
                hx-trigger="load" 
                hx-target="this"
            >
            <!-- 26.11. Tämä tila täyttyy palvelimen palauttamalla sisällöllä -->
            </tbody>
        </table>
    </main>
        <script>
            // 26.11. Funktio modaalisen muokkauslomakkeen avaamiseksi
            // Täyttää lomakkeen tiedot ja näyttää modalin
            // 28.11. Lisätty status
            function openModal(user_id, firstname, lastname, email, status) {
                document.getElementById("user_id").value = user_id;
                document.getElementById("firstname").value = firstname;
                document.getElementById("lastname").value = lastname;
                document.getElementById("email").value = email;
                document.getElementById("status").value = status;
                document.getElementById("edit-modal").style.display = "block";
            }
    
            // 26.11. Funktio modaalisen muokkauslomakkeen sulkemiseksi
            function closeModal() {
                document.getElementById("edit-modal").style.display = "none";
            }
        </script>
    </body>
    </html>
<?php } else {
    die("Käyttäjällä ei ole admin -oikeuksia.");
}

?>

