<?php
// Connexion à la base de données MySQL qui va stocker les données des UI
$servername = "localhost"; // Serveur MySQL 
$username = "root"; // Nom d'utilisateur MySQL
$password = ""; // Mot de passe MySQL (vide)
$dbname = "Projet_php"; // Nom de la base de données

// Créer une connexion à MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier si la connexion a échoué
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données: " . $conn->connect_error);
}//die pour arrêter l'exécution du script et afficher un message d'erreur

// Déclaration des variables pour stocker les valeurs du formulaire
$firstname = $name = $email = $phone = $pays = $password = "";
$firstnameError = $nameError = $emailError = $phoneError = $paysError = $passwordError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Récupérer les données soumises du formulaire
    $firstname = trim($_POST['firstname']); //trim() pour supprimer les espaces blancs et les caractères spéciaux
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $pays = trim($_POST['pays']);
    $password = trim($_POST['password']);

    // Validation des champs
    $isValid = true; // Variable pour vérifier si tous les champs sont valides

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
        // Hasher le mot de passe pour le stocker de façon sécurisée
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // insertion dans la table 'utilisateurs'
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, telephone, pays, mot_de_passe)
                VALUES ('$name', '$firstname', '$email', '$phone', '$pays', '$hashedPassword')";

        // Exécuter la requête et vérifier si l'insertion a réussi
        if ($conn->query($sql) === TRUE) {
            // Redirection vers la même page avec un message de succès
            header("Location: contact.php?success=1");
            exit(); 
        } else {
            echo "Erreur lors de l'insertion : " . $conn->error; //Afficher l'erreur SQL
        }
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>