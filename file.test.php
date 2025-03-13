<?php
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $file = $_FILES["file"]
    
    if(isset($file) && empty($file["error"])){
        $name = $file["name"];
        $temp_name = $file["tmp_name"];
        $type = $file["type"];
        $size = $file["size"];
        
        if ($size > 20000000) {
            echo "L'extention '.php' n'est pas autorisé. Veuillez modifier le nom du fichier ou réessayer à nouveau.";
        }
        
        if ($type === "test/php"){
            echo "Votre fichier est trop lourd. Veuillez en insérer un nouveau.";
        }
        // rename()
        $data = file_get_contents($temp_name);
        // ENREGISTER DANS UN DOSSIER AYANT POUR NOM LE HASH DE L'EMAIL DU DESTINATAIRE
        file_put_contents("uploads/$name", $data);
        echo "Fichier envoyé avec succes !"
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file" id="file">
        <button type="submit">Send</button>
    </form>
</body>
</html>