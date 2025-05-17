<?php

include('config.php');
session_start();

$tables = ['materiel'];
$tableOrigine = $_POST['tableOrigine'] ?? '';
$roles = [
    'inscription_eleve' => 'Étudiant',
    'inscription_prof' => 'Professeur',
    'inscription_admin' => 'Admin',
    'inscription_agent' => 'Agent'
];


if(isset($_GET['disponibilite'])){
  $disponibilite = $_GET['disponibilite'];

  // Chercher le materiel dans les tables
  $found = false;  // Variable pour savoir si le materiel a été trouvé
  foreach($tables as $table){
    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE disponibilite = ?");
    $stmt->bind_param("s", $disponibilite);
    $stmt->execute();
    $result = $stmt->get_result();
    if($utilisateur = $result->fetch_assoc()){
      $tableOrigine = $table;  // Table d'origine trouvée
      $found = true;  // Utilisateur trouvé
      break;
    }
  }

  if(!$found) {
    die("Le materiel n'a pas été trouvé dans la base de données.");
  }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Pseudo'])){
  $Nom = $_POST['Nom'];
  $Prenom = $_POST['Prenom'];
  $Anniv = $_POST['Anniv'];
  $Email = $_POST['Email'];
  $Tel = $_POST["Tel"];
  $Adresse = $_POST['Adresse'];
  $Pseudo = $_POST['Pseudo'];
  $tableOrigine = $_POST['tableOrigine'];
  if (!in_array($tableOrigine, $tables)) {
    die("Table d'origine invalide.");
  }

  // Récupération de l'utilisateur depuis la bonne table
  $stmt = $conn->prepare("SELECT * FROM `$tableOrigine` WHERE Pseudo = ?");
  $stmt->bind_param("s", $Pseudo);
  $stmt->execute();
  $result = $stmt->get_result();
  $utilisateur = $result->fetch_assoc();

  if (!$utilisateur) {
      die("Utilisateur introuvable pour mise à jour.");
  }
  $Statut = 'accepté';
  $Role = $_POST['Role'];
  $Mdp = $utilisateur['Mdp'];


  // Définir la nouvelle table en fonction du rôle
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
        $table = $tableOrigine;
          break;
  }

  // Vérifier si la table d'origine est définie avant de supprimer
  if ($tableOrigine && $table !== $tableOrigine) {
    // Supprimer l'utilisateur de la table d'origine
    $stmtDelete = $conn->prepare("DELETE FROM `$tableOrigine` WHERE Pseudo = ?");
    $stmtDelete->bind_param("s", $Pseudo);
    if (!$stmtDelete->execute()) {
      die("Erreur de suppression dans la table d'origine.");
    }

    // Ajouter l'utilisateur dans la nouvelle table
    $sql = "INSERT INTO `$table` (nom, prenom, date_naissance, adresse_email, numero_tel, adresse, pseudo, mdp, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sql);
    $stmtInsert->bind_param("sssssssss", $Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Pseudo, $Mdp, $Statut);
    if($stmtInsert->execute()){
      echo "Le rôle a été mis à jour et l'utilisateur déplacé avec succès !";
    } else {
      echo "Erreur : " . $stmtInsert->error;
    }

    $stmtDelete->close();
    $stmtInsert->close();
  } elseif ($tableOrigine && $table === $tableOrigine) {
    // Cas : rôle inchangé → mise à jour dans la même table
    $sql = "UPDATE `$tableOrigine` SET nom = ?, prenom = ?, date_naissance = ?, adresse_email = ?, numero_tel = ?, adresse = ?, statut = ? WHERE pseudo = ?";
    $stmtUpdate = $conn->prepare($sql);
    $stmtUpdate->bind_param("ssssssss", $Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Statut, $Pseudo);
    if($stmtUpdate->execute()){
        echo "Informations mises à jour avec succès !";
    } else {
        echo "Erreur lors de la mise à jour : " . $stmtUpdate->error;
    }
    $stmtUpdate->close();
} else {
    die("Table d'origine invalide ou non définie.");
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_compte'])) {
    $Pseudo = $_POST['Pseudo'];
    $tableOrigine = $_POST['tableOrigine'];

    if (!in_array($tableOrigine, $tables)) {
        die("Table d'origine invalide.");
    }

    // Supprimer l'utilisateur
    $stmt = $conn->prepare("DELETE FROM `$tableOrigine` WHERE Pseudo = ?");
    $stmt->bind_param("s", $Pseudo);

    if ($stmt->execute()) {
        echo "Le compte a été supprimé avec succès.";
        // Optionnel : rediriger ou afficher un message HTML
        // header("Location: gest-comptes.php?success=suppression");
        exit;
    } else {
        echo "Erreur lors de la suppression du compte : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    exit;
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
          <input type="hidden" name="Pseudo" value="<?= $utilisateur['Pseudo'] ?>">
          <input type="hidden" name="tableOrigine" value="<?= htmlspecialchars($tableOrigine) ?>">
          <input type="hidden" name="Anniv" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Date_naissance']) : '' ?>">
          <input type="hidden" name="Adresse" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Adresse']) : '' ?>">
            <h2>Modifier Le Matriel</h2>
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
                    <input type="text" name="Nom" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Nom']) : '' ?>">
                </div>
                <div>
                    <label for="Categorie">Catégorie *</label>
                    <input type="text" id="Categorie" name="Categorie"  value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Prenom']) : '' ?>">
                </div>
                <div>
                    <label for="date_achat">Date d'achat *</label>
                    <input type="text" id="date_achat" name="date_achat" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Adresse_email']) : '' ?>">
                </div>
                <div>
                    <label for="Prix">Prix *</label>
                    <input type="text" id="Prix" name="Prix" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Numero_tel']) : '' ?>">
                </div>
                <div>
                    <label for="Disponibilite" class="me-3">Disponibilite</label>
                
                    <select class="border none" name="Disponibilite">
                      <option selected><?= isset($utilisateur) && isset($roles[$tableOrigine]) ? $roles[$tableOrigine] : '' ?></option>
                      <option value="etudiant" name="Disponibilite">Indisponible</option>
                      <option value="prof" name="Disponibilite">Disponible</option>
                    </select>
            </div>
            <div class="button-container-1">
                <button type="submit" id="submit">Enregistrer les changements</button>
                <button type="button" id="submit2">Annuler</button>
            </div>
            <button class="btn btn-danger text-white justify-content-center" type="button" id="supprimer-compte">Supprimer le materiel</button>
            <div id="container-supp"></div>
        </form>
 
    </div>
  
    
</body>
</html>