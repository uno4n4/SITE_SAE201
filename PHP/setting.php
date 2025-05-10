<?php
include('config.php');
session_start();

if (!isset($_SESSION['utilisateur'])) {
  echo "Erreur : Utilisateur non connecté.";
  exit();
}

$pseudoActuel = $_SESSION['utilisateur']['Pseudo'];
$ancienPass = $_SESSION['utilisateur']['Mdp'];

if($_SERVER["REQUEST_METHOD"] === "POST"){
  if(isset($_POST['update_pseudo'])){
    $nouveauPseudo = trim($_POST['Pseudo']);

    $sql = "UPDATE inscription_eleve SET Pseudo = ? WHERE Pseudo = ?";
    $stmt = $conn->prepare($sql);

    if(!$stmt){
      die("Erreur de préparation : " . $conn->error);
    }

    $stmt->bind_param("ss", $nouveauPseudo, $pseudoActuel);

    if($stmt->execute()){
      $_SESSION['utilisateur']['Pseudo'] = $nouveauPseudo;
      header("Location: admin.php");
      exit();
    } else {
      echo "Erreur lors de la mise à jour : " . $stmt->error;
    }
    $stmt->close();
  }
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
  if(isset($_POST['update_pass'])){
    $ancienPass = trim($_POST['old']);
    $nouveauPass = trim($_POST['new']);
    $confirmPass = trim($_POST['new1']);

    if($nouveauPass !== $confirmPass){
      echo "Les mots de passe ne correspondent pas.";
      exit();
    }

    $pseudoActuel = $_SESSION['utilisateur']['Pseudo'];

    $sql = "SELECT Mdp FROM inscription_eleve WHERE Pseudo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pseudoActuel);
    $stmt->execute();
    $result = $stmt->get_result();
    $utlisateur = $result->fetch_assoc();

    if(!$utlisateur || !password_verify($ancienPass, $utlisateur['Mdp'])){
      echo "Ancien mot de passe incorrect";
      exit();
    }

    $nouveauHash = password_hash($nouveauPass, PASSWORD_DEFAULT);

    $sqlUpdate = "UPDATE inscription_eleve SET Mdp = ? WHERE Pseudo = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("ss", $nouveauHash, $pseudoActuel);

    if($stmt->execute()){
      $_SESSION['utilisateur']['Mdp'] = $nouveauHash;
      header("Location: setting.php");
      exit();
    } else {
      echo "Erreur lors de la mise à jour : " . $stmt->errror;
    }
    $stmt->close();
  }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
    <script src="../JS/setting.js" defer></script>
    <title>Réglages</title>
</head>
<body>

<header class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100">
      <div>
        <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">
      </div>
      <div class="d-flex align-items-center ms-auto gap-2">
        <h6 class="mb-0 text-nowrap text-end">
          <?= isset($_SESSION['utilisateur']) ? strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) : 'Utilisateur non connecté' ?>
        </h6>
        <img class="card-img-top img-card" src="../IMAGE/logo-iut.png" alt="Image de profil carte" id="img-profil">
      </div>
    </div>
  </header> 

  <div class="container-fluid">
    <div class="row flex-nowrap">
      <!-- Sidebar -->
      <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 d-flex flex-column min-vh-100">
        <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white flex-grow-1">
          <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start">
  
            <li class="nav-item">
              <a href="admin.php" class="nav-link align-middle px-0">
                <i class="fa-solid fa-house"></i><span class="ms-1 d-none d-sm-inline">Tableau de bord</span>
              </a>
            </li>
  
            <li>
              <a href="../HTML/reservation.html" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-calendar-days"></i><span class="ms-1 d-none d-sm-inline">Gestion des réservations</span>
              </a>
            </li>
  
            <li>
              <a href="../HTML/gest-comptes.html" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-users"></i><span class="ms-1 d-none d-sm-inline">Gestion des comptes</span>
              </a>
            </li>
  
            <li>
              <a href="../HTML/materiel.html" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-camera"></i><span class="ms-1 d-none d-sm-inline">Gestion du matériel</span>
              </a>
            </li>
  
            <li>
              <a href="../HTML/statistiques.html" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-chart-simple"></i><span class="ms-1 d-none d-sm-inline">Statistiques</span>
              </a>
            </li>
  
            <li>
              <a href="../HTML/consignes.html" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-file-pen"></i><span class="ms-1 d-none d-sm-inline">Consigne de sécurité</span>
              </a>
            </li>
          </ul>
            <div class="mt-auto w-100">
              <a href="../HTML/setting.html" class="nav-link align-middle px-0">
                <i class="fa-solid fa-cogs"></i><span class="ms-1 d-none d-sm-inline">Réglages</span>
              </a>
            </div>
        </div>
      </div>
  
      <!-- Main content -->
      <div class="col py-3 custom-bg d-flex justify-content-lg-start">
        <div class="d-flex flex-column flex-lg-column align-items-start gap-3">
          <h2 class="m-0">Réglages du compte</h2>
          <div id="setting" class="p-2 mx-0 my-0 mt-0">
            <div class="d-flex flex-column gap-2 align-items-start">
              <button type="button" id="reglage" class="btn">
                <i class="fa-solid fa-user"></i> Réglages du profil
              </button>
            </div>
          </div>
        </div>
        <div id="form-container" class="mt-5" 
                                            data-nom ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Nom'])) ?>"
                                            data-prenom ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) ?>"
                                            data-email ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Adresse_email'])) ?>"
                                            data-numetu ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Num_etudiant'])) ?>"
                                            data-pseudo ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Pseudo'])) ?>"></div>
      </div>   
    </div>
  </div>
  
    
</body>
</html>