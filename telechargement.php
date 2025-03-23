<?php
require 'BD.php';

if (isset($_POST["cle"]) && isset($_POST["user_email"])) {
    $key = $_POST["cle"];
    $user_email = $_POST["user_email"];

    $stmt = $conn->prepare("SELECT id, file_name, file_path FROM files WHERE download_key = ?");
    $stmt->execute([$key]);
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($file) {
        $file_id = $file["id"];

        $stmt = $conn->prepare("SELECT id FROM file_access WHERE file_id = ? AND user_email = ?");
        $stmt->execute([$file_id, $user_email]);

        if ($stmt->rowCount() > 0) {
            $file_path = $file["file_path"];
            $file_name = $file["file_name"];

            if (file_exists($file_path)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit;
            } else {
                die("Erreur : fichier introuvable.");
            }
        } else {
            die("Accès refusé.");
        }
    } else {
        die("Clé invalide.");
    }
}
?>

<!-- Rajout d'un formulaire pour renseigner son email -->
<form action="telechargement.php" method="POST">
    <input type="hidden" name="cle" value="<?php echo $_GET['cle']; ?>">
    <input type="email" name="user_email" placeholder="Votre email" required>
    <button type="submit">Télécharger</button>
</form>
