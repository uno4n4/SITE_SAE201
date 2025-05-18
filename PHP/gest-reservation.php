<?php
include('config.php');

if (isset($_POST['contenu'])) {
  $contenu = $_POST['contenu'];

  $check = $conn->query("SELECT id FROM consigne LIMIT 1");
  if ($check->num_rows > 0) {
    $stmt = $conn->prepare("UPDATE consigne SET contenu = ? WHERE id = 1");
    $stmt->bind_param("s", $contenu);
    $stmt->execute();
    $stmt->close();
    echo "Consigne mise à jour.";
  } else {
    $stmt = $conn->prepare("INSERT INTO consigne (contenu) VALUES (?)");
    $stmt->bind_param("s", $contenu);
    $stmt->execute();
    $stmt->close();
    echo "Consigne enregistrée.";
  }
  $conn->close();
  exit;  // <--- ça évite d'afficher le reste du HTML
}

if (isset($_POST["accepter"])) {
  // Met à jour reservation_etudiant
  $stmt = $conn->prepare("UPDATE reservation_etudiant SET accepte = 'oui' WHERE Id = ? AND Pseudo = ?");
  $stmt->bind_param("is", $_POST['id_resa'], $_POST['pseudo_resa']);
  $stmt->execute();

  // Met à jour reservation_prof
  $stmt = $conn->prepare("UPDATE reservation_prof SET accepte = 'oui' WHERE Id = ? AND Pseudo = ?");
  $stmt->bind_param("is", $_POST['id_resa'], $_POST['pseudo_resa']);
  $stmt->execute();

  echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">Réservation acceptée confirmée</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
            </div>';
}
if (isset($_POST["refuser"])) {
  // Met à jour reservation_etudiant
  $stmt = $conn->prepare("UPDATE reservation_etudiant SET accepte = 'non' WHERE Id = ? AND Pseudo = ?");
  $stmt->bind_param("is", $_POST['id_resa'], $_POST['pseudo_resa']);
  $stmt->execute();

  // Met à jour reservation_prof
  $stmt = $conn->prepare("UPDATE reservation_prof SET accepte = 'non' WHERE Id = ? AND Pseudo = ?");
  $stmt->bind_param("is", $_POST['id_resa'], $_POST['pseudo_resa']);
  $stmt->execute();
  echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">Réservation refusée confirmée</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
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
          <div class="mt-auto w-100">
            <a href="../HTML/setting.html" class="nav-link align-middle px-0">
              <i class="fa-solid fa-cogs"></i><span class="ms-1 d-none d-sm-inline">Réglages</span>
            </a>
          </div>
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
              <h5 class="mt-3">3 Réservations en attente</h5>
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
                          <input class="form-check-input mx-2" type="checkbox" value="" id="flexCheckChecked" checked>
                          Aujourd'hui, 11 Mai 2025
                        </p>
                        <!-- Réservation sélectionnée -->
                        <div class="row">
                          <div class="col-md-4"></div>
                          <p class="text-center col-md-4 col-6 ms-5 ms-md-0 mb-1 fw-semibold text-dark p-2 rounded-3 mt-2 mt-sm-0"
                            style="background-color: rgb(244, 244, 244);">2 Réservations sélectionnées</p>
                          <div class="col-md-4"></div>
                        </div>

                        <div class="row gap-2 mt-2 ms-md-4 mt-sm-0">
                          <button type="button" class="col-2 btn btn-light fw-medium">
                            <i class="bi bi-pen-fill mx-1"></i><span class="d-none d-sm-inline">Signer</span>
                          </button>
                          <button type="button" class="col-2 col-md-3 btn btn-light fw-medium">
                            <i class="bi bi-pencil-square mx-1"></i><span class="d-none d-sm-inline">Modifier</span>
                          </button>
                          <button type="button" class="col-2 col-md-3 btn btn-light fw-medium">
                            <i class="bi bi-chat-left-text mx-1"></i><span class="d-none d-sm-inline">Commenter</span>
                          </button>
                          <button type="button" class="col-2 col-md-3 btn btn-light fw-medium text-danger">
                            <i class="bi bi-trash-fill mx-1"></i><span class="d-none d-sm-inline">Supprimer</span>
                          </button>
                        </div>
                      </th>
                    </tr>
                  </thead>
                  <!--Tout les autres lignes de ton tableau c'est toujours le meme code-->
                  <tbody>
                    <?php
                    $result = $conn->query("SELECT Id, Pseudo, Nom, Prenom, Date_reservation, heure_debut, heure_fin, materiel FROM reservation_etudiant UNION SELECT Id, Pseudo, Nom, Prenom, Date_reservation, heure_debut, heure_fin, materiel FROM reservation_prof");
                    $reservations = $result->fetch_all(MYSQLI_ASSOC);
                    ?>
                    <?php foreach ($reservations as $reservation): ?>
                      <tr>
                        <td>
                          <p class="mt-3"><input class="form-check-input mx-2" type="checkbox" checked>Réservation de <?= htmlspecialchars($reservation['materiel']) ?></p>
                        </td>
                        <td class="mt-4">
                          <p class="p-2 mt-2 rounded fw-semibold texte" style="background-color: #aedfdd;">
                            <i class="bi bi-circle-fill text-success mx-2"></i><?= htmlspecialchars($reservation['Nom']) ?> <?= htmlspecialchars($reservation['Prenom']) ?>
                          </p>
                        </td>
                        <td>
                          <p class="mt-3"><i class="bi bi-clock mx-2"></i><?= htmlspecialchars($reservation['heure_debut']) ?> - <?= htmlspecialchars($reservation['heure_fin']) ?></p>
                        </td>
                        <td>
                          <p class="mt-3"><i class="bi bi-clock mx-2"></i><?= htmlspecialchars($reservation['Date_reservation']) ?></p>
                        </td>
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
                      $stmt = $conn->prepare("SELECT (SELECT COUNT(*) FROM reservation_etudiant) + (SELECT COUNT(*) FROM reservation_prof) AS total;");
                      $stmt->execute();
                      $stmt->bind_result($total);
                      $stmt->fetch();
                      $stmt->close();
                      echo $total;
                      ?> réservations</h3>
                  </div>
                </div>
              </div>

              <div class="col-8 col-md-4 card p-2">
                <p>Réservation validées : </p>
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <h3 id="nb-venir">
                      <?php
                      $stmt = $conn->prepare("SELECT (SELECT COUNT(*) FROM reservation_etudiant WHERE accepte LIKE 'oui') + (SELECT COUNT(*) FROM reservation_prof WHERE accepte LIKE 'oui') AS total;");
                      $stmt->execute();
                      $stmt->bind_result($total);
                      $stmt->fetch();
                      $stmt->close();
                      echo $total;
                      ?> réservations</h3>
                  </div>
                </div>
              </div>

              <div id="stats" class="col-8 col-md-2 card p-2">
                <p>Article le plus réservé : </p>
                <?php
                // le matériel le plus demandé
                $stmt = $conn->prepare("SELECT materiel, COUNT(*) AS total FROM ( SELECT materiel FROM reservation_etudiant UNION ALL SELECT materiel FROM reservation_prof) AS reservations
                      GROUP BY materiel ORDER BY total DESC LIMIT 1;");
                $stmt->execute();
                $stmt->bind_result($materiel, $total);
                $stmt->fetch();
                $stmt->close();

                // Récupérer l'image du matériel obtenu
                $stmt2 = $conn->prepare("SELECT Image_un FROM materiel WHERE Nom = ?");
                $stmt2->bind_param("s", $materiel);
                $stmt2->execute();
                $stmt2->bind_result($Image_un);
                $stmt2->fetch();
                $stmt2->close();
                ?>

                <div class="card-body">
                  <div class="d-flex gap-1 align-items-center">
                    <img src="../IMG/images/<?= htmlspecialchars($Image_un) ?>" id="photo-article" alt="<?= htmlspecialchars($materiel) ?>">
                    <h4 id="nom-article"><?= htmlspecialchars($materiel) ?></h4>
                  </div>
                </div>
              </div>
            </div>

            <div class="row ms-3 mt-5">
              <div class="card col-11 col-md-8">
                <div class="row">
                  <h5 class="col-8 ms-2 mt-3">Statistiques des réservations</h5>
                  <select class="col-3 p-1 mt-2">
                    <option selected>Profil</option>
                    <option value="Etu">Étudiants</option>
                    <option value="Prof">Professeurs</option>
                  </select>
                </div>

                <div class="col-12 rounded my-3 p-5">
                  <?php
                  $moisannee = ['Jan', 'Fev', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aout', 'Sept', 'Oct', 'Nov', 'Dec'];
                  $stmt = $conn->prepare("SELECT MONTH(Date_reservation) AS mois, COUNT(*) AS total FROM (SELECT Date_reservation FROM reservation_etudiant UNION ALL SELECT Date_reservation FROM reservation_prof) AS reservations GROUP BY mois");
                  $stmt->execute();
                  $result = $stmt->get_result();
                  $rows = $result->fetch_all(MYSQLI_ASSOC);

                  $stmt->close();
                  ?>
                  <div class="text-center">
                    <h3>Réservations par Mois</h3>
                    <div class="d-flex align-items-end gap-3">
                      <?php foreach ($rows as $row): ?>
                        <div style="text-align:center;">
                          <div class="bar-vertical" style="height: <?= $row['total'] ?>px;"></div>
                          <small><?= $moisannee[$row['mois'] - 1] ?></small>
                          <small><?= $row['total'] ?></small>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  </div>
                </div>
            </div>

            <div class="pdf col-auto col-md-3 mt-2 mt-md-0">
              <a href="#" download="" id="telecharger" class="text-black ">
                Télécharger sous format PDF <i class="fa-solid fa-file-arrow-down ms-2"></i>
              </a>
            </div>
          </div>
        </div>
    </div>

    <div class="d-flex justify-content-between custom-bg-2 mt-5">
      <h2 id="consignes" class="consigne">Gestions des consignes de sécurité</h2>
      <div class="container">
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
    </section>
  </div>
</body>

</html>