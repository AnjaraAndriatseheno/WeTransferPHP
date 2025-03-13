<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'Inscription</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Formulaire d'inscription</h2>
    <?php
    // Afficher le message de succès
    if (isset($_GET['success']) && $_GET['success'] == 1) {
        echo "<p class='success-message'>Inscription réussie !</p>";
    }
    ?>
    <form action="contact.php" method="POST">
    <!--First name-->
        <div>
            <label for="firstname">Prénom <span class="required">*</span></label>
            <input type="text" id="firstname" name="firstname" placeholder="Votre prénom" required>
            <?php if (isset($firstnameError)) { echo "<p class='error'>$firstnameError</p>"; } ?>
        </div>
    <!--last name-->
        <div>
            <label for="name">Nom <span class="required">*</span></label>
            <input type="text" id="name" name="name" placeholder="Votre nom" required>
            <?php if (isset($nameError)) { echo "<p class='error'>$nameError</p>"; } ?>
        </div>
    <!--Email-->
        <div>
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" id="email" name="email" placeholder="Votre email" required>
            <?php if (isset($emailError)) { echo "<p class='error'>$emailError</p>"; } ?>
        </div>
    <!--Phone number-->
        <div>
            <label for="phone">Téléphone <span class="required">*</span></label>
            <input type="text" id="phone" name="phone" placeholder="Votre téléphone" required>
            <?php if (isset($phoneError)) { echo "<p class='error'>$phoneError</p>"; } ?>
        </div>
    <!--Country-->
        <div>
            <label for="pays">Pays <span class="required">*</span></label>
            <input type="text" id="pays" name="pays" placeholder="Votre pays" required>
            <?php if (isset($paysError)) { echo "<p class='error'>$paysError</p>"; } ?>
        </div>
    <!--Password-->
        <div>
            <label for="password">Mot de passe <span class="required">*</span></label>
            <input type="password" id="password" name="password" placeholder="Votre mot de passe" required>
            <?php if (isset($passwordError)) { echo "<p class='error'>$passwordError</p>"; } ?>
        </div>

        <button type="submit" name="submit">S'inscrire</button>
    </form>
</div>

</body>
</html>
