<?php

include '../PHP/config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

$tables = ['inscription_eleve', 'inscription_prof', 'inscription_agent', 'inscription_admin'];
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
                if (isset($_SESSION['utilisateur']) && isset($conn)) {
                    $nom = $_SESSION['utilisateur']['Nom'];

                    // ADMIN :
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
                                    $stmt = $conn->prepare("SELECT (SELECT COUNT(*) FROM reservation_etudiant) + (SELECT COUNT(*) FROM reservation_prof) AS total;");
                                    $stmt->execute();
                                    $stmt->bind_result($total);
                                    $stmt->fetch();
                                    $stmt->close();
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
                                    <th>Avis</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                <?php
                                $result = $conn->query("SELECT * FROM materiel WHERE Image_un LIKE '%.jpg'");
                                $users = $result->fetch_all(MYSQLI_ASSOC);
                                ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                                                <img src="../IMG/images/<?= htmlspecialchars($user['Image_un']) ?>" alt="<?= htmlspecialchars($user['Nom']) ?>"
                                                    class="img-fluid rounded" style="max-height: 100px; width: auto;">
                                                <div>
                                                    <p class="mb-1 fw-semibold"><?= htmlspecialchars($user['Nom']) ?></p>
                                                    <p class="mb-1">Date d'achat: <span class="fw-light"><?= htmlspecialchars($user['date_achat']) ?></span>
                                                    </p>
                                                    <p class="mb-0">Prix: <span class="fw-light"><?= htmlspecialchars($user['prix']) ?> €</span></p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-dark text-light p-2 rounded">
                                                <i class="me-2 fa-solid fa-camera"></i><?= htmlspecialchars($user['categorie']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            ☆☆☆☆☆
                                        </td>
                                        <td class="text-center">
                                            <form action="modifier-materiel.php" method="post">
                                                <input type="hidden" name="materiel" value="<?= htmlspecialchars($user['Nom']) ?>">
                                                <button type="submit" name="modif" class="btn">
                                                    <i class="fa-solid fa-pen-to-square fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
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