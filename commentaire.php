<?php
session_start();
include_once 'connexion_db.php';

// Vérifie si un livre est sélectionné
if (!isset($_GET['livre_id'])) {
    header("Location: index.php");
    exit();
}

$livre_id = intval($_GET['livre_id']);

// Récupération des informations du livre
$queryLivre = $con->prepare("SELECT * FROM livres WHERE id = ?");
$queryLivre->execute([$livre_id]);
$livre = $queryLivre->fetch(PDO::FETCH_ASSOC);

if (!$livre) {
    echo "<p>Livre non trouvé.</p>";
    exit();
}

// Récupération des commentaires du livre
$queryCommentaires = $con->prepare("
    SELECT c.*, u.nom 
    FROM commentaires c 
    JOIN utilisateurs u ON c.id_utilisateur = u.id 
    WHERE c.id_livre = ? 
    ORDER BY c.date_publication DESC
");
$queryCommentaires->execute([$livre_id]);
$commentaires = $queryCommentaires->fetchAll(PDO::FETCH_ASSOC);

// Gestion de l'ajout d'un commentaire
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['id'])) {
    $commentaire = trim($_POST['commentaire']);
    if (!empty($commentaire)) {
        $queryInsert = $con->prepare("INSERT INTO commentaires (id_livre, id_utilisateur, commentaire) VALUES (?, ?, ?)");
        $queryInsert->execute([$livre_id, $_SESSION['id'], $commentaire]);
        header("Location: commentaire.php?livre_id=$livre_id");
        exit();
    } else {
        $error = "Le commentaire ne peut pas être vide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires - <?= htmlspecialchars($livre['titre']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>

    <?php
    include "menu.php"
    ?>

    <div class="container mt-5">
        <h2 class="text-center"><?= htmlspecialchars($livre['titre']) ?></h2>
        <p class="text-center"><?= htmlspecialchars($livre['auteur']) ?></p>

        <hr>

        <h4>Commentaires :</h4>
        <?php if ($commentaires) { ?>
            <ul class="list-group">
                <?php foreach ($commentaires as $commentaire) { ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($commentaire['nom']) ?> :</strong> <?= htmlspecialchars($commentaire['commentaire']) ?>
                        <br><small class="text-muted">Publié le <?= $commentaire['date_publication'] ?></small>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>Aucun commentaire pour le moment.</p>
        <?php } ?>

        <hr>

        <?php if (isset($_SESSION['id'])) { ?>
            <!-- Formulaire pour ajouter un commentaire -->
            <h4>Ajouter un commentaire :</h4>
            <?php if (isset($error)) {
                echo "<p class='text-danger'>$error</p>";
            } ?>
            <form method="post">
                <div class="mb-3">
                    <textarea name="commentaire" class="form-control" rows="4" required placeholder="Écrivez votre commentaire ici..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Publier</button>
            </form>
        <?php } else { ?>
            <p class="text-center"><a href="index.php#login" class="btn btn-danger">Connectez-vous pour laisser un commentaire</a></p>
        <?php } ?>

    </div>

</body>

</html>