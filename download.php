<?php
// Démarrer la session
session_start();

$downloadCountFilePath = 'download_count.txt';

// Fonction pour obtenir le nb de téléchargements
function getDownloadCount($downloadCountFilePath) {
    if (file_exists($downloadCountFilePath)) {
        return (int)file_get_contents($downloadCountFilePath);
    }
    return 0;
}

// Fonction pour MAJ le nb de téléchargements
function updateDownloadCount($downloadCountFilePath, $count) {
    file_put_contents($downloadCountFilePath, $count);
}

function downloadFileIfLoggedIn($filePath) {
    if (!isset($_SESSION["connected"]) || $_SESSION["connected"]!== true) {
        header("Location: login.php");
        exit;
    }

    if (file_exists($filePath)) {
        $downloadCount = getDownloadCount($downloadCountFilePath);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'. basename($filePath).'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: '. filesize($filePath));
        ob_clean();
        flush();
        readfile($filePath);

        $newCount = $downloadCount + 1;
        updateDownloadCount($downloadCountFilePath, $newCount);

        exit;
    } else {
        echo "Le fichier n'a pas été trouvé.";
    }
}



// Exemple d'utilisation de la fonction
$fileToDownload = 'chemin/vers/votre/fichier.txt';
$currentDownloadCount = getDownloadCount($downloadCountFilePath);
echo "Ce fichier a été téléchargé $currentDownloadCount fois.<br>";
downloadFileIfLoggedIn($fileToDownload);

?>