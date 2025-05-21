<?php
include('config.php');
session_start();

if (!isset($_SESSION['utilisateur'])) {
  echo "Erreur : Utilisateur non connecté.";
  exit();
}

$ancienPass = $_SESSION['utilisateur']['Mdp'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Vérification et mise à jour du mot de passe
    if (isset($_POST['update_pass'])) {
        $ancienPass = trim($_POST['old']);
        $nouveauPass = trim($_POST['new']);
        $confirmPass = trim($_POST['new1']);

        if ($nouveauPass !== $confirmPass) {
            echo <<<HTML
        <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
          <b class="mb-2 d-block">LES MOTS DE PASSES NE CORRESPONDENT PAS.</b>
          <div class="text-center mt-3">
            <a href="setting.php" class="btn btn-danger">Fermer</a>
          </div>
        </div>
        HTML;
            exit();
        }

        $pseudoActuel = $_SESSION['utilisateur']['Pseudo'];

        // Récupérer l'ancien mot de passe pour la vérification
        $sql = "SELECT Mdp FROM inscription_eleve WHERE Pseudo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $pseudoActuel);
        $stmt->execute();
        $result = $stmt->get_result();
        $utilisateur = $result->fetch_assoc();

        if (!$utilisateur || !password_verify($ancienPass, $utilisateur['Mdp'])) {
            echo <<<HTML
        <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
          <b class="mb-2 d-block">ANCIEN MOT DE PASSE INCORRECT.</b>
          <div class="text-center mt-3">
            <a href="setting.php" class="btn btn-danger">Fermer</a>
          </div>
        </div>
        HTML;
            exit();
        }

        // Mettre à jour le mot de passe
        $nouveauHash = password_hash($nouveauPass, PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE inscription_eleve SET Mdp = ? WHERE Pseudo = ?";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param("ss", $nouveauHash, $pseudoActuel);

        if ($stmt->execute()) {
            $_SESSION['utilisateur']['Mdp'] = $nouveauHash;
            header("Location: setting.php");
            exit();
        } else {
            echo "Erreur lors de la mise à jour du mot de passe : " . $stmt->error;
        }
        $stmt->close();
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
    <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
    <script src="../JS/setting.js" defer></script>
    <title>Réglages</title>
</head>
<body>

<<header class="container-fluid px-0">
        <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100">
            <div>
                <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">
            </div>
            <div class="d-flex align-items-center ms-auto gap-2">
                <?php
if (isset($_SESSION['utilisateur']) && isset($pdo)) {
    $nom = $_SESSION['utilisateur']['Nom'];

    // Étudiant
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_eleve WHERE nom = ?");
    $stmt->execute([$nom]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row['total'] > 0) {
        echo '
        <span class="rounded-circle" style="width:10px;height:10px;background-color: #12A19A;"></span>';
    } else {
        // Professeur
        $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_prof WHERE nom = ?");
        $stmt->execute([$nom]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['total'] > 0) {
            echo '
            <span class="rounded-circle" style="width:10px;height:10px;background-color: #8B1E3F;"></span>';
        } else {
            // Aucun des deux trouvés
            echo '<span class="badge d-flex align-items-center gap-2 text-dark">
            <span class="rounded-circle" style="width:10px;height:10px;background-color: gray;"></span>
            <span class="spantext">Utilisateur</span>';
        }
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
              <a href="accueil.php" class="nav-link align-middle px-0">
                <i class="fa-solid fa-house"></i><span class="ms-1 d-none d-sm-inline">Accueil</span>
              </a>
            </li>
  
            <li>
              <a href="moncompte.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-user"></i><span class="ms-1 d-none d-sm-inline">Mon compte</span>
              </a>
            </li>

            <li>
              <a href="mesemprunts.php" class="nav-link px-0 align-middle">
                <i class="fa-solid fa-box-open"></i><span class="ms-1 d-none d-sm-inline">Mes emprunts</span>
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
        <div id="form-container" class="mt-5" 
                                            data-nom ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Nom'])) ?>"
                                            data-prenom ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) ?>"
                                            data-email ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Adresse_email'])) ?>"             
                                            data-pseudo ="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Pseudo'])) ?>"></div>
      </div>   
    </div>
  </div>
  
    
</body>
</html>

