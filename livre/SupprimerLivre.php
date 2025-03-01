<?php

include_once '../connexion_db.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $con->prepare("DELETE FROM livres WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: ../admin.php?message=livre_supprime");

exit();