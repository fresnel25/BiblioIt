<?php
// Démarrer la session pour pouvoir utiliser $_SESSION
session_start();

// Connexion à la base de données (assurez-vous que $con est défini)
include_once '../connexion_db.php';

// Vérification des champs POST
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Récupération des informations du formulaire
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Utilisation de requêtes préparées avec PDO pour éviter les injections SQL
    $query = "SELECT id, email, password FROM utilisateurs WHERE email = :email";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    // Vérification si un utilisateur est trouvé
    if ($stmt->rowCount() == 0) {
        $m = "Veuillez entrer un email et un mot de passe corrects.";
        header('location: ../form_connexion.php?errorl=' . urlencode($m));
        exit();
    } else {
        // Si l'utilisateur est trouvé, vérifier le mot de passe
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $row['password'])) {
            // Stocker les informations de l'utilisateur dans la session
            $_SESSION['email'] = $row['email'];
            $_SESSION['id'] = $row['id'];

            // Vérifier si l'utilisateur est un admin (id = 1)
            if ($row['id'] == 1) {
                header('location: ../admin.php');
            } else {
                // Redirection vers index.php avec un message de connexion réussie
                header('location: ../index.php?success=connecte');
            }
            exit();
        } else {
            $m = "Mot de passe incorrect.";
            header('location: ../form_connexion.php?errorl=' . urlencode($m));
            exit();
        }
    }
} else {
    // Si les champs POST ne sont pas définis, rediriger avec un message d'erreur
    header('location: ../index.php?errorl=Veuillez remplir tous les champs.');
    exit();
}
