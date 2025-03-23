<?php
require_once 'BD.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $file = $_FILES["file"];
    
    if (isset($file) && empty($file["error"])) {
        $name = $file["name"];
        $temp_name = $file["tmp_name"];
        $type = $file["type"];
        $size = $file["size"];
        
        if ($size > 20000000) {
            echo "Votre fichier est trop lourd. Veuillez en insérer un nouveau.";
        } elseif ($type === "app/php" || pathinfo($name, PATHINFO_EXTENSION) === "php") {
            echo "L'extention '.php' n'est pas autorisé. Veuillez modifier le nom du fichier ou réessayer à nouveau.";
        } else {
            $email_hash = md5("email@exemple.com");
            $target_dir = "uploads/$email_hash/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true); // crée dossier si inexistant
            }
            $target_file = $target_dir . basename($name);
            if (move_uploaded_file($temp_name, $target_file)) {
                echo "Fichier envoyé avec succès !";
            } else {
                echo "Erreur lors de l'envoi du fichier.";
            // file_put_contents("uploads/$name", file_get_contents($temp_name));
            // echo "Fichier envoyé avec succes !";
            }
        }
    }

    // supression d'un fichier
    if (isset($_POST["delete_file"])) {
        $file_to_delete = $_POST["delete_file"];
        $file_path = "uploads/" . basename($file_to_delete);

        if (file_exists($file_path)) {
            unlink($file_path);
            echo "Fichier supprimé avec succès.";
        } else {
            echo "Fichier introuvable.";
        }
    }
}

$file = []
$upload_dir = "uploads/";
foreach (glob($upload_dir . "*") as $file) {
    $files[] = basename($file);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des fichiers</title>
</head>
<body>
    <h2>Téléchargement de fichiers</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <button type="submit">Envoyer</button>
    </form>

    <ul>
        <?php foreach ($files as $file): ?>
            <li>
                <?= htmlspecialchars($file) ?>
                <form action="" method="post" style="display:inline;" onsubmit="return confirm(`Voulez-vous vraiment supprimer ce fichier ?`);">
                    <input type="hidden" name="delete_file" value="<?= $file ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>