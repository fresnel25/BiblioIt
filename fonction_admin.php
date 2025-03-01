<?php
require("connexion_db.php");


function deconnexion()
{
    session_start();
    session_unset();
    session_destroy();
    header('location:index.php');
}
