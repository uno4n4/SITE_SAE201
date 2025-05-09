<?php 

include 'config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
  echo "Erreur : Utilisateur non connecté.";
  exit();
}



$tables = ['inscription_eleve', 'inscription_prof', 'inscription_agent', 'inscription_admin'];
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
    <script src="../JS/profile.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
    <title>Profil de l'admin</title>
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

    <div class="d-flex align-items-center flex-nowrap px-3 py-2">
      <div class="me-auto">
        <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">

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
              <a href="#" class="nav-link align-middle px-0">
                <i class="fa-solid fa-house"></i><span class="ms-1 d-none d-sm-inline">Tableau de bord</span>
              </a>
            </li>
  
            <li>
              <a href="../HTML/gest-reservation.html" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-calendar-days"></i><span class="ms-1 d-none d-sm-inline">Gestion des réservations</span>
              </a>
            </li>
  
            <li>
              <a href="gest-comptes.php" class="nav-link px-0 align-middle">
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
            <a href="setting.php" class="nav-link align-middle px-0">
              <i class="fa-solid fa-cogs"></i><span class="ms-1 d-none d-sm-inline">Réglages</span>
            </a>
          </div>
        </div>
      </div>
 
      <div class="col py-3 custom-bg">
        <div class="d-flex flex-column flex-lg-column align-items-start gap-3">
          <div class="d-flex flex-column gap-2 align-items-start">
            <form>
              <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center" id="notif">
                <div class="w-100 w-md-auto mb-3 mb-md-0 d-md-flex align-items-center justify-content-start">
                  <div class="d-flex flex-column flex-md-row w-100">
                    <label for="filtre" class="me-3 mb-2 mb-md-0 align-self-start">Filtrer par :</label>
                    <div class="filters-container d-flex flex-column flex-md-row align-items-md-center">
                      <select class="custom-select mb-2 mb-md-0 me-md-2">
                        <option selected>Mois</option>
                        <option value="Jan">Janvier</option>
                        <option value="Fevr">Février</option>
                        <option value="Mar">Mars</option>
                        <option value="Avril">Avril</option>
                        <option value="Mai">Mai</option>
                        <option value="Juin">Juin</option>
                        <option value="Juillet">Juillet</option>
                        <option value="Août">Août</option>
                        <option value="Sept">Septembre</option>
                        <option value="Oct">Octobre</option>
                        <option value="Nov">Novembre</option>
                        <option value="Dec">Décembre</option>
                      </select>
    
                      <select class="custom-select mb-2 mb-md-0 me-md-2">
                        <option selected>Types</option>
                        <option value="Mat">Matériels</option>
                        <option value="Sall">Salles</option>
                      </select>
    
                      <select class="custom-select mb-2 mb-md-0">
                        <option selected>Profiles</option>
                        <option value="Etu">Etudiants</option>
                        <option value="Prof">Professeurs</option>
                      </select>
    
                      <button type="submit" class="btn btn-custom mx-3">Confirmer</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
    
            <div class="container">
              <div class="row">
                <!-- CALENDRIER -->
                <div class="col-12 col-lg-6 d-flex flex-co">
                  <div id="container-calendrier">
                    <div class="calendar-header d-flex justify-content-between align-items-center">
                      <button class="prev-month border-0 fs-4 bgcustom"><i class="fa-solid fa-arrow-left"></i></button>
                      <h2 id="month-year">Avril 2025</h2>
                      <button class="after-month border-0 fs-4 bgcustom"><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                    <table class="calendar ms-auto text-end w-100">
                      <thead>
                        <tr>
                          <th>Lun</th>
                          <th>Mar</th>
                          <th>Mer</th>
                          <th>Jeu</th>
                          <th>Ven</th>
                        </tr>
                      </thead>
                      <tbody id="calendar-days"></tbody>
                    </table>
                  </div>
                </div>
    
                <!-- RESERVATION -->
                <div class="col-12 col-lg-6 d-flex flex-column">
                  <!-- Première carte -->
                  <div class="card custom-card mb-4">
                    <p>Souhaite effectuer une réservation pour le : <strong id="jour"></strong></p>
                    <p id="nom"></p>
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="button-group d-flex">
                          <a href="#" class="card-link vert" id="accepter">Accepter</a>
                          <a href="#" class="card-link rouge" id="refuser">Refuser</a>
                        </div>
                        <a href="#" class="card-link text-dark ms-auto px-5 modifierl" id="modifier-reser">Modifier la réservation</a>
                      </div>
                    </div>
                  </div>
    
                  <!-- Deuxième carte -->
                  <div class="card custom-card">
                    <p>Autre réservation pour le : <strong id="jour2"></strong></p>
                    <p id="nom2"></p>
                    <div class="card-body">
                      <div class="d-flex align-items-center">
                        <div class="button-group d-flex">
                          <a href="#" class="card-link vert" id="accepter2">Accepter</a>
                          <a href="#" class="card-link rouge" id="refuser2">Refuser</a>
                        </div>
                        <a href="#" class="card-link text-dark ms-auto px-5 modifierl" id="modifier-reser2">Modifier la réservation</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    
            <div class="container">
              <div class="row g-5 justify-content-between">
              <!-- GERER MATERIEL -->
                <div class="col-12 col-lg-6 mb-lg-0">
                  <div class="materiel d-flex align-items-center justify-content-between mb-2" id="gest-materiel">
                    <h2>Gérer le matériel</h2>
                    <a href="#" id="voir"><small class="text-muted me-3">Voir plus</small></a>
                  </div>
                  <a href="#" id="ajouter" class=" d-block text-end fs-4 text-dark">Ajouter du matériel</a>
    
                  <div class="card w-100 custom-card mt-3">
                    <img src="../IMAGE/logo-iut.png" id="img-produit">
                    <h4 id="produit">Caméra untel</h4>
                    <div class="card-body">
                      <p id="description">Description</p>
                      <div class="d-flex align-items-center">
                        <div class="button-group d-flex">
                          <a href="#" class="card-link vert" id="dispo">Disponible</a>
                          <a href="#" class="card-link rouge" id="indispo">Indisponible</a>
                        </div>
                        <a href="#" class="card-link text-dark ms-auto px-5 modifierl" id="modifier-mat">Modifier le matériel</a>
                      </div>
                    </div>
                  </div>
                </div>
    
                <!-- APPROUVER -->
                <div class="col-12 col-lg-6 d-flex flex-column justify-content-between">
                  <div class="materiel d-flex align-items-center justify-content-between mb-4">
                    <h2 class="mb-0 flex-shrink-1 me-3">Approuver des utilisateurs</h2>
                    <a href="gest-comptes.php" id="voir"><small class="text-muted text-nowrap me-3">Voir plus</small></a>
                  </div>
                  <?php foreach($tables as $table): ?>
                  <?php 
                  $result = $conn->query("SELECT * FROM `$table` WHERE statut = 'en attente'");
                  while ($user = $result->fetch_assoc()):
                  ?>
                  <form method="post" action="admin.php">
                  <div class="d-flex align-items-center gap-2">
                    <img src="../IMAGE/logo-iut.png" id="pp">
                    <br><p id="Nom"> <?= htmlspecialchars($user['Nom']) ?></p>
                    <br><p id="Prenom"><?= htmlspecialchars($user['Prenom']) ?></p>
                    <br><p id="Numetu"><?= htmlspecialchars($user['Num_etudiant']) ?></p>
                  </div>
                  <?php endwhile; ?>
                  <?php endforeach; ?>
                    <div class="d-flex gap-3 justify-content-end">
                      <input type="hidden" name="Nom">
                      <button class="card-link text-light border-0 rounded btn-acces" id="accepter1" name="accepter1" >
                        <i class="fa-solid fa-circle-check"></i>
                      </button>
                      <?php 
                      if (isset($_POST["accepter1"])){
                      $Nom = $_POST["Nom"];
                      $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'accepté' WHERE Nom = ?");
                      $stmt->bind_param("s", $Nom);
                      $stmt->execute();
                      }
                      ?>
                      <button class="card-link text-light border-0 rounded btn-acces" id="refuser1" name="refuser1">
                        <i class="fa-solid fa-circle-xmark"></i>
                      </button>
                      <?php 
                      if (isset($_POST["refuser1"])){
                      $Nom = $_POST["Nom"];
                      $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'refusé' WHERE Nom = ?");
                      $stmt->bind_param("s", $Nom);
                      $stmt->execute();
                      }
                      ?>
                    </div>
                  </form>
                  <?php endwhile; ?>
                  <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>

    
        
</body>
</html>