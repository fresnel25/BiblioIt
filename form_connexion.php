<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
</head>

<body>
    <?php
    include 'menu.php'; // S'assurer que 'menu.php' est inclus correctement
    ?>

    <div class="d-flex justify-content-center">
        <div class="card w-50 mt-5">
            <div class="card-header text-center">
                Formulaire de connexion
            </div>
            <div class="card-body">
                <!-- Formulaire de connexion -->
                <form method="POST" action="./utilisateur/connexion.php"> <!-- Spécification de la méthode POST et de l'action -->
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success">Connexion</button>
                </form>
                <?php
                // Afficher un message d'erreur si défini dans l'URL
                if (isset($_GET['errorl'])) {
                    echo "<p style='color: red;'>" . htmlspecialchars($_GET['errorl']) . "</p>";
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>