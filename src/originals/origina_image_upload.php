<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMAGE UPLOAD</title>
    <script src="htmx.js" defer></script>
</head>
<body>
    <h1>Lataa kuva palvelimelle</h1>
    <!-- Lomake kuvien latausta varten -->
    <form id="uploadFrom"
        hx-post="upload.php"
        hx-target="#uploadResult"
        hx-encoding="multipart/form-data">
        <input type="hidden" name="user_id" value="1"> <!-- Vaihdettava oikea user_id SAADAAN MYÖHEMMIN SESSIONIN KAUTTA -->
        <input type="hidden" name="company_id" value="1"> <!-- Vaihdettava oikea company_id -->
        <input type="file" name="userImage" accept="image/*" required>
        <button type="submit">Lataa</button>
    </form>

    <div id="uploadResult"></div>
</body>
</html>