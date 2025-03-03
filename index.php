<?php
session_start();
include 'menu.php';
include 'connexion_db.php';

// Fonction pour récupérer les livres
function LireLivre()
{
    global $con;
    $sql = "SELECT * FROM livres";
    $stmt = $con->query($sql);
    return $stmt->fetchAll();
}

$livres = LireLivre();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Library</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Message de connexion réussie -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 'connecte') { ?>
        <div class="alert alert-success text-center">
            Connexion réussie ! Bienvenue, <?= htmlspecialchars($_SESSION['email']) ?> 🎉
        </div>
    <?php } ?>

    <div class="row bg-secondary text-light p-4 d-flex align-items-center">
        <div class="col-md-6 mt-4 text-center">
            <h1>Online Library</h1>
        </div>
        <div class="col-md-6 mt-4 text-center">
            <img src="./imgs/undraw_education_3vwh.svg" class="img-fluid w-50" alt="Illustration éducation">
        </div>
    </div>

    <div class="container">
        <div class="row mt-5 text-center" id="watch">
            <?php foreach ($livres as $livre) { ?>
                <div class="col-md-3 col-6 py-2">
                    <div class="card shadow-sm">
                        <img src="<?= htmlspecialchars($livre['image']) ?>" alt="Couverture du livre <?= htmlspecialchars($livre['titre']) ?>" class="img-fluid pb-1">
                        <div class="figure-caption bg-secondary text-light p-2">
                            <h6> Titre : <?= htmlspecialchars($livre['titre']) ?></h6>
                            <h6> Catégorie : <?= htmlspecialchars($livre['categorie']) ?></h6>
                            <p><a href="#" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#modalLivre<?= $livre['id']; ?>">Voir plus</a></p>
                        </div>
                    </div>
                </div>

                <!-- Modal Détails du Livre -->
                <div class="modal fade" id="modalLivre<?= $livre['id']; ?>" tabindex="-1" aria-labelledby="modalLabel<?= $livre['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel<?= $livre['id']; ?>"><?= htmlspecialchars($livre['titre']) ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="<?= htmlspecialchars($livre['image']) ?>" alt="Couverture du livre <?= htmlspecialchars($livre['titre']) ?>" class="img-fluid">
                                    </div>
                                    <div class="col-md-8">
                                        <p><strong>Catégorie :</strong> <?= htmlspecialchars($livre['categorie']) ?></p>
                                        <p><strong>Auteur :</strong> <?= htmlspecialchars($livre['auteur']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <?php if (isset($_SESSION['id'])) { ?>
                                    <a href="commentaire.php?livre_id=<?= $livre['id'] ?>" class="btn btn-success">Laissez un commentaire</a>
                                <?php } else { ?>
                                    <a href="form_connexion.php" class="btn btn-danger">Connectez-vous pour commenter</a>
                                <?php } ?>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>