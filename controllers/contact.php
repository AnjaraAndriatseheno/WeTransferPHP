<?php
// Connexion à la base de données 
$host = "localhost";
$dbname = "Projet_php";
$username = "root"; 
$password = ""; 

try {
    // Créer une connexion
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Déclaration des variables pour stocker les valeurs du formulaire
$firstname = $name = $email = $phone = $pays = $password = "";
$firstnameError = $nameError = $emailError = $phoneError = $paysError = $passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $pays = trim($_POST['pays']);
    $password = trim($_POST['password']);

    // Validation des champs
    $isValid = true;

    // Validation du prénom
    if (empty($firstname)) {
        $firstnameError = "Le prénom est requis !";
        $isValid = false;
    }

    // Validation du nom
    if (empty($name)) {
        $nameError = "Le nom est requis !";
        $isValid = false;
    }

    // Validation de l'email
    if (empty($email)) {
        $emailError = "L'email est requis !";
        $isValid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = "L'email est invalide !";
        $isValid = false;
    }

    // Validation du téléphone
    if (empty($phone)) {
        $phoneError = "Le téléphone est requis !";
        $isValid = false;
    }

    // Validation du pays
    if (empty($pays)) {
        $paysError = "Le pays est requis !";
        $isValid = false;
    }

    // Validation du mot de passe
    if (empty($password)) {
        $passwordError = "Le mot de passe est requis !";
        $isValid = false;
    }

    if ($isValid) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête SQL pour insérer les données dans la table 'utilisateurs'
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, telephone, pays, mot_de_passe)
                VALUES (:name, :firstname, :email, :phone, :pays, :password)";

        try {
            // Préparer la requête avec PDO
            $stmt = $conn->prepare($sql);
            
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':pays', $pays);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                // Redirection vers la page de téléchargement (upload.php)
                header("Location: upload.php?success=1");
                exit();
            } else {
                echo "Erreur lors de l'insertion.";
            }
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion dans la base de données : " . $e->getMessage();
        }
    }

    // Fermer la connexion PDO
    $conn = null;
}
?>
