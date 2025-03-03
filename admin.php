<?php
session_start();

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Redirige vers la page de connexion avec un message d'erreur
    header("Location: form_connexion.php?errorl=Veuillez vous connecter pour accéder à l'administration.");
    exit();
}

// Vérifie si l'utilisateur a l'ID 1 (Admin)
if ($_SESSION['id'] != 1) {
    // Redirige vers une autre page s'il n'est pas admin
    header("Location: livre.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tableau de bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="itim-regular">

    <?php
    // Connexion à la base de données
    include 'connexion_db.php';
    function LireLivre()
    {
        global $con;
        $sql = "SELECT * FROM livres";
        $stmt = $con->query($sql);
        return $stmt->fetchAll();
    }
    // 🔹 Récupération des livres pour affichage
    $livres = LireLivre();

    include 'menu.php'
    ?>

    <div class="container mt-4">

        <?php
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
            if ($message == "livre_modifie") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        Le livre a été modifié avec succès !
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            if ($message == "livre_supprime") {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                         Le livre a été supprimé avec succès !
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
            if ($message == "livre_ajoute") {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                         Le livre a été ajouté avec succès !
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
            }
        }
        ?>

        <div>
            <h2 class="text-center alert alert-primary">Liste des livres</h2>

            <!-- Bouton pour ouvrir le modal d'ajout -->
            <a href="./livre/AjouterLivre.php">
                <button type="button" class="btn btn-outline-dark">
                    Ajouter livre
                </button>
            </a>

            <!-- Affichage des livres -->
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>titre</th>
                        <th>auteur</th>
                        <th>categorie</th>
                        <th>annee</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($livres as $livre) : ?>
                        <tr>
                            <td><?= htmlspecialchars($livre['id']) ?></td>
                            <td><?= htmlspecialchars($livre['titre']) ?></td>
                            <td><?= htmlspecialchars($livre['auteur']) ?></td>
                            <td><?= htmlspecialchars($livre['categorie']) ?></td>
                            <td><?= htmlspecialchars($livre['annee']) ?></td>
                            <td>
                                <?php if (!empty($livre['image'])) : ?>
                                    <img src="<?= htmlspecialchars($livre['image']) ?>" alt="Image livre" width="50">
                                <?php else : ?>
                                    Aucune image
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="./livre/SupprimerLivre.php?id=<?= $livre['id']; ?>">
                                    <button type="button" class="btn btn-outline-danger">
                                        <i class="fas fa-trash-alt">Supprimer</i>
                                    </button>
                                </a>
                                <a href="./livre/ModifierLivre.php?id=<?= $livre['id']; ?>">
                                    <button type="button" class="btn btn-outline-primary">
                                        <i class="fas fa-trash-alt">Modifier</i>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>