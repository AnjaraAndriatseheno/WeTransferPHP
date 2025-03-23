<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <link rel="stylesheet" href="style.css">
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
    <div class="form-container">
        <h1>INSCRIPTION</h1>
        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<p class='success-message'>Inscription réussie !</p>";
        }
        ?>
        <form action="contact.php" method="POST">
            <div class="input-group">
                <input type="text" id="firstname" name="firstname" placeholder="Prénom" required>
                <input type="text" id="name" name="name" placeholder="Nom" required>
            </div>

            <div class="input-group">
                <input type="email" id="email" name="email" placeholder="Email" required>
                <input type="text" id="phone" name="phone" placeholder="Téléphone" required>
            </div>

            <div class="input-group">
                <input type="text" id="pays" name="pays" placeholder="Pays" required>
                <input type="password" id="password" name="password" placeholder="Mot de passe" required>
            </div>

            <button type="submit" name="submit">S'inscrire</button>
        </form>
    </div>
</main>

</body>
</html>
