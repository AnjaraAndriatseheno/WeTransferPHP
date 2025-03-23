<!-- fichier pour gérer l'upload et assurer l'enregistrement dans la BD -->

<?php
require 'BD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"]) && isset($_POST["user_email"])) {
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_name = $_FILES["file"]["name"];
    $file_tmp = $_FILES["file"]["tmp_name"];
    $user_email = $_POST["user_email"];

    $key = strtoupper(substr(md5(uniqid()), 0, 8));
    $file_path = $upload_dir . $key . "_" . basename($file_name);

    if (move_uploaded_file($file_tmp, $file_path)) {
        $stmt = $conn->prepare("INSERT INTO files (file_name, file_path, download_key) VALUES (?, ?, ?)");
        $stmt->execute([$file_name, $file_path, $key]);
        $file_id = $conn->lastInsertId();

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$user_email]);

        if ($stmt->rowCount() > 0) {
            $stmt = $conn->prepare("INSERT INTO file_access (file_id, user_email) VALUES (?, ?)");
            $stmt->execute([$file_id, $user_email]);

            // Si le mail est trouvé, le téléchargement est autorisé
            mail($user_email, "Lien de téléchargement", "Téléchargez votre fichier ici : http://localhost/telechargement.php?cle=$key");

            echo "Fichier uploadé ! Lien envoyé à $user_email.";
        } else {
            echo "Erreur : cet email n'est pas enregistré.";
        }
    } else {
        echo "Erreur lors du téléchargement.";
    }
} else {
    echo "Formulaire invalide.";
}
?>
