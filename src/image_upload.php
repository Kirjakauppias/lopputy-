<form id="uploadForm" 
      hx-post="upload.php" 
      hx-target="#uploadResult" 
      hx-encoding="multipart/form-data" 
      style="padding: 10px; border: 1px solid #ccc; border-radius: 5px; max-width: 400px; background-color: #f9f9f9;">

    <!-- Piilotettu kenttä user_id:lle -->
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

    <!-- Piilotettu kenttä kuvatyyppiä varten -->
    <input type="hidden" name="image_type" id="imageTypeInput" value="">

    <label for="imageType" style="font-size: 14px; font-weight: bold;">Valitse kuvatyyppi:</label> <!-- alasvetovalikko eri kuvien tallentamiseksi -->
    <select name="image_type" id="imageType" style="width: 100%; padding: 5px; margin: 5px 0;" required onchange="updateImageType()">
        <option value="logo">Logo</option>
        <option value="kuva1">Kuva 1</option>
        <option value="kuva2">Kuva 2</option>
        <option value="kuva3">Kuva 3</option>
    </select>

    <label for="userImage" style="font-size: 14px; font-weight: bold;">Valitse kuva:</label>
    <input type="file" name="userImage" id="userImage" style="width: 100%; padding: 5px; margin: 5px 0;" required>

    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Lataa kuva</button>
</form>

<!-- Täällä näkyy ladattu kuva -->
<div id="uploadResult"></div>

<script>
    // Funktio kuvatyypin päivitykseen
    function updateImageType() 
    {
        var imageType = document.getElementById('imageType').value;
        document.getElementById('imageTypeInput').value = imageType;
    }
</script>