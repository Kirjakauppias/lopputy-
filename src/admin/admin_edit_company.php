<?php
session_start();
include_once "../database/db_enquiry.php";

$user_id = $_SESSION['user_id'] ?? null; // Varmista, että user_id on määritelty

if (!isset($user_id) || !is_numeric($user_id)) { // Tarkistetaan onko user_id tallennettu sessioon
    die("Käyttäjä ei ole kirjautunut sisään."); // Lopetetaan suoritus, jos käyttäjä ei ole kirjautunut
}

// 1.12. Tarkistetaan käyttäjän status
$user_status = getUserStatus($conn, $user_id);
if ($user_status === 'admin') {?>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Muokkaa Yrityksiä</title>
        <link rel="stylesheet" href="../styles/admin.css">
        <script src="https://unpkg.com/htmx.org@1.8.4"></script>
        <script src="htmx.js" defer></script> 
    </head>
    <body>
        
    </body>
    </html>
    
    <header>
        <h1>Admin - Yritysten hallinta</h1>
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
    <main>
        <h2>Yritystiedot</h2>
        <!-- Modaalinen muokkauslomake -->
         <div id="edit-modal" style="display: none;">
            <form
                hx-post="admin_update_company.php"
                hx-target="#edit-modal"
                hx-swap="innerHTML"
            >
                <h2>Muokkaa yritystä</h2>
                <input type="hidden" name="company_id" id="company_id" />
                <label for="company_name">Nimi:</label>
                <input type="text" name="company_name" id="company_name" required /><br />
                <label for="company_number">Yritysnumero:</label>
                <input type="text" name="company_number" id="company_number" /><br />
                <label for="address">Osoite:</label>
                <input type="text" name="address" id="address" /><br />
                <label for="zipcode">Postinumero:</label>
                <input type="text" name="zipcode" id="zipcode" /><br />
                <label for="postplace">Postitoimipaikka:</label>
                <input type="text" name="postplace" id="postplace" required /><br />
                <label for="email">Sähköposti:</label>
                <input type="email" name="email" id="email" /><br />
                <label for="phone_number">Puhelinnumero:</label>
                <input type="text" name="phone_number" id="phone_number" /><br />
                <label for="slogan">Slogan:</label>
                <input type="text" name="slogan" id="slogan" /><br />
                <button type="submit">Tallenna</button>
                <button type="button" onclick="closeModal()">Peruuta</button>
            </form>
         </div>
        <table>
            <thead>
                <tr>
                <th>ID</th>
                    <th>Nimi</th>
                    <th>Yritysnumero</th>
                    <th>Osoite</th>
                    <th>Postinumero</th>
                    <th>Postitoimipaikka</th>
                    <th>Sähköposti</th>
                    <th>Puhelinnumero</th>
                    <th>Slogan</th>
                    <th>Toiminnot</th>
                </tr>
            </thead>
            <tbody
                hx-get="admin_get_companies.php"
                hx-trigger="load"
                hx-target="this"
            >
                <!-- Täyttyy palvelimen palauttamalla sisällöllä -->
            </tbody>
        </table>
    </main>
     <script>
        // Modaalilomakkeen avaaminen
        function openModal(company_id, company_name, company_number, address, zipcode, postplace, email, phone_number, slogan) {
            document.getElementById("company_id").value = company_id;
            document.getElementById("company_name").value = company_name;
            document.getElementById("company_number").value = company_number;
            document.getElementById("address").value = address;
            document.getElementById("zipcode").value = zipcode;
            document.getElementById("postplace").value = postplace;
            document.getElementById("email").value = email;
            document.getElementById("phone_number").value = phone_number;
            document.getElementById("slogan").value = slogan;
            document.getElementById("edit-modal").style.display = "block";
        }
    
        // Modaalilomakkeen sulkeminen
        function closeModal() {
            document.getElementById("edit-modal").style.display = "none";
        }
     </script>
     </body>
     </html>    
<?php    
} else {
    die("Käyttäjällä ei ole admin -oikeuksia.");
}

?>
