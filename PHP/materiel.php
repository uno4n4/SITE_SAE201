<?php

include 'config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

$tables = ['inscription_eleve', 'inscription_prof', 'inscription_agent', 'inscription_admin'];

if (isset($_POST["modifvalid"])) {
    $stmt = $pdo->prepare("UPDATE materiel SET Nom = ?, date_achat = ?, prix = ?, categorie = ? WHERE Nom = ?");
    $stmt->execute([
        $_POST['Nommodif'],
        $_POST['date_achatmodif'],
        $_POST['prixmodif'],
        $_POST['categoriemodif'],
        $_POST['materiel']
    ]);

    echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">La réservation a été modifiée </p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
          </div>';
}

if (isset($_POST["supprimer"])) {
    $materiel = $_POST['materiel'];

    echo '<div id="msg" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
        <p>Es-tu sûre de vouloir supprimer ce matériel ?</p>
        <form method="post">
            <input type="hidden" name="materiel" value="' . htmlspecialchars($materiel) . '">
            <button type="submit" name="supprime" class="btn btn-danger">Supprimer</button>
            <button type="button" class="btn btn-secondary" onclick="document.getElementById(\'msg\').style.display=\'none\'">Annuler</button>
        </form>
    </div>';
}

if (isset($_POST["supprime"])) {
    $stmt = $pdo->prepare("DELETE FROM materiel WHERE Nom = ?");
    $stmt->execute([$_POST['materiel']]);

    echo '<div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
        <p>Le matériel a été supprimé </p>
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
    <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
    <script src="../JS/checked.js" defer></script>
    <script src="../JS/reserve.js" defer></script>
    <title>Gestion du matériel</title>

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
                <div class="col-12">
                    <div class="d-flex align-items-center flex-wrap">
                        <h2 class="mt-3 ms-3">Gestion du matériel</h2>
                    </div>

                    <div class="row ms-2 mb-5">
                        <div class="bg-light col-5 col-md-2 p-3 pb-1 m-2">
                            <div class="d-flex justify-content-between align-items-baseline flex-wrap">
                                <i class="fa-solid fa-display fa-2xl p-2"></i>
                                <h4>
                                    <?php
                                    $stmt = $pdo->prepare("SELECT (SELECT COUNT(*) FROM reservation_etudiant) + (SELECT COUNT(*) FROM reservation_prof) AS total;");
                                    $stmt->execute();
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $total = $row['total'];
                                    echo $total;
                                    ?>

                                </h4>
                                <i class="fa-solid fa-ellipsis-vertical"></i>
                            </div>
                            <p>Réservations effectuées</p>
                        </div>
                        <div class="bg-light col-5 col-md-2 p-3 pb-1 m-2 text-center">
                            <a href="./ajouter-materiel.php">
                                <h3>Ajouter un matériel</h3>
                                <h3>+</h3>
                            </a>
                        </div>
                    </div>

                    <div class="row table-responsive-md ">
                        <table
                            class="col-8 mx-2 table table-bordered table-hover table-light border-dark rounded overflow-hidden">
                            <thead class="text-center">
                                <tr>
                                    <th>Produit</th>
                                    <th>Catégorie</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                <?php
                                $stmt = $pdo->prepare("SELECT * FROM materiel");
                                $stmt->execute();
                                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="ligne-materiel">
                                        <form method="post">
                                        <td>
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                                                <img src="../IMG/images/<?= htmlspecialchars($user['Image_un']) ?>" alt="<?= htmlspecialchars($user['Nom']) ?>"
                                                    class="img-fluid rounded" style="max-height: 100px; width: auto;">
                                                <div>
                                                    <input type="text" name="Nommodif" style="width:80%; border: none;" class="mb-1 fw-semibold champ-input" value="<?= htmlspecialchars($user['Nom']) ?>" disabled>
                                                        <div>Date d'achat: <input type="text" name="date_achatmodif" style="width:50%; border: none;" class="mb-1 champ-input" value="<?= htmlspecialchars($user['date_achat']) ?>" disabled></div>
                                                        <div>Prix: <input type="number" name="prixmodif" style="width:80%; border: none;" class="mb-0 champ-input" value="<?= htmlspecialchars($user['prix']) ?>" disabled></div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                                <span class="badge bg-dark text-light p-2 rounded">
                                                    <i class="me-2 fa-solid fa-camera"></i>
                                                    <input class="champ-input" name="categoriemodif" style="width:80%; border: none; color:white; background-color: black;" type="text" value="<?= htmlspecialchars($user['categorie']) ?>" disabled>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <form method="post">
                                                    <input type="hidden" name="materiel" value="<?= htmlspecialchars($user['Nom']) ?>">
                                                    <button type="submit" name="supprimer" class="btn">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn modifier-btn">
                                                    <i class="fa-solid fa-pen-to-square fs-5"></i>
                                                </button>
                                            <button type="submit" id="valid" name="modifvalid" class="mx-2">Valider</button>
                                        </td>
                                        </form>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>

                    <!-- Bouton  -->
                    <div class="row">
                        <div class="d-flex  align-items-center mt-3">
                            <a href="#" class="btn btn-light me-2 boutongris"
                                style="background-color: #d9d9d9; border: 1px solid black;">
                                <i class="fa-solid fa-arrow-left"></i> Précédent
                            </a>
                            <p id="nb-pages" class="me-2"></p>
                            <a href="#" class="btn btn-light boutongris"
                                style="background-color: #d9d9d9; border: 1px solid black;">
                                Suivant <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</body>

</html>