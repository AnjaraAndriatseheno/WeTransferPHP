<?php
session_start();
require_once 'BD.php';

if (!isset($_COOKIE['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$user_id = $_COOKIE['user_id'];
$current_email = $_COOKIE['user_email'];
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Modifier l'email
    if (isset($_POST['modify_email'])) {
        $new_email = $_POST['new_mail'];
        $sql = "UPDATE utilisateurs SET email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $new_email, ':id' => $user_id]);
        $_COOKIE['user_email'] = $new_email;
        $message = "Email modifié !";
    }

    // Modifier le mot de passe
    if (isset($_POST['modify_password'])) {
        $new_password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
        $sql = "UPDATE utilisateurs SET mot_de_passe = :password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':password' => $new_password, ':id' => $user_id]);
        $message = "Mot de passe modifié !";
    }
}

$sql = "SELECT nom, prenom, email, telephone, pays FROM utilisateurs WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Compte</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">ICNA</div>
        <nav>
            <a href="upload.php">Télécharger</a>
            <a href="compte.php">Compte</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <main>
        <h1>Mon Compte</h1>
        
        <div class="info">
            <h2>Informations</h2>
            <p>Nom : <?= $user['nom'] ?></p>
            <p>Prénom : <?= $user['prenom'] ?></p>
            <p>Email : <?= $user['email'] ?></p>
            <p>Téléphone : <?= $user['telephone'] ?></p>
            <p>Pays : <?= $user['pays'] ?></p>
        </div>

        <!-- Modifier Email -->
        <div class="form-section">
            <h2>Changer d'Email</h2>
            <?php if ($message): ?>
                <p class="message"><?= $message ?></p>
            <?php endif; ?>
            <form method="POST">
                <label>Email actuel :</label>
                <input type="email" name="current_email" value="<?= $current_email ?>" required>
                <br>
                <label>Nouvel email :</label>
                <input type="email" name="new_mail" required>
                <br>
                <button type="submit" name="modify_email">Changer</button>
            </form>
        </div>

        <!-- Modifier Mot de passe -->
        <div class="form-section">
            <h2>Changer Mot de passe</h2>
            <form method="POST">
                <label>Mot de passe actuel :</label>
                <input type="password" name="current_password" required>
                <br>
                <label>Nouveau mot de passe :</label>
                <input type="password" name="newPassword" required>
                <br>
                <label>Confirmer :</label>
                <input type="password" name="confirmPassword" required>
                <br>
                <button type="submit" name="modify_password">Changer</button>
            </form>
        </div>
    </main>
</body>
</html>