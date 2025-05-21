<?php

include('config.php');
session_start();

if (!isset($_SESSION['utilisateur'])) {
  echo "Erreur : Utilisateur non connecté.";
  exit();
}

if (isset($_POST['modif'])) {
  // Récupération des matériaux depuis la bonne table
  $stmt = $conn->prepare("SELECT * FROM `materiel` WHERE Nom = ?");
  $stmt->bind_param("s", $_POST['materiel']);
  $stmt->execute();
  $result = $stmt->get_result();
  $materiel = $result->fetch_assoc();

  if (isset($_POST['submit'])) {
    $Nom = htmlspecialchars($_POST['Nom']);
    $Description = htmlspecialchars($_POST['description']);
    $Categorie = htmlspecialchars($_POST['categorie']);
    $Prix = htmlspecialchars($_POST['prix']);
    $Quantite = htmlspecialchars($_POST['quantite']);
    $Date_achat = htmlspecialchars($_POST['dateachat']);
    $Disponibilite = htmlspecialchars($_POST['disponibilite']);

    // Mise à jour du matériel
    $stmt = $conn->prepare("UPDATE materiel SET Nom = ?, Description_materiel = ?, categorie = ?, date_achat = ?, prix = ?, quantite = ?, disponibilite = ? WHERE Nom = ?");
    $stmt->bind_param("sssssssi", $Nom, $Description, $Categorie, $Date_achat, $Prix, $Quantite, $Disponibilite, $_POST['Nom-sauve']);
    if ($stmt->execute()) {
      echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">Le matériel a été modifié</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
            </div>';
      exit;
    } else {
      echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">Il y a eu une erreur, veuillez réessayer</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
            </div>';
    }
  }

  if (isset($_POST['supprimer_materiel'])) {
    $stmt = $conn->prepare("DELETE FROM materiel WHERE Nom = ?");
    $stmt->bind_param("s", $_POST['materiel']);
    if ($stmt->execute()) {
      echo "Le matériel a été supprimé avec succès.";
      exit;
    } else {
      echo "Une erreur s'est produite. Veuillez réessayer.";
    }
  }

  $stmt->close();
  $conn->close();
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

      <!-- Main content -->
      <div class="col py-3 custom-bg d-flex justify-content-lg-start">
        <form class="mx-auto" method="post" action="modifier-materiel.php">
          <input type="hidden" name="Nom-sauve" value="<?= htmlspecialchars($materiel['Nom']) ?>">
          <input type="hidden" name="Description-sauve" value="<?= htmlspecialchars($materiel['Description_materiel']) ?>">
          <input type="hidden" name="categorie-sauve" value="<?= htmlspecialchars($materiel['categorie']) ?>">
          <input type="hidden" name="date_achat-sauve" value="<?= htmlspecialchars($materiel['date_achat']) ?>">
          <input type="hidden" name="Prix-sauve" value="<?= htmlspecialchars($materiel['prix']) ?>">
          <input type="hidden" name="Quantite-sauve" value="<?= htmlspecialchars($materiel['quantite']) ?>">
          <input type="hidden" name="dispo-sauve" value="<?= htmlspecialchars($materiel['disponibilite']) ?>">
          <h2>Modifier le matériel</h2>
          <div class="photo-container">
            <img src="../IMG/images/<?= isset($materiel) ? htmlspecialchars($materiel['Image_un']) : 'logo-iut.png' ?>" alt="Photo de profil" id="photo">
          </div>
          <div class="form-grid">
            <div>
              <label for="Nom">Nom *</label>
              <input type="text" name="Nom" value="<?= isset($materiel) ? htmlspecialchars($materiel['Nom']) : '' ?>">
            </div>
            <div>
              <label for="description">Description *</label>
              <input type="text" id="description" name="description" value="<?= isset($materiel) ? htmlspecialchars($materiel['Description_materiel']) : '' ?>">
            </div>
            <div>
              <label for="categorie">Catégorie *</label>
              <input type="text" id="categorie" name="categorie" value="<?= isset($materiel) ? htmlspecialchars($materiel['categorie']) : '' ?>">
            </div>
            <div>
              <label for="date-achat">Date d'achat *</label>
              <input type="text" id="date-achat" name="dateachat" value="<?= isset($materiel) ? htmlspecialchars($materiel['date_achat']) : '' ?>">
            </div>
            <div>
              <label for="prix">Prix *</label>
              <input type="text" id="prix" name="prix" value="<?= isset($materiel) ? htmlspecialchars($materiel['prix']) : '' ?>">
            </div>
            <div>
              <label for="quantite">Quantite *</label>
              <input type="number" min="0" id="quantite" name="quantite" value="<?= isset($materiel) ? htmlspecialchars($materiel['quantite']) : '' ?>">
            </div>
            <div>
              <label for="disponibilite" class="me-3">Disponibilité</label>

              <select name="disponibilite" class="border none">
                <option value="disponible" <?= (isset($materiel) && $materiel['disponibilite'] === 'disponible') ? 'selected' : '' ?>>Disponible</option>
                <option value="indisponible" <?= (isset($materiel) && $materiel['disponibilite'] === 'indisponible') ? 'selected' : '' ?>>Indisponible</option>
              </select>

            </div>
            <div class="button-container-1">
              <button type="submit" id="submit" name="submit">Enregistrer les changements</button>
              <button type="button" id="submit2" onclick="window.location.href='../HTML/materiel.html'">Annuler</button>
            </div>
            <button class="btn btn-danger text-white justify-content-center" type="submit" name="supprimer_materiel">Supprimer le materiel</button>
            <div id="container-supp"></div>
        </form>

      </div>


</body>

</html>