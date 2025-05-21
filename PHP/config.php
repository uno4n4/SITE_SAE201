<?php

$host = "localhost";
$user = "root";
$pass = "";
$db = "utilisateur";

try {
    // Créer la connexion avec PDO
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Définir le mode d'erreur de PDO sur exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec de la connexion : " . $e->getMessage());
}

?>
