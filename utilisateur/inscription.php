<?php
include_once '../connexion_db.php';
try {
    // Vérifier si les champs existent dans $_POST
    if (!isset($_POST['email'], $_POST['password'], $_POST['nom'], $_POST['prenom'])) {
        throw new Exception("Erreur : Tous les champs sont obligatoires.");
    }

    // Récupérer et nettoyer les valeurs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);


    // Hacher le mot de passe
    $pass_hashed = password_hash($password, PASSWORD_DEFAULT);

    // Vérifier si l'email existe déjà
    $query = "SELECT COUNT(*) FROM utilisateurs WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->execute([$email]);
    $num = $stmt->fetchColumn();

    if ($num != 0) {
        throw new Exception("Erreur : Cet email est déjà utilisé.");
    }

    // Insérer l'utilisateur
    $query = "INSERT INTO utilisateurs (email, nom, prenom, password) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->execute([$email, $nom, $prenom, $pass_hashed]);

    // Récupérer l'ID de l'utilisateur inséré
    $id = $con->lastInsertId();

    // Stocker les infos en session
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $id;

    // Rediriger vers la page produits
    header('Location: ../form_connexion.php');
    exit();
} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}

?>