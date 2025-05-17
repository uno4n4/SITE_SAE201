<?php

include 'config.php';
session_start();


$tables = ['inscription_eleve', 'inscription_prof', 'inscription_agent', 'inscription_admin'];

foreach ($tables as $table) {
  $stmt = $conn->prepare("SELECT * FROM `$table` WHERE statut = 'en attente'");

  if (isset($_POST['accept'])) {
    $Nom = $_POST['Nom'];
    $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'accepté' WHERE Nom = ?");
    $stmt->bind_param("s", $Nom);
    $stmt->execute();
  }

  if (isset($_POST['refuse'])) {
    $Nom = $_POST['Nom'];
    $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'refusé' WHERE Nom = ?");
    $stmt->bind_param("s", $Nom);
    $stmt->execute();
  }
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
  <script src="../JS/kebab.js" defer></script>
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
            <?php
            if (isset($_SESSION['utilisateur']) && isset($conn)) {
                $nom = $_SESSION['utilisateur']['Nom'];

                // Étudiant
                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM inscription_admin WHERE nom = ?");
                $stmt->bind_param("s", $nom);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row['total'] > 0) {
                    echo '
                        <span class="rounded-circle" style="width:10px;height:10px;background-color: #2F2A85;"></span>';
                } else {
                        // Aucun des deux trouvés
                        echo '<span class="badge d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle" style="width:10px;height:10px;background-color: gray;"></span>
                            ';
                    }
                  }
            ?>
            <h6 class="mb-0 text-nowrap text-end">
                <?= isset($_SESSION['utilisateur']) ? strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) : 'Utilisateur non connecté' ?>
            </h6>
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
              <a href="gest-reservation.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-calendar-days"></i><span class="ms-1 d-none d-sm-inline">Gestion des réservations</span>
              </a>
            </li>

            <li>
              <a href="#" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-users"></i><span class="ms-1 d-none d-sm-inline">Gestion des comptes</span>
              </a>
            </li>

            <li>
              <a href="materiel.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-camera"></i><span class="ms-1 d-none d-sm-inline">Gestion du matériel</span>
              </a>
            </li>

            <li>
              <a href="gest-reservation.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-chart-simple"></i><span class="ms-1 d-none d-sm-inline">Statistiques</span>
              </a>
            </li>

            <li>
              <a href="gest-reservation.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-file-pen"></i><span class="ms-1 d-none d-sm-inline">Consigne de sécurité</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <!--APPRO-->
      <div class="container">
        <div class="row">
          <div class="col-md-9 py-3 custom-bg1">
            <div class="d-flex flex-column align-items-start gap-3">
              <div class="d-flex flex-column gap-2 align-items-start">
                <div class="d-flex justify-content-between align-items-center gap-5">
                  <h2>Approbation des comptes</h2>
                  <h6>
                    <?php
                    $total = 0;
                    foreach ($tables as $table) {
                      $query = "SELECT COUNT(*) as count FROM `$table` WHERE statut = 'en attente'";
                      $result = $conn->query($query);
                      if ($result) {
                        $row = $result->fetch_assoc();
                        $total += (int)$row['count'];
                      }
                    }
                    echo $total . " compte(s) en attente";
                    ?>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-2">
                  <!-- Partie gauche : Filtrer par -->
                  <div class="d-flex align-items-center mb-3 mb-md-0">
                    <label for="filtre" class="me-3">Filtrer par :</label>

                    <select class="custom-select">
                      <option selected>Profil</option>
                      <option value="Etu">Étudiant</option>
                      <option value="Prof">Professeur</option>
                    </select>

                    <select class="custom-select">
                      <option selected>Classes</option>
                      <option value="MMI1">MMI 1</option>
                      <option value="MMI2">MMI 2</option>
                      <option value="MMI3">MMI 3</option>
                    </select>

                    <select class="custom-select">
                      <option selected>TP</option>
                      <option value="TPA">TP A</option>
                      <option value="TPB">TP B</option>
                      <option value="TPC">TP C</option>
                    </select>

                    <button type="submit" class="btn btn-custom mx-5">Confirmer</button>
                  </div>

                  <div class="d-flex align-items-center">
                    <!-- Texte cwsv -->
                    <div class="selection me-3 mx-3" id="select">O compte(s) sélectionnés</div>
                    <div id="kebabs-icon" style="display: none; cursor: pointer;">
                      <i class="fa-solid fa-ellipsis-vertical me-2"></i>
                    </div>
                    <div id="content-accept"></div>
                  </div>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-4">
                  <!-- Carte 1 -->
                  <?php foreach ($tables as $table): ?>
                    <?php
                    $result = $conn->query("SELECT * FROM `$table` WHERE statut = 'en attente'");
                    while ($user = $result->fetch_assoc()):
                      $color = '';
                    if($table === 'inscription_eleve'){
                      $color = '#12A19A';
                    } elseif ($table === 'inscription_prof'){
                      $color = '#8B1E3F';
                    } else {
                      $color = '#6c757d';
                    }
                    ?>
                      <div class="card-wrapper">
                        <form action="gest-comptes.php" method="post">
                          <div class="card custom-card">
                            <div class="card-top d-flex justify-content-between align-items-center mx-3 mt-2 position-relative">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <input type="checkbox" name="choix[]" class="appro-checkbox">
                                </div>
                              </div>
                              <span class="icon-kebab">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                              </span>
                              <div class="kebabs-menu"></div>
                            </div>
                          <div class="d-flex align-items-center gap-1 ms-1">
                            <!-- Pastille -->
                            <span class="rounded-circle" style="width:10px;height:10px;background-color: <?= $color ?>;"></span>
                            <!-- Nom et prénom -->
                            <h6 class="text-nowrap mb-0" id="nom-prenom">
                              <?= strtoupper(htmlspecialchars($user['Nom'])) . ' ' . htmlspecialchars($user['Prenom']) ?>
                            </h6>
                          </div>
                            <p class="text-center" id="classe">
                              <?= isset($user['Formation']) ? htmlspecialchars($user['Formation']) . ' ' : '' ?>
                              <?= isset($user['Td']) ? htmlspecialchars($user['Td']) . ' ' : '' ?>
                              <?= isset($user['Tp']) ? htmlspecialchars($user['Tp']) : '' ?>
                            </p>
                            <div class="card-body">
                              <hr class="me-2">
                              <div class="d-flex justify-content-between gap-4">
                                <input type="hidden" name="Nom" value="<?= htmlspecialchars($user['Nom']) ?>">
                                <button class="card-link text-light border-0 rounded btn-acces mb-2 ms-2" id="accepter1" name="accepter1">
                                  <i class="fa-solid fa-circle-check"></i>
                                </button>
                                <?php
                                if (isset($_POST["accepter1"])) {
                                  $Nom = $_POST["Nom"];
                                  $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'accepté' WHERE Nom = ?");
                                  $stmt->bind_param("s", $Nom);
                                  $stmt->execute();
                                }
                                ?>
                                <button class="card-link text-light border-0 rounded btn-acces mb-2 me-2" id="refuser1" name="refuser1">
                                  <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                                <?php
                                if (isset($_POST["refuser1"])) {
                                  $Nom = $_POST["Nom"];
                                  $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'refusé' WHERE Nom = ?");
                                  $stmt->bind_param("s", $Nom);
                                  $stmt->execute();
                                }
                                ?>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    <?php endwhile; ?>
                  <?php endforeach; ?>
                </div>

                <div class="pagination-wrapper d-flex justify-content-end align-items-center gap-3 mt-auto w-100 custom-page">
                  <a href="#" class="button-class" id="avant-page"><i class="fa-solid fa-arrow-left"></i>Précédent</a>
                  <p id="nb-pages"></p>
                  <a href="#" class="button-class" id="autre-page">Suivant <i class="fa-solid fa-arrow-right"></i></a>
                </div>

                <!-- GESTION DES COMPTES -->
                <div class="mt-5 d-flex justify-content-between align-items-center gap-5">
                  <h2>Gestions des comptes</h2>
                  <h6>
                    <?php
                    $total = 0;
                    foreach ($tables as $table) {
                      $query = "SELECT COUNT(*) as count FROM `$table` WHERE statut = 'accepté'";
                      $result = $conn->query($query);
                      if ($result) {
                        $row = $result->fetch_assoc();
                        $total += (int)$row['count'];
                      }
                    }
                    echo $total . " comptes accepté";
                    ?>
                  </h6>
                </div>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-2">
                  <!-- Partie gauche : Filtrer par -->
                  <form method="get" action="gest-comptes.php">
                    <div class="d-flex align-items-center mb-3 mb-md-0">
                      <label for="filtre" class="me-3">Filtrer par :</label>

                      <select class="custom-select" name="profil">
                        <option selected>Profil</option>
                        <option value="Etu">Étudiant</option>
                        <option value="Prof">Professeur</option>
                      </select>

                      <select class="custom-select" name="classe">
                        <option selected>Classes</option>
                        <option value="MMI1">MMI 1</option>
                        <option value="MMI2">MMI 2</option>
                        <option value="MMI3">MMI 3</option>
                      </select>

                      <select class="custom-select" name="tp">
                        <option selected>TP</option>
                        <option value="TPA">TP A</option>
                        <option value="TPB">TP B</option>
                        <option value="TPC">TP C</option>
                      </select>

                      <input type="submit" class="btn btn-custom mx-5" value="Confirmer"></input>
                    </div>
                  </form>

                  <!-- Partie droite : cwsv et ajouter un compte -->
                  <div class="d-flex align-items-center">
                    <!-- Texte cwsv -->
                    <div class="selection me-3 mx-3" id="selection">O compte(s) sélectionnés</div>
                    <!-- Ligne verticale -->
                    <div class="ligne-verticale d-none d-md-block mx-3"></div>
                    <!-- Bouton Ajouter un compte -->
                    <a href="ajout-compte.php" id="ajouter" class="btn border rounded bg-white p-2">+ Ajouter un compte</a>
                  </div>
                </div>

                <?php 

                $perpage = 5;

                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $perpage;

                $offset = max(0, $offset);

                $query = "SELECT COUNT(*) AS total FROM `$table` WHERE statut = 'accepté'";
                $result = $conn->query($query);
                $row = $result->fetch_assoc();
                $totalUsers = $row['total'];

                $totalPages = ceil($totalUsers / $perpage);
                $query = "SELECT * FROM `$table` WHERE statut = 'accepté' LIMIT $perpage OFFSET $offset";
                $result = $conn->query($query);

                ?>
                <div class="d-flex flex-wrap justify-content-center gap-4">
                  <?php foreach ($tables as $table): ?>
                    <?php
                    $query = "SELECT * FROM `$table` WHERE statut = 'accepté' LIMIT $perpage OFFSET $offset";
                    $result = $conn->query($query);
                    while ($user = $result->fetch_assoc()):
                      $color = '';
                    if($table === 'inscription_eleve'){
                      $color = '#12A19A';
                    } elseif ($table === 'inscription_prof'){
                      $color = '#8B1E3F';
                    } elseif ($table === 'inscription_agent'){
                      $color = '#F4A261';
                    } elseif ($table === 'inscription_admin'){
                      $color = '#2F2A85';
                    } else {
                      $color = '#6c757d';
                    }
                    ?>
                      <div class="card-wrapper">
                        <form action="gest-comptes.php" method="post">
                          <div class="card custom-card">
                            <div class="card-top d-flex justify-content-between align-items-center mx-3 mt-2 position-relative">
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <input type="checkbox" name="choix[]" class="compte-checkbox">
                                </div>
                              </div>
                              <span class="kebab-icon">
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                              </span>
                              <?php
                              if (isset($_POST['Pseudo'])) {

                                $pseudo = $_POST['Pseudo'];

                                $stmt = $conn->prepare("SELECT * FROM `$table` WHERE Pseudo = ?");
                                $stmt->bind_param("s", $pseudo); // Lie le pseudo à la requête
                                $stmt->execute();
                                $result = $stmt->get_result();
                              }
                              ?>

                              <!-- Vérifie si $utilisateur est défini avant d'utiliser ses informations -->
                              <?php if (isset($user) && $user !== null): ?>
                                <div class="kebab-menu" data-pseudo="<?= $user['Pseudo'] ?>"></div>
                              <?php else: ?>
                                <div class="kebab-menu">Utilisateur introuvable</div>
                              <?php endif; ?>

                            </div>
                            <div class="d-flex justify-content-center align-items-center gap-2">
                              <!-- Pastille -->
                              <span class="rounded-circle" style="width:10px;height:10px;background-color: <?= $color ?>;"></span>
                              <!-- Nom et prénom -->
                              <h6 class="text-nowrap mb-0" id="nom-prenom">
                                <?= strtoupper(htmlspecialchars($user['Nom'])) . ' ' . htmlspecialchars($user['Prenom']) ?>
                              </h6>
                            </div>
                            <p class="text-center" id="classe">
                              <?= isset($user['Formation']) ? htmlspecialchars($user['Formation']) . ' ' : '' ?>
                              <?= isset($user['Td']) ? htmlspecialchars($user['Td']) . ' ' : '' ?>
                              <?= isset($user['Tp']) ? htmlspecialchars($user['Tp']) : '' ?>
                            </p>
                            <div class="card-body p-2">
                              <div class="d-flex justify-content-between gap-4">
                                <p id="derniere-reservation">Dernière réservation</p>
                                <p id="date-reser">
                                  <?php
                                  if (isset($user['Td'])) {
                                    $stmt = $conn->prepare("SELECT max(Date_reservation) AS last_date FROM reservation_etudiant WHERE Pseudo = ?");
                                    $stmt->bind_param("s", $user['Pseudo']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    echo $row['last_date'];
                                  } else {
                                    $stmt = $conn->prepare("SELECT max(Date_reservation) AS last_date FROM reservation_prof WHERE Pseudo = ?");
                                    $stmt->bind_param("s", $user['Pseudo']);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $row = $result->fetch_assoc();
                                    echo $row['last_date'];
                                  }

                                  ?>
                                </p>
                              </div>
                              <p class="text-left card-text"> <strong>Email : </strong> <?= htmlspecialchars($user['Adresse_email']) ?></p>
                              <p class="text-left card-text"> <strong>Numéro de téléphone : </strong> <?= htmlspecialchars($user['Numero_tel']) ?></p>
                              <p class="text-left card-text"> <strong>Pseudo : </strong> <?= htmlspecialchars($user['Pseudo']) ?></p>
                              <p class="text-left card-text">
                                <?php if ($table === 'inscription_eleve'): ?>
                                  <strong>Numéro étudiant :</strong> <?= htmlspecialchars($user['Num_etudiant'] ?? '') ?>
                                <?php endif; ?>
                              </p>
                            </div>
                          </div>
                        </form>
                      </div>
                    <?php endwhile; ?>
                  <?php endforeach; ?>
                </div>

                <div class="pagination-wrapper d-flex justify-content-end align-items-center gap-3 mt-auto w-100 custom-page">
                  <a href="?page=<?= max(1, $page - 1) ?>" class="button-class" id="avant-page"><i class="fa-solid fa-arrow-left"></i>Précédent</a>
                  <p id="nb-pages"><?= $page ?> / <?= $totalPages ?></p>
                  <a href="?page=<?= min($totalPages, $page + 1)?>" class="button-class" id="autre-page">Suivant <i class="fa-solid fa-arrow-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


</body>

</html>