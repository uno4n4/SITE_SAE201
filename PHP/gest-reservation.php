<?php
include 'config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
  echo "Erreur : Utilisateur non connecté.";
  exit();
}

if (isset($_POST['contenu'])) {
  $contenu = $_POST['contenu'];

  $stmt = $pdo->prepare("SELECT id FROM consigne LIMIT 1");
  $stmt->execute();
  if ($stmt->rowCount() > 0) {
    $updateStmt = $pdo->prepare("UPDATE consigne SET contenu = ? WHERE id = 1");
    $updateStmt->execute([$contenu]);
    echo "Consigne mise à jour.";
  } else {
    $insertStmt = $pdo->prepare("INSERT INTO consigne (contenu) VALUES (?)");
    $insertStmt->execute([$contenu]);
    echo "Consigne enregistrée.";
  }
  exit;  // <--- ça évite d'afficher le reste du HTML
}

if (isset($_POST["validmodif"])) {
  // Met à jour reservation_etudiant
  $stmt = $pdo->prepare("UPDATE reservation_etudiant SET Date_reservation = ?, heure_debut = ?, heure_fin = ? WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$_POST['date_reservation'], $_POST['heure_debut'], $_POST['heure_fin'], $_POST['id_resa'], $_POST['pseudo_resa']]);

  // Met à jour reservation_prof
  $stmt = $pdo->prepare("UPDATE reservation_prof SET Date_reservation = ?, heure_debut = ?, heure_fin = ? WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$_POST['date_reservation'], $_POST['heure_debut'], $_POST['heure_fin'], $_POST['id_resa'], $_POST['pseudo_resa']]);

  echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">La réservation a été modifiée</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
            </div>';
}

if (isset($_POST["accepter"])) {
  // Met à jour reservation_etudiant
  $stmt = $pdo->prepare("UPDATE reservation_etudiant SET accepte = 'oui' WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$_POST['id_resa'], $_POST['pseudo_resa']]);

  // Met à jour reservation_prof
  $stmt = $pdo->prepare("UPDATE reservation_prof SET accepte = 'oui' WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$_POST['id_resa'], $_POST['pseudo_resa']]);

  echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">La réservation a été acceptée</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
            </div>';
}

if (isset($_POST["refuser"])) {
  // Met à jour reservation_etudiant
  $stmt = $pdo->prepare("UPDATE reservation_etudiant SET accepte = 'non' WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$_POST['id_resa'], $_POST['pseudo_resa']]);

  // Met à jour reservation_prof
  $stmt = $pdo->prepare("UPDATE reservation_prof SET accepte = 'non' WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$_POST['id_resa'], $_POST['pseudo_resa']]);

  echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">La réservation a été refusée</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
            </div>';
}

if (isset($_POST["supprimer"])) {
  $idResa = $_POST['id_resa'];
  $pseudoResa = $_POST['pseudo_resa'];

  echo '<div id="msg" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
        <p>Etes-vous sûr(e) de supprimer la réservation ?</p>
        <form method="post">
            <input type="hidden" name="id_resa" value="' . htmlspecialchars($idResa) . '">
            <input type="hidden" name="pseudo_resa" value="' . htmlspecialchars($pseudoResa) . '">
            <button type="submit" name="supprime" class="btn btn-primary">Supprimer</button>
            <button type="button" class="btn btn-primary" onclick="document.getElementById(\'msg\').style.display=\'none\'">Annuler</button>
        </form>
    </div>';
}

if (isset($_POST["supprime"])) {
  $idResa = $_POST['id_resa'];
  $pseudoResa = $_POST['pseudo_resa'];

  // Prépare et exécute suppression en toute sécurité
  $stmt = $pdo->prepare("DELETE FROM reservation_etudiant WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$idResa, $pseudoResa]);

  $stmt = $pdo->prepare("DELETE FROM reservation_prof WHERE Id = ? AND Pseudo = ?");
  $stmt->execute([$idResa, $pseudoResa]);

  echo '<div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
        <p>La réservation a été supprimée</p>
        <button class="btn btn-primary" onclick="this.parentElement.style.display=\'none\'">Fermer</button>
    </div>';
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
  <script src="../JS/consigne.js" defer></script>
  <script src="../JS/reserve.js" defer></script>
  <script src="../JS/checked.js" defer></script>
  <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
  <title>Gestion des réservations</title>
</head>

<body style="background-color: #d3d2d2; overflow-x: hidden;">

  <header class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100">
      <div>
        <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">
      </div>
      <div class="d-flex align-items-center ms-auto gap-2">
       <?php
if (isset($_SESSION['utilisateur']) && isset($pdo)) {
    $nom = $_SESSION['utilisateur']['Nom'];

    // ADMIN :
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_admin WHERE nom = ?");
    $stmt->execute([$nom]);
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
              <a href="gest-comptes.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-users"></i><span class="ms-1 d-none d-sm-inline">Gestion des comptes</span>
              </a>
            </li>

            <li>
              <a href="materiel.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-camera"></i><span class="ms-1 d-none d-sm-inline">Gestion du matériel</span>
              </a>
            </li>

            <li>
              <a href="gest-reservation.php#stats" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-chart-simple"></i><span class="ms-1 d-none d-sm-inline">Statistiques</span>
              </a>
            </li>

            <li>
              <a href="gest-reservation.php#consignes" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-file-pen"></i><span class="ms-1 d-none d-sm-inline">Consigne de sécurité</span>
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!--La section permettant d'ajouter l'arrière plan de la page-->
      <section class="rounded-3 mt-2 col-9 me-1 px-2" style="background-color: rgba(254, 254, 254, 0.979);">
        <div class="container-fluid mx-lg-5 mx-0 mt-3">
          <div class="row">
            <!--Gestion des reservation, avec nom prénom photo de profil-->
            <div class="col-12">
              <div class="d-flex align-items-center flex-wrap">
                <h2 class="mt-3">Gestion des réservations</h2>
              </div>
            </div>
          </div>
          <!--Ton premier tableau-->
          <div class="row">
            <div class="col-md-10 mt-3">
              <div class="table-responsive rounded-3" style="border: 1px solid black;">
                <table class="table mb-0">
                  <!--Premiere ligne de ton tableau -->
                  <thead>
                    <tr>
                      <th colspan="5" class="p-3" style="background-color: #d9d9d9;">
                        <!-- Première ligne de ton tableau, tes boutons et tout alignés -->
                        <!-- Pour cocher décocher date -->
                        <p class="text-md-center mb-1 fw-semibold ">
                          <input class="form-check-input mx-2" type="checkbox" value="" id="flexCheckChecked">
                          Aujourd'hui, <input type="date" id="jour">
                        </p>
                        <!-- Réservation sélectionnée -->
                        <div class="row">
                          <div class="col-md-4"></div>
                          <p id="selection" class="text-center col-md-4 col-6 ms-5 ms-md-0 mb-1 fw-semibold text-dark p-2 rounded-3 mt-2 mt-sm-0"
                            style="background-color: rgb(244, 244, 244);"> Réservations sélectionnées</p>
                          <div class="col-md-4"></div>
                        </div>

                        <div class="row gap-2 mt-2 ms-md-4 mt-sm-0">
                          <form method="post">
                            <button type="button" name="signer" class="col-2 btn btn-light fw-medium">
                              <i class="bi bi-pen-fill mx-1"></i><span class="d-none d-sm-inline">Signer</span>
                            </button>
                            <button type="button" id="modifier" class="col-2 col-md-3 btn btn-light fw-medium">
                              <i class="bi bi-pencil-square mx-1"></i><span class="d-none d-sm-inline">Modifier</span>
                            </button>
                            <button type="button" name="commenter" class="col-2 col-md-3 btn btn-light fw-medium">
                              <i class="bi bi-chat-left-text mx-1"></i><span class="d-none d-sm-inline">Commenter</span>
                            </button>
                            <button type="button" name="" class="col-2 col-md-3 btn btn-light fw-medium text-danger">
                              <i class="bi bi-trash-fill mx-1"></i><span class="d-none d-sm-inline">Supprimer</span>
                          </form>
                          </button>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <!--Tout les autres lignes de ton tableau c'est toujours le meme code-->
                  <tbody>
                    <?php
$stmt = $pdo->prepare("SELECT Id, Pseudo, Nom, Prenom, Date_reservation, heure_debut, heure_fin, materiel, nom_projet 
                        FROM reservation_etudiant 
                        UNION 
                        SELECT Id, Pseudo, Nom, Prenom, Date_reservation, heure_debut, heure_fin, materiel, NULL 
                        FROM reservation_prof");
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach ($reservations as $reservation): ?>
                      <tr>
                        <td>
                          <p class="d-flex mt-3"><input class="form-check-input mx-2 reservation-checkbox" type="checkbox">Réservation de <?= htmlspecialchars($reservation['materiel']) ?></p>
                        </td>
                        <td class="mt-4">
                          <p class="d-flex p-2 mt-2 rounded fw-semibold texte" style="background-color: #aedfdd;">
                            <i class="bi bi-circle-fill mx-2" style="<?php if ($reservation['nom_projet']) {
                                                                        echo 'color: #12A19A;';
                                                                      } else {
                                                                        echo 'color: #8B1E3F;';
                                                                      } ?>"></i><?= htmlspecialchars($reservation['Nom']) ?> <?= htmlspecialchars($reservation['Prenom']) ?>
                          </p>
                        </td>
                        <form method="post">
                          <td>
                            <p class="d-flex mt-3"><i class="bi bi-clock mx-2"></i>
                              <input type="time" name="heure_debut" value="<?= htmlspecialchars($reservation['heure_debut']) ?>" disabled>
                              <span> - </span>
                              <input type="time" name="heure_fin" value="<?= htmlspecialchars($reservation['heure_fin']) ?>" disabled>
                            </p>
                          </td>
                          <td>
                            <p class="d-flex mt-3"><i class="bi bi-clock mx-2"></i><input type="date" name="date_reservation" value="<?= htmlspecialchars($reservation['Date_reservation']) ?>" readonly>
                              <input type="hidden" name="id_resa" value="<?= htmlspecialchars($reservation['Id']) ?>">
                              <input type="hidden" name="pseudo_resa" value="<?= htmlspecialchars($reservation['Pseudo']) ?>">
                              <button type="submit" id="valid" name="validmodif" class="mx-2" style="display:none;">Valider</button>
                            </p>
                          </td>
                        </form>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-light" data-bs-toggle="dropdown">
                              <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu">
                              <form method="post">
                                <input type="hidden" name="id_resa" value="<?= htmlspecialchars($reservation['Id']) ?>">
                                <input type="hidden" name="pseudo_resa" value="<?= htmlspecialchars($reservation['Pseudo']) ?>">
                                <input type="hidden" name="accepter" value="accepter">
                                <button type="submit" class="dropdown-item">Accepter</button>
                              </form>
                              <form method="post">
                                <input type="hidden" name="id_resa" value="<?= htmlspecialchars($reservation['Id']) ?>">
                                <input type="hidden" name="pseudo_resa" value="<?= htmlspecialchars($reservation['Pseudo']) ?>">
                                <input type="hidden" name="refuser" value="refuser">
                                <button type="submit" class="dropdown-item">Refuser</button>
                              </form>
                              <form method="post">
                                <input type="hidden" name="id_resa" value="<?= htmlspecialchars($reservation['Id']) ?>">
                                <input type="hidden" name="pseudo_resa" value="<?= htmlspecialchars($reservation['Pseudo']) ?>">
                                <input type="hidden" name="supprimer" value="supprimer">
                                <button type="submit" class="dropdown-item">Supprimer</button>
                              </form>
                            </ul>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <!-- Bouton  -->
          <div class="row">
            <div class="d-flex  align-items-center mt-3">
              <a href="#" class="btn btn-light me-2 boutongris"
                style="background-color: #d9d9d9; border: 1px solid black;">
                <i class="fa-solid fa-arrow-left"></i> Précédent
              </a>
              <p id="nb-pages" class="me-2"></p>
              <a href="#" class="btn btn-light boutongris" style="background-color: #d9d9d9; border: 1px solid black;">
                Suivant <i class="fa-solid fa-arrow-right"></i>
              </a>
            </div>
          </div>

          <div class=" mt-5 col-12">
            <h2 class="my-3 ms-3">Statistiques</h2>

            <div class="row gap-2 ms-3">
              <div class="col-8 col-md-4 card p-2">
                <p>Total des réservations : </p>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <h3 id="nb-reservation">
                      <?php
$stmt = $pdo->prepare("SELECT (SELECT COUNT(*) FROM reservation_etudiant) + (SELECT COUNT(*) FROM reservation_prof) AS total");
$stmt->execute();
$total = $stmt->fetchColumn();
echo $total;
?>
 réservations</h3>
                  </div>
                </div>
              </div>

              <div class="col-8 col-md-4 card p-2">
                <p>Réservation validées : </p>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <h3 id="nb-venir">
                      <?php
$stmt = $pdo->prepare("SELECT (SELECT COUNT(*) FROM reservation_etudiant WHERE accepte LIKE 'oui') + (SELECT COUNT(*) FROM reservation_prof WHERE accepte LIKE 'oui') AS total");
$stmt->execute();
$total = $stmt->fetchColumn();
echo $total;
?>
 réservations</h3>
                  </div>
                </div>
              </div>

              <div id="stats" class="col-8 col-md-2 card p-2">
                <p>Article le plus réservé : </p>
                <?php
// le matériel le plus demandé
$stmt = $pdo->prepare("SELECT materiel, COUNT(*) AS total FROM ( 
                          SELECT materiel FROM reservation_etudiant 
                          UNION ALL 
                          SELECT materiel FROM reservation_prof) AS reservations
                          GROUP BY materiel ORDER BY total DESC LIMIT 1;");
$stmt->execute();
$materielData = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupérer l'image du matériel obtenu
$stmt2 = $pdo->prepare("SELECT Image_un FROM materiel WHERE Nom = ?");
$stmt2->execute([$materielData['materiel']]);
$imageData = $stmt2->fetch(PDO::FETCH_ASSOC);

$materiel = $materielData['materiel'];
$total = $materielData['total'];
$Image_un = $imageData['Image_un'];
?>


                <div class="card-body">
                  <div class="d-flex gap-1 align-items-center">
                    <img src="../IMG/images/<?= htmlspecialchars($Image_un) ?>" id="photo-article" alt="<?= htmlspecialchars($materiel) ?>">
                    <h4 id="nom-article"><?= htmlspecialchars($materiel) ?></h4>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 rounded my-3 p-5">
              <?php
// Récupération des réservations par mois
$months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];
$reservationsParMois = array_fill(0, 12, 0);

$stmt = $pdo->prepare("
    SELECT MONTH(Date_reservation) AS mois, COUNT(*) AS total 
    FROM (
        SELECT Date_reservation FROM reservation_etudiant 
        UNION ALL 
        SELECT Date_reservation FROM reservation_prof
    ) AS reservations 
    GROUP BY mois
");
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $reservationsParMois[$row['mois'] - 1] = $row['total'];
}
?>

              <div class="row ms-3 mt-5">
                <div class="card col-11 col-md-8">
                  <div class="row align-items-center">
                    <h5 class="col-8 ms-2 mt-3">Statistiques des réservations</h5>
                  </div>

                  <div class="col-12 rounded my-3 p-4">
                    <div class="text-center">
                      <div class="d-flex gap-3 align-items-end justify-content-center" style="height: 300px;">
                        <?php foreach ($reservationsParMois as $index => $total): ?>
                          <div class="bar-vertical bg-primary rounded" style="height: <?= ($total > 0) ? ($total / max($reservationsParMois)) * 100 : 10 ?>%; width: 40px;" title="<?= $months[$index] ?>: <?= $total ?>">
                            <small class="d-block mt-2"><?= $months[$index] ?></small>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="pdf col-auto col-md-3 mt-2 mt-md-0 text-end">
                  <a href="#" download id="telecharger" class="text-black">
                    Télécharger sous format PDF <i class="fa-solid fa-file-arrow-down ms-2"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="container-fluid col-10 custom-bg-2 mt-5">
            <div class="row">
              <div class="col-12">
                <h2 id="consignes" class="consigne mb-4">Gestions des consignes de sécurité</h2>
              </div>
              <div class="col-12">
                <div class="d-flex custom-back m-0">
                  <button id="gras" class="ecris"><i class="fa-solid fa-bold"></i></button>
                  <button id="italic" class="ecris"><i class="fa-solid fa-italic"></i></button>
                  <button id="link" class="ecris"><i class="fa-solid fa-link"></i></button>
                  <input type="file" id="input-fichier" style="display: none;" onchange="ajoutfichier">
                  <button id="gauche" class="ecris"><i class="fa-solid fa-align-left"></i></button>
                  <button id="centre" class="ecris"><i class="fa-solid fa-align-center"></i></button>
                  <button id="droite" class="ecris"><i class="fa-solid fa-align-right"></i></button>
                  <button id="aligner" class="ecris"><i class="fa-solid fa-align-justify"></i></button>
                  <button id="cote-droite" class="ecris"><i class="fa-solid fa-outdent"></i></button>
                  <button id="cote-gauche" class="ecris"><i class="fa-solid fa-indent"></i></button>
                  <button id="voir" class="visu">Visualiser</button>
                </div>
                <hr id="ligne">
                <form action="gest-reservation.php" method="post">
                  <div contenteditable="true" id="zone-ecriture">
                    <p id="ecrire" name="contenu">Aa<i class="fa-solid fa-i-cursor"></i></p>
                  </div>
                  <button id="enregistrer">Enregistrer</button>
                  <div id="message"></div>
                </form>
              </div>
            </div>
          </div>
      </section>
    </div>
</body>

</html>