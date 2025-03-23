<?php
require_once 'BD.php';
require_once 'fonctions.php';
session_start();

if (!getUserID()) {
    header("Location: connexion.php");
    exit();
}

$user_id = getUserID();
$currentMail = getCurrentMail();

$messageMail = '';
$messagePassword = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['modify_email'])) {
        $messageMail = modifyMail($conn);
    } elseif (isset($_POST['modify_password'])) {
        $messagePassword = modifyPassword($conn);
    }
}

$sql = "SELECT nom, prenom, email, telephone, pays FROM utilisateurs WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link rel="stylesheet" href="upload.css">
    <link rel="stylesheet" href="compte.css">
</head>
<body>
    <header>
        <div class="logo">ICNA</div>
        <nav>
            <ul>
                <li><a href="contact.php">Inscription</a></li>
                <li><a href="upload.php">Télécharger</a></li>
                <li><a href="compte.php">Compte</a></li>
                <li><a href="deconnexion.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Mon Compte</h1>
        
        <h2>Informations personnelles</h2>
        <p>Nom : <?= $user['nom'] ?></p>
        <p>Prénom : <?= $user['prenom'] ?></p>
        <p>Email : <?= $user['email'] ?></p>
        <p>Téléphone : <?= $user['telephone'] ?></p>
        <p>Pays : <?= $user['pays'] ?></p>

        <h2>Modifier mon email</h2>
        <?php if ($messageMail): ?>
            <p style="color: <?= strpos($messageMail, 'success') ? 'green' : 'red' ?>"><?= $messageMail ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="modify_email" value="1">
            <label>Email actuel :</label>
            <input type="email" name="user_mail" value="<?= $currentMail ?>" required>
            <br>
            <label>Nouveau email :</label>
            <input type="email" name="new_mail" required>
            <br>
            <button type="submit">Modifier l'email</button>
        </form>

        <h2>Modifier mon mot de passe</h2>
        <?php if ($messagePassword): ?>
            <p style="color: <?= strpos($messagePassword, 'success') ? 'green' : 'red' ?>"><?= $messagePassword ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="hidden" name="modify_password" value="1">
            <label>Mot de passe actuel :</label>
            <input type="password" name="currentPassword" required>
            <br>
            <label>Nouveau mot de passe :</label>
            <input type="password" name="newPassword" required>
            <br>
            <label>Confirmer le nouveau mot de passe :</label>
            <input type="password" name="confirmNewPassword" required>
            <br>
            <button type="submit">Modifier le mot de passe</button>
        </form>
    </main>
</body>
</html>