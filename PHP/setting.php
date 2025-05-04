<?php
include('config.php');
session_start();

// Assurez-vous que l'utilisateur est connecté avant d'afficher ou de modifier ses données
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $pseudo = $user['pseudo'];
    $nom = $user['nom'];
    $prenom = $user['prenom'];
    $email = $user['adresse_email'];
    $tel = $user['numero_tel'];
    $userId = $user['id'];  // Assurez-vous que l'ID de l'utilisateur est dans la session

} else {
    // Redirection si l'utilisateur n'est pas connecté
    header("Location: setting.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les nouvelles valeurs du formulaire
    $nom = $_POST['Nom'];
    $prenom = $_POST['Prenom'];
    $email = $_POST['Email'];
    $tel = $_POST['Tel'];
    $pseudo = $_POST['Pseudo'];

    // Validation de l'email (optionnel mais recommandé)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email invalide.";
        exit();
    }

    // Vérifier si le mot de passe a été changé
    if (!empty($_POST['old']) && !empty($_POST['new']) && !empty($_POST['new1'])) {
        $oldMdp = $_POST['old'];
        $newMdp = $_POST['new'];
        $newMdpConfirm = $_POST['new1'];

        if ($newMdp === $newMdpConfirm) {
            // Changer le mot de passe si l'ancien est correct
            if (password_verify($oldMdp, $user['mdp'])) {
                $Mdp = password_hash($newMdp, PASSWORD_DEFAULT);
            } else {
                echo "Ancien mot de passe incorrect.";
                exit();
            }
        } else {
            echo "Les nouveaux mots de passe ne correspondent pas.";
            exit();
        }
    }

    // Mettre à jour les informations dans la base de données
    $sql = "UPDATE inscription_eleve SET nom = ?, prenom = ?, adresse_email = ?, numero_tel = ?, pseudo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $nom, $prenom, $email, $tel, $pseudo, $userId);

    if ($stmt->execute()) {
        echo "Profil mis à jour avec succès !";

        // Actualiser la session si nécessaire
        $_SESSION['user']['nom'] = $nom;
        $_SESSION['user']['prenom'] = $prenom;
        $_SESSION['user']['adresse_email'] = $email;
        $_SESSION['user']['numero_tel'] = $tel;
        $_SESSION['user']['pseudo'] = $pseudo;

        // Mettre à jour le mot de passe en session si changé
        if (isset($Mdp)) {
            $_SESSION['user']['mdp'] = $Mdp;
        }

        // Rediriger après la mise à jour
        header("Location: profil.php");
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
  } else {
    echo "Utilisateur non connecté.";
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
    <div class="d-flex align-items-center flex-nowrap px-3 py-2">
      <div class="me-auto">
        <img src="../IMAGE/logo-iut.png" class="img-fluid float-left" id="logo-iut-head" alt="Logo IUT">
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
        <div id="form-container" class="mt-5"></div>
      </div>   
    </div>
  </div>
  
    
</body>
</html>