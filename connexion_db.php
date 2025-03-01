<?php

$dbname = "library_db";
$user = "root";
$password = "";

try {
    $con = new PDO("mysql:host=localhost;dbname=$dbname;charset=utf8", $user, $password);
} catch (PDOException $e) {
    echo "Error connecting to database: " . $e->getMessage();
}
