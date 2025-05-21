<?php

include 'config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
  echo "Erreur : Utilisateur non connecté.";
  exit();
}

$tables = ['inscription_eleve', 'inscription_prof', 'inscription_agent', 'inscription_admin'];

foreach ($tables as $table) {
    if (isset($_POST['noms'])) {
        // Récupérer les noms envoyés
        $noms = explode(',', $_POST['noms']);
        $action = isset($_POST['accepter']) ? 'accepté' : (isset($_POST['refuser']) ? 'refusé' : '');

        // Mettre à jour le statut de chaque utilisateur
        foreach ($noms as $nom) {
            $nom = trim($nom);
            
            // Préparer la requête PDO pour la mise à jour
            $sql = "UPDATE `$table` SET Statut = :statut WHERE Nom = :nom";
            $stmt = $pdo->prepare($sql);
            
            // Lier les paramètres
            $stmt->bindParam(':statut', $action, PDO::PARAM_STR);
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            
            // Exécuter la requête
            $stmt->execute();
        }
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
if (isset($_SESSION['utilisateur']) && isset($pdo)) {
    $nom = $_SESSION['utilisateur']['Nom'];

    // ADMIN
    $sql = "SELECT COUNT(*) as total FROM inscription_admin WHERE nom = :nom";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

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
    $sql = "SELECT COUNT(*) as count FROM `$table` WHERE statut = 'en attente'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
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
    $sql = "SELECT * FROM `$table` WHERE statut = 'en attente'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)):
        $color = '';
        if ($table === 'inscription_eleve') {
            $color = '#12A19A';
        } elseif ($table === 'inscription_prof') {
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
                            </div>
                          <div class="d-flex align-items-center justify-content-center gap-1 ms-1">
                            <!-- Pastille -->
                            <span class="rounded-circle" style="width:10px;height:10px;background-color: <?= $color ?>;"></span>
                            <!-- Nom et prénom -->
                            <h6 class="text-nowrap mb-0 text-center" class="nom-prenom">
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
    $stmt = $pdo->prepare("UPDATE `$table` SET Statut = 'accepté' WHERE Nom = :Nom");
    $stmt->bindParam(':Nom', $Nom, PDO::PARAM_STR);
    if($stmt->execute()){
      echo <<<HTML
                <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
                    <b class="mb-2 d-block">L'utilisateur a été accepté avec succès !</b>
                    <div class="text-center mt-3">
                        <a href="gest-comptes.php" class="btn btn-success">Fermer</a>
                    </div>
                </div>
            HTML;
        } else {
            echo "Erreur : " . $stmtInsert->errorInfo()[2];
        }
    };
?>

                                <button class="card-link text-light border-0 rounded btn-acces mb-2 me-2" id="refuser1" name="refuser1">
                                  <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                                <?php
if (isset($_POST["refuser1"])) {
    $Nom = $_POST["Nom"];
    $stmt = $pdo->prepare("UPDATE `$table` SET Statut = 'refusé' WHERE Nom = :Nom");
    $stmt->bindParam(':Nom', $Nom, PDO::PARAM_STR);
    if($stmt->execute()){
      echo <<<HTML
                <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
                    <b class="mb-2 d-block">L'utilisateur a été refusé'</b>
                    <div class="text-center mt-3">
                        <a href="gest-comptes.php" class="btn btn-danger">Fermer</a>
                    </div>
                </div>
            HTML;
        } else {
            echo "Erreur : " . $stmtInsert->errorInfo()[2];
        }
    };

?>

                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    <?php endwhile; ?>
                  <?php endforeach; ?>
                </div>

                <!-- GESTION DES COMPTES -->
                <div class="mt-5 d-flex justify-content-between align-items-center gap-5">
                  <h2>Gestions des comptes</h2>
                  <h6>
                    <?php
$total = 0;
foreach ($tables as $table) {
    $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM `$table` WHERE statut = 'accepté'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $total += (int)$row['count'];
    }
}
echo $total . " comptes acceptés";
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
                    <!-- Ligne verticale -->
                    <div class="ligne-verticale d-none d-md-block mx-3"></div>
                    <!-- Bouton Ajouter un compte -->
                    <a href="ajout-compte.php" id="ajouter" class="btn border rounded bg-white p-2">+ Ajouter un compte</a>
                  </div>
                </div>
                <div class="d-flex flex-wrap justify-content-center gap-4">
  <?php foreach ($tables as $table): ?>
    <?php
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE statut = 'accepté'");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result && count($result) > 0):
        foreach ($result as $user):
            // Couleur selon le type d'utilisateur
            $color = match($table) {
                'inscription_eleve' => '#12A19A',
                'inscription_prof' => '#8B1E3F',
                'inscription_agent' => '#F4A261',
                'inscription_admin' => '#2F2A85',
                default => '#6c757d',
            };
    ?>

      <div class="card-wrapper">
        <div class="card custom-card">
          <div class="card-top d-flex justify-content-end align-items-start mx-3 mt-2 position-relative">
            <span class="kebab-icon">
              <i class="fa-solid fa-ellipsis-vertical justify-content-end"></i>
            </span>
            <div class="kebab-menu" data-pseudo="<?= htmlspecialchars($user['Pseudo']) ?>"></div>
          </div>

          <div class="d-flex justify-content-center align-items-center gap-2">
            <span class="rounded-circle" style="width:10px;height:10px;background-color: <?= $color ?>;"></span>
            <h6 class="text-nowrap mb-0 nom-prenom">
              <?= strtoupper(htmlspecialchars($user['Nom'])) . ' ' . htmlspecialchars($user['Prenom']) ?>
            </h6>
          </div>

          <p class="text-center classe">
            <?= isset($user['Formation']) ? htmlspecialchars($user['Formation']) . ' ' : '' ?>
            <?= isset($user['Td']) ? htmlspecialchars($user['Td']) . ' ' : '' ?>
            <?= isset($user['Tp']) ? htmlspecialchars($user['Tp']) : '' ?>
          </p>

          <div class="card-body p-2">
            <div class="d-flex justify-content-between gap-4">
              <p class="derniere-reservation">Dernière réservation</p>
              <p class="date-reser">
                <?php
$reservation_table = isset($user['Td']) ? 'reservation_etudiant' : 'reservation_prof';
$stmt = $pdo->prepare("SELECT MAX(Date_reservation) AS last_date FROM $reservation_table WHERE Pseudo = ?");
$stmt->execute([$user['Pseudo']]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo $row['last_date'] ?? '—';
?>

              </p>
            </div>

            <p class="text-left card-text"><strong>Email :</strong> <?= htmlspecialchars($user['Adresse_email']) ?></p>
            <p class="text-left card-text"><strong>Numéro de téléphone :</strong> <?= htmlspecialchars($user['Numero_tel']) ?></p>
            <p class="text-left card-text"><strong>Pseudo :</strong> <?= htmlspecialchars($user['Pseudo']) ?></p>

            <?php
if ($table === 'inscription_eleve'):

    // Récupérer le numéro étudiant via PDO
    $stmt = $pdo->prepare("SELECT Num_etudiant FROM $table WHERE Pseudo = ?");
    $stmt->execute([$user['Pseudo']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $num_etudiant = $result['Num_etudiant'] ?? '';
?>
    <p class="text-left card-text"><strong>Numéro étudiant :</strong> <?= htmlspecialchars($num_etudiant) ?></p>
<?php endif; ?>

          </div>
        </div>
      </div>
    <?php
      endforeach;
    endif;
    ?>
  <?php endforeach; ?>
</div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>

</html>