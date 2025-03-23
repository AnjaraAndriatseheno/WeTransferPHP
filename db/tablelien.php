<?php

require 'BD.php'; 

try {
    
    $sql = "CREATE TABLE IF NOT EXISTS utilisateurs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nom VARCHAR(255) NOT NULL,
        prenom VARCHAR(255) NOT NULL,fi
        email VARCHAR(255) UNIQUE NOT NULL,
        telephone VARCHAR(20),
        pays VARCHAR(100),
        mot_de_passe VARCHAR(255) NOT NULL
    )";
    $conn->exec($sql);
    echo "Table 'utilisateurs' créée avec succès.<br>";

   
    $sql = "CREATE TABLE IF NOT EXISTS files (
        id INT AUTO_INCREMENT PRIMARY KEY,
        file_name VARCHAR(255) NOT NULL,
        file_path VARCHAR(255) NOT NULL,
        download_key VARCHAR(10) UNIQUE NOT NULL
    )";
    $conn->exec($sql);
    echo "Table 'files' créée avec succès.<br>";

    $sql = "CREATE TABLE IF NOT EXISTS file_access (
        id INT AUTO_INCREMENT PRIMARY KEY,
        file_id INT NOT NULL,
        user_email VARCHAR(255) NOT NULL,
        FOREIGN KEY (file_id) REFERENCES files(id) ON DELETE CASCADE,
        FOREIGN KEY (user_email) REFERENCES utilisateurs(email) ON DELETE CASCADE
    )";
    $conn->exec($sql);
    echo "Table 'file_access' créée avec succès.<br>";


} catch (PDOException $e) {
    echo "Erreur lors de la création des tables : " . $e->getMessage();
}

?>
