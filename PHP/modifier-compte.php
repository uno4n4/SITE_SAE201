<?php

include('config.php');
session_start();

if(isset($_POST['Nom']) && isset($_POST['Prenom']) && isset($_POST['Role'])){
  $Nom=$_POST['Nom'];
  $Prenom=$_POST['Prenom'];
  $Email=$_POST['Email'];
  $Tel=$_POST["Tel"];
  $Role=$_POST['Role'];

  switch($Role){
    case 'admin':
      $table = 'inscription_admin';
      break;
    case 'agent':
      $table = 'inscription_agent';
      break;
    case 'etudiant':
      $table = 'inscription_eleve';
      break;
    case 'prof':
      $table = 'inscription_prof';
      break;
    default:
      die("Rôle invalide.");
      
  }

  $sql = "UPDATE INTO $table (nom, prenom, adresse_email, tel)
        VALUES (?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  if ($stmt === false){
    die("Erreur préparation : " . $conn->error); 
  }
  $stmt->bind_param("ssss", $Nom, $Prenom, $Email, $Tel);

  if($stmt->execute()){
    echo "Inscription réussie !";
  } else {
    echo "Erreur : " . $stmt->error;
  }
  $stmt->close();
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
      <div class="d-flex align-items-center ms-auto">
        <h6 class="mb-0 text-nowrap text-end">
          <?= isset($_SESSION['utilisateur']) ? htmlspecialchars($_SESSION['utilisateur']['Nom']) . ' ' . htmlspecialchars($_SESSION['utilisateur']['Prenom']) : 'Utilisateur non connecté' ?>
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
              <a href="../HTML/admin.html" class="nav-link align-middle px-0">
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
        <form class="mx-auto" method="post" action="modifier-compte.php">
            <h2>Modifier Le compte</h2>
            <div class="photo-container">
                <label for="photoUpload">
                    <img src="../IMAGE/logo-iut.png" alt="Photo de profil" id="photo">
                </label>
                <input type="file" id="photoUpload" hidden>
                <div class="button-container">
                    <button type="button" id="changer">Changer</button>
                    <button type="button" id="supp">Supprimer la photo</button>
                    </div>
            </div>
            <div class="form-grid">
                <div>
                    <label for="Nom">Nom *</label>
                    <input type="text" id="Nom" name="Nom" placeholder="<?= isset($_SESSION['utilisateur']) ? 'Nom : ' . htmlspecialchars($_SESSION['utilisateur']['Nom']) : 'Nom' ?>">
                </div>
                <div>
                    <label for="Prenom">Prénom *</label>
                    <input type="text" id="Prenom" name="Prenom"  placeholder="<?= isset($_SESSION['utilisateur']) ? 'Prénom : ' . htmlspecialchars($_SESSION['utilisateur']['Prenom']) : 'Prenom' ?>">
                </div>
                <div>
                    <label for="Email">Email *</label>
                    <input type="text" id="Email" name="Email"  placeholder="<?= isset($_SESSION['utilisateur']) ? 'Email : ' . htmlspecialchars($_SESSION['utilisateur']['Adresse_email']) : 'Adresse email' ?>">
                </div>
                <div>
                    <label for="Tel">Numéro de téléphone *</label>
                    <input type="text" id="Tel" name="Tel"  placeholder="<?= isset($_SESSION['utilisateur']) ? 'Téléphone : ' . htmlspecialchars($_SESSION['utilisateur']['Numero_tel']) : 'Telephone' ?>">
                </div>
                <div>
                    <label for="Role" class="me-3">Rôle</label>
                
                    <select class="border none">
                      <option selected>Profil</option>
                      <option value="Etu" name="Role">Étudiant</option>
                      <option value="Prof" name="Role">Professeur</option>
                      <option value="Agent" name="Role">Agent</option>
                      <option value="Admin" name="Role">Admin</option>
                    </select>
            </div>
            <div class="button-container-1">
                <button type="submit" id="submit">Enregistrer les changements</button>
                <button type="button" id="submit2">Annuler</button>
            </div>
        </form>
 
    </div>
  
    
</body>
</html>