<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowedExtensions = ['jpg', 'png', 'gif', 'webp'];
        $maxFileSize = 1048576; // 1 Mo

        $fileName = $_FILES['photo']['name'];
        $fileSize = $_FILES['photo']['size'];
        $fileTmp = $_FILES['photo']['tmp_name'];

        // Récupérer l'extension du fichier
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Vérifier l'extension et la taille du fichier
        if (in_array($fileExtension, $allowedExtensions) && $fileSize <= $maxFileSize) {
            // Générer un nom de fichier unique
            $newFileName = uniqid() . '.' . $fileExtension;

            // Déplacer le fichier vers le répertoire souhaité
            $destination = 'uploads/' . $newFileName;
            if (move_uploaded_file($fileTmp, $destination)) {
                // Afficher les informations sur Homer et Marge avec la photo
                $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : 'Homer';
                $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : 'Simpson';
                $age = isset($_POST['age']) ? $_POST['age'] : '42';

                echo '<h1>Informations sur Homer et Marge</h1>';
                echo '<p>Prénom : ' . htmlspecialchars($firstName) . '</p>';
                echo '<p>Nom : ' . htmlspecialchars($lastName) . '</p>';
                echo '<p>Âge : ' . htmlspecialchars($age) . '</p>';
                echo '<img src="' . htmlspecialchars($destination) . '" alt="Photo">';
            } else {
                echo 'Une erreur est survenue lors du téléchargement du fichier.';
            }
        } else {
            echo 'Le fichier doit être au format JPG, PNG, GIF ou WEBP et ne doit pas dépasser 1 Mo.';
        }
    } else {
        echo 'Veuillez sélectionner un fichier à télécharger.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Uploader une photo</title>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    <label for="first_name">Prénom :</label>
    <input type="text" name="first_name" id="first_name" required><br>

    <label for="last_name">Nom :</label>
    <input type="text" name="last_name" id="last_name" required><br>

    <label for="age">Âge :</label>
    <input type="number" name="age" id="age" required><br>

    <label for="photo">Photo :</label>
    <input type="file" name="photo" id="photo" required accept=".jpg, .png, .gif, .webp"><br>

    <input type="submit" value="Envoyer">
</form>
</body>
</html>
