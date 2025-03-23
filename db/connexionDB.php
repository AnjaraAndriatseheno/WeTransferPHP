<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=dashboard;charset=utf8", "root", "BDPHP");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
