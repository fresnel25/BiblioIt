<?php
// Démarrer la session pour pouvoir utiliser $_SESSION
session_start();

// Connexion à la base de données (assurez-vous que $con est défini)
include_once '../connexion_db.php';

// Vérification des champs POST
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Récupération des informations du formulaire
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Protection contre les injections SQL
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Utilisation de requêtes préparées avec PDO pour éviter les injections SQL
    $query = "SELECT id, email, password FROM utilisateurs WHERE email = :email";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Vérification si un utilisateur est trouvé
    if ($stmt->rowCount() == 0) {
        // Si l'utilisateur n'est pas trouvé
        $m = "Please enter correct E-mail id and Password";
        header('location: index.php?errorl=' . urlencode($m));
        exit();
    } else {
        // Si l'utilisateur est trouvé, vérifier le mot de passe
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Comparaison du mot de passe
        if (password_verify($password, $row['password'])) {
            // Si le mot de passe est correct, stocker les informations dans la session
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];

            // Rediriger vers la page des produits
            header('location: products.php');
            exit();
        } else {
            // Si le mot de passe est incorrect
            $m = "Incorrect password.";
            header('location: ../index.php?message=' . urlencode($m));
            exit();
        }
    }
} else {
    // Si les champs POST ne sont pas définis, rediriger
    header('location: index.php?errorl=Missing email or password.');
    exit();
}
?>