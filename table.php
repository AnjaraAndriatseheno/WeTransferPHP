<?php

require 'BD.php' ;

$sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    telephone VARCHAR(20),
    pays VARCHAR(100),
    mot_de_passe VARCHAR(255) NOT NULL
    )";

try {
    $conn->exec($sql);
    echo "Table 'utilisateurs' créée avec succès.";
} catch (PDOException $e) {
    echo "Erreur lors de la création de la table : " . $e->getMessage();
}
?>