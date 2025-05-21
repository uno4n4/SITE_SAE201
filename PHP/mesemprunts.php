<?php

include '../PHP/config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

$pseudo  = $_SESSION['utilisateur']['Pseudo'];
if (isset($_SESSION['utilisateur']['Td'])) {
    $stmt = $pdo->prepare("SELECT * FROM reservation_etudiant WHERE Pseudo = ?");
} else {
    $stmt = $pdo->prepare("SELECT * FROM reservation_prof WHERE Pseudo = ?");
}

$stmt->execute([$pseudo]);

// Utilisation de fetchAll pour récupérer les résultats
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <script src="../JS/profile.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
    <title>Mon compte</title>

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
            <div class="col-2 px-sm-2 px-0 d-flex flex-column min-vh-100">
                <div
                    class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white flex-grow-1">
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start">

                        <li class="nav-item">
                            <a href="accueil.php" class="nav-link align-middle px-0 mt-2 text-dark">
                                <i class="fa-solid fa-house"></i><span class="ms-1 d-none d-sm-inline">Accueil</span>
                            </a>
                        </li>

                        <li>
                            <a href="moncompte.php" class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-user"></i><span class="ms-1 d-none d-sm-inline">Mon compte</span>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-0 align-middle">
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

            <!--La section permettant d'ajouter l'arrière plan de la page-->
            <section class="rounded-3 mt-2 col-9 me-1 px-2" style="background-color: rgba(254, 254, 254, 0.979);">
                <div class="col-12">
                    <h3>Réservations</h3>
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <?php foreach ($reservations as $reserve): ?>
    <?php
    $stmt = $pdo->prepare("SELECT Image_un FROM materiel WHERE Nom = ?");
    $stmt->execute([$reserve['materiel']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>

                                <div class="rounded bg-light border text-center p-3 m-2">
                                    <div class="d-flex justify-content-baseline">Vous avez effectué une réservation
                                        pour le <span class="text-black ms-1"><?= htmlspecialchars($reserve['Date_reservation']) ?></span></div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div><img src="../IMG/images/<?= htmlspecialchars($row['Image_un']) ?>" style="height:auto; width:100px;" alt="<?= htmlspecialchars($reserve['materiel']) ?>"></div>
                                        <div>
                                            <div><?= htmlspecialchars($reserve['materiel']) ?></div>
                                            <div>De: <?= htmlspecialchars($reserve['heure_debut']) ?> à <?= htmlspecialchars($reserve['heure_fin']) ?></div>
                                            <div>Participants: <?= htmlspecialchars($reserve['participants']) ?></div>
                                        </div>
                                        <a class='icon-link link-dark' href='#'>
                                            Télécharger le PDF
                                            <img src='../IMG/google-docs.png' alt='google-docs'>
                                        </a>
                                    </div>
                                    <div></div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
</body>

</html>