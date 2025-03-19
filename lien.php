<?php
// Connexion à la base de données
$conn = new PDO("", "root", "");

$download_link = "http://localhost/telechargement.php?cle=" . $key;
        echo "Fichier uploadé avec succès !";
        echo "Lien de téléchargement : <a href='$download_link'>$download_link</a>";
    else {
        echo "Erreur lors de l'upload.";
    }
?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <input type="file" name="file" require>
        <button type="submit" class="button">Uploader</button>
    </body>
    </html>