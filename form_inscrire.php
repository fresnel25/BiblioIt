<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include 'menu.php'

    ?>
    <div class="d-flex justify-content-center">
        <div class="card w-50 mt-5">
            <div class="card-header text-center">
                Formulaire d'inscription
            </div>
            <div class="card-body">

                <form action="./utilisateur/inscription.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="nom" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Prénom</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="prenom" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary">S'incrire</button>
                </form>
            </div>
        </div>
    </div>



</body>

</html>