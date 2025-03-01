<?php
include_once '../connexion_db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id = intval($_POST['id']);
        $titre = trim($_POST['titre']);
        $auteur = trim($_POST['auteur']);
        $categorie = trim($_POST['categorie']);
        $annee = intval($_POST["annee"]);
        $imagePath = null;

        // Vérifier si le livre existe
        $stmt = $con->prepare("SELECT image FROM livres WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $livre = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$livre) {
            throw new Exception("Livre non trouvé !");
        }

        // Gestion de l'image : si une nouvelle image est fournie
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = "../uploads/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imageName = time() . "_" . basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                throw new Exception("Erreur lors de l'upload de l'image.");
            }

            // Supprimer l'ancienne image si elle existe
            if (!empty($livre['image']) && file_exists($livre['image'])) {
                unlink($livre['image']);
            }
        } else {
            $imagePath = $livre['image']; // Conserver l'ancienne image
        }

        // Mettre à jour les informations du livre
        $stmt = $con->prepare("UPDATE livres SET titre = :titre, auteur = :auteur, categorie = :categorie, annee = :annee, image = :image WHERE id = :id");
        $stmt->execute([
            ':id' => $id,
            ':titre' => $titre,
            ':auteur' => $auteur,
            ':categorie' => $categorie,
            ':annee' => $annee,
            ':image' => $imagePath
        ]);

        header("Location: ../admin.php?message=livre_modifie"); // Redirection après mise à jour
        exit();
    } catch (Exception $e) {
        echo "<script>alert('Erreur : " . $e->getMessage() . "');</script>";
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
    include '../menu.php';

    function getLivre($id)
    {
        global $con;
        $stmt = $con->prepare("SELECT * FROM livres WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    $livre = getLivre($_GET['id']);

    ?>

    <div class="d-flex justify-content-center">
        <div class="card w-50 mt-5">
            <div class="card-header text-center">
                Modifier Livre
            </div>
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $livre['id']; ?>">

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control" name="titre" value="<?php echo $livre['titre']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="auteur" class="form-label">Auteur</label>
                        <input type="text" class="form-control" name="auteur" value="<?php echo $livre['auteur']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="annee" class="form-label">Année</label>
                        <input class="form-control" name="annee" value="<?php echo $livre['annee']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="categorie" class="form-label">categorie</label>
                        <input class="form-control" name="categorie" value="<?php echo $livre['categorie']; ?>" rows="3" required>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image du livre</label>
                        <input type="file" class="form-control" name="image">
                        <p>Image actuelle : <img src="<?php echo $livre['image']; ?>" width="50"></p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" name="modifier_livre">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>