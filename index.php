<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger un fichier</title>
</head>
<body>
    <h2>TELECHARGEMENT</h2>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required><br>
        <input type="email" name="user_email" placeholder="Email autorisé" required><br>
        <button type="submit">Télécharger</button>
    </form>
</body>
</html>
