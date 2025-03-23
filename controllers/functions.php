<?php
session_start();

function getUserID() {
    if (isset($_COOKIE['user_id'])) {
        $user_id = $_COOKIE['user_id'];
        if (is_numeric($user_id) && intval($user_id) > 0) {
            return intval($user_id);
        } else {
            return null;
        }
    } else {
        return null;
    }
}

function getCurrentMail() {
    if (isset($_COOKIE['user_email'])) {
        return $_COOKIE['user_email'];
    } else {
        return null;
    }
}

function modifyMail($conn) {
    $currentMail = filter_input(INPUT_POST, "user_mail", FILTER_VALIDATE_EMAIL);
    $newMail = filter_input(INPUT_POST, "new_mail", FILTER_VALIDATE_EMAIL);
    
    if ($newMail === false) {
        return "Veuillez saisir une adresse e-mail valide.";
    }
    
    $user_id = getUserID();
    if ($user_id === null) {
        return "Impossible de récupérer votre identifiant. Veuillez vous reconnecter.";
    }
    
    $currentMail = getCurrentMail();
    if ($currentMail === null) {
        return "Impossible de récupérer votre e-mail actuel. Veuillez vous reconnecter.";
    }
    
    if ($newMail === $currentMail) {
        return "Cet e-mail est déjà votre e-mail actuel, veuillez en saisir un autre.";
    }
    
    $sql = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email AND id != :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $newMail, PDO::PARAM_STR);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    
    if ($count > 0) {
        return "L'adresse mail est déjà utilisée.";
    } else {
        $sql = "UPDATE utilisateurs SET email = :email WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $newMail, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            setcookie('user_email', $newMail, time() + 365 * 24 * 60 * 60, '/');
            return "L'e-mail a été modifié avec succès";
        } else {
            return "Une erreur est survenue lors de la modification de l'e-mail, réessayez plus tard.";
        }
    }
}

function modifyPassword($conn) {
    $currentPassword = filter_input(INPUT_POST, "currentPassword", FILTER_SANITIZE_STRING);
    $newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_STRING);
    $confirmNewPassword = filter_input(INPUT_POST, "confirmNewPassword", FILTER_SANITIZE_STRING);

    if (!$currentPassword || !$newPassword || !$confirmNewPassword) {
        return "Veuillez remplir tous les champs.";
    }
    
    if ($newPassword === $currentPassword) {
        return "Vous devez choisir un nouveau mot de passe.";
    }
    
    if ($newPassword !== $confirmNewPassword) {
        return "Le mot de passe ne correspond pas.";
    }
    
    $user_id = getUserID();
    if ($user_id === null) {
        return "Impossible de récupérer votre identifiant. Veuillez vous reconnecter.";
    }
    
    try {
        $sql = "SELECT mot_de_passe FROM utilisateurs WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            return "Impossible de récupérer votre mot de passe actuel. Veuillez contacter l'administrateur.";
        }

        $currentHashedPassword = $result['mot_de_passe'];

        if (!password_verify($currentPassword, $currentHashedPassword)) {
            return "Le mot de passe actuel est incorrect.";
        }

        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE utilisateurs SET mot_de_passe = :new_password WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':new_password', $hashedNewPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Le mot de passe a été modifié avec succès.";
        } else {
            return "Une erreur est survenue veuillez réessayer plus tard.";
        }
    } catch (PDOException $e) {
        return "Erreur de base de données : ". $e->getMessage();
    }
}