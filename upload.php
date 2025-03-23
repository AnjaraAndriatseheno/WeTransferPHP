<?php
// Vérification si l'utilisateur a été redirigé après une inscription réussie
$successMessage = '';
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $successMessage = 'Inscription réussie ! Vous pouvez maintenant télécharger un fichier.';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Téléchargement</title>
    <link rel="stylesheet" href="upload.css">
</head>
<body>
    <header>
        <div class="logo">ICNA</div>
        <nav>
            <ul>
                <li><a href="#">Inscription</a></li>
                <li><a href="#">Télécharger</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Affichage du message de succès ici -->
        <?php
        // Afficher le message de succès si l'utilisateur a été redirigé
        if ($successMessage) {
            echo "<p class='success-message'>$successMessage</p>";
        }
        ?>

        <div class="upload-box">
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="file-upload" class="upload-label">
                    <span class="plus-icon">+</span> Ajoute un fichier
                </label>
                <input type="file" id="file-upload" name="file-upload" hidden>
                <button type="submit">Télécharger</button>
            </form>
        </div>
    </main>
</body>
</html>
