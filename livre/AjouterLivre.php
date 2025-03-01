<?php

include_once '../connexion_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Récupération des valeurs du formulaire
        $titre = trim($_POST["titre"]);
        $auteur = trim($_POST["auteur"]);
        $categorie = trim($_POST["categorie"]);
        $annee = intval($_POST["annee"]);
        $imagePath = null;

        // Vérification et upload de l'image
        if (!empty($_FILES["image"]["name"])) {
            $uploadDir = "../uploads/";
            // Assure-toi que ce dossier existe
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = time() . "_" . basename($_FILES["image"]["name"]);
            $imagePath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                throw new Exception("Erreur lors de l'upload de l'image.");
            }
        }

        // Requête SQL pour insérer le produit
        $sql = "INSERT INTO livres (titre, auteur, categorie, annee, image) 
                VALUES (:titre, :auteur, :categorie, :annee, :image)";
        $stmt = $con->prepare($sql);

        $stmt->execute([
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':categorie' => $categorie,
            ':annee' => $annee,
            ':image' => $imagePath
        ]);

        // Redirection après succès
        header("Location: ../admin.php?message=livre_ajoute");
        exit();
    } catch (Exception $e) {
        die("Erreur : " . $e->getMessage());
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
    <?php
    include '../menu.php'
    ?>

    <div class="d-flex justify-content-center">
        <div class="card w-50 mt-5">
            <div class="card-header text-center">
                Ajouter Livre
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="titre" class="form-label">titre du livre</label>
                        <input type="text" class="form-control" id="titre" name="titre" required>
                    </div>

                    <div class="mb-3">
                        <label for="auteur" class="form-label">auteur</label>
                        <input type="text" class="form-control" id="auteur" name="auteur" required>
                    </div>

                    <div class="mb-3">
                        <label for="categorie" class="form-label">categorie</label>
                        <input type="text" class="form-control" id="categorie" name="categorie" required>
                    </div>

                    <div class="mb-3">
                        <label for="annee" class="form-label">annee</label>
                        <input class="form-control" id="annee" name="annee" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image du livre</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>