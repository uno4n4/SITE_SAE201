<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "utilisateur";

// Créer la connexion
$conn = new mysqli($host, $user, $pass, $db);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

?>