<?php

include ('config.php');
session_start();

if(isset($_POST['Nom']) && isset($_POST['Prenom']) && isset($_POST['Role'])){
  $Nom=$_POST['Nom'];
  $Prenom=$_POST['Prenom'];
  $Email=$_POST['Email'];
  $Role=$_POST['Role'];
  $Pseudo = strtolower($Nom . '.' . $Prenom);
  $Mdp=password_hash($_POST['Mdp'], PASSWORD_DEFAULT);
  $Statut = 'accepté';

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

  $sql = "INSERT INTO $table (nom, prenom, adresse_email, pseudo, mdp, statut)
        VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  if ($stmt === false){
    die("Erreur préparation : " . $conn->error); 
  }
  $stmt->bind_param("ssssss", $Nom, $Prenom, $Email, $Pseudo, $Mdp, $Statut);

  if($stmt->execute()){
    echo "Inscription réussie !";
  } else {
    echo "Erreur : " . $stmt->error;
  }
  $stmt->close();
}
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
    <title>Gestion des comptes</title>
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

          <div class="col py-3 custom-bg1 d-flex justify-content-lg-start">
            <div class="d-flex flex-column flex-lg-column align-items-start gap-3">
                <div class="d-flex flex-column gap-2 align-items-start">
                  <div class="d-flex justify-content-between align-items-center gap-5">
                    <h2>Ajout d'un compte :</h2>
                    <a href="gest-comptes.php" class="btn btn-retour">Retour en arrière</a>
                  </div>
                  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-2">
                    <form method="post" action="ajout-compte.php">
                        <div class="row">
                            <label for="Prenom" class="col-sm-2 col-form-label">Prénom * :</label>
                            <div class="col">
                                <input name="Prenom" type="text" class="form-control" placeholder="Ex : Clara">
                            </div>
                            <label for="Nom" class="col-sm-2 col-form-label">Nom * :</label>
                            <div class="col">
                                <input name="Nom" type="text" class="form-control" placeholder="Ex : domingues">
                            </div>
                        </div>
                        <div class="row">
                            <label for="Email" class="col-sm-2 col-form-label mt-4">Email * :</label>
                            <div class="col mt-4">
                                <input name="Email" type="email" class="form-control border-dark" placeholder="Ex : clara.domingues@edu.univ-eiffel.fr">
                        </div>
                        <div class="row">
                            <legend class="col-form-label col-sm-2 pt-0 mt-4">Rôles :</legend>
                            <div class="col-sm-10 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="radio" name="Role" value="etudiant">
                                    <label class="form-check-label" for="etudiant">
                                    Etudiant
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="radio" name="Role" value="prof">
                                    <label class="form-check-label" for="prof">
                                    Professeur
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="radio" name="Role" value="agent">
                                    <label class="form-check-label" for="agent">
                                    Agent
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input border-dark" type="radio" name="Role" value="admin">
                                    <label class="form-check-label" for="admin">
                                    Admin
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Mdp" class="col-sm-2 col-form-label mt-3">Mot de passe (temporaire) :</label>
                            <div class="col-sm-10 mt-4">
                                <input name="Mdp" type="password" class="form-control border-dark" id="inputPassword">
                            </div>
                        </div>
                        <p> Le pseudo sera : Nom.Prénom </p>
                        <div class="form-group row">
                            <div class="col-sm-10 mt-5">
                                <button type="submit" class="btn btn-custom mx-5">Créer le compte</button>
                            </div>
                        </div>
                    </form>
    
                </div>
            </div>
        </div>

    
</body>
</html>