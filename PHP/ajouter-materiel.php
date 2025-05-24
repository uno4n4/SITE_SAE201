<?php

include 'config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

if (isset($_POST['submit'])) {
    $Nom = htmlspecialchars($_POST['nom']);
    $Description = htmlspecialchars($_POST['description']);
    $Categorie = htmlspecialchars($_POST['categorie']);
    $Prix = htmlspecialchars($_POST['prix']);
    $Quantite = htmlspecialchars($_POST['quantite']);
    $Date_achat = htmlspecialchars($_POST['dateachat']);
    $Disponibilite = htmlspecialchars($_POST['disponibilite']) === 'disponible' ? 1 : 0;

    // Mise à jour du matériel avec PDO
    $sql = "INSERT INTO materiel(Nom, Description_materiel, categorie, date_achat, prix, quantite, disponibilite) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$Nom, $Description, $Categorie, $Date_achat, $Prix, $Quantite, $Disponibilite]);

        echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
                <p class="mb-2">Le matériel a été ajouté</p>
                <button class="btn btn-primary" onclick="fermer()">Fermer</button>
                </div>';
    } catch (PDOException $e) {
        echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <p class="mb-2">Il y a eu une erreur, veuillez réessayer : ' . htmlspecialchars($e->getMessage()) . '</p>
            <button class="btn btn-primary" onclick="fermer()">Fermer</button>
            </div>';
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
    <script src="../JS/reserve.js" defer></script>
    <title>Gestion matériel</title>
</head>

<body>

    <header class="container-fluid px-0">
        <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100">
            <div>
                <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">
            </div>
            <div class="d-flex align-items-center ms-auto gap-2">
                <h6 class="mb-0 text-nowrap text-end">
                    <?php
                    if (isset($_SESSION['utilisateur']) && isset($pdo)) {
                        // Utilisation de PDO pour récupérer le nom et prénom de l'utilisateur
                        $nom = $_SESSION['utilisateur']['Nom'];
                        $prenom = $_SESSION['utilisateur']['Prenom'];


                        // Affichage du nom et prénom ou un message si l'utilisateur n'est pas connecté
                        echo isset($_SESSION['utilisateur']) ? htmlspecialchars($nom) . ' ' . htmlspecialchars($prenom) : 'Utilisateur non connecté';
                    } else {
                        echo 'Utilisateur non connecté';
                    }
                    ?>
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
                            <a href="accueil_admin.php" class="nav-link align-middle px-0">
                                <i class="fa-solid fa-house"></i><span class="ms-1 d-none d-sm-inline">Accueil</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="admin.php" class="nav-link align-middle px-0">
                                <i class="fas fa-tachometer-alt"></i><span class="ms-1 d-none d-sm-inline">Tableau de bord</span>
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
                        <a href="setting.php" class="nav-link align-middle px-0">
                            <i class="fa-solid fa-cogs"></i><span class="ms-1 d-none d-sm-inline">Réglages</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="col py-3 custom-bg d-flex justify-content-lg-start">
                <form class="mx-auto" method="post" action="ajouter-materiel.php">
                    <h2>Ajouter un matériel</h2>
                    <div class="form-grid">
                        <div>
                            <label for="Nom">Nom *</label>
                            <input type="text" name="nom" placeholder="Entrez la catégorie du produit">
                        </div>
                        <div>
                            <label for="description">Description *</label>
                            <input type="text" id="description" name="description" placeholder="Entrez la description produit">
                        </div>
                        <div>
                            <label for="categorie">Catégorie *</label>
                            <input type="text" id="categorie" name="categorie" placeholder="Entrez la catégorie du produit">
                        </div>
                        <div>
                            <label for="date-achat">Date d'achat *</label>
                            <input type="date" id="dateachat" name="dateachat">
                        </div>
                        <div>
                            <label for="prix">Prix *</label>
                            <input type="number" min="0" id="prix" name="prix" value="100">
                        </div>
                        <div>
                            <label for="quantite">Quantite *</label>
                            <input type="number" min="0" id="quantite" name="quantite" value="1">
                        </div>
                        <div>
                            <label for="disponibilite" class="me-3">Disponibilité</label>
                            <input type="text" id="disponibilite" name="disponibilite" value="disponible">
                        </div>

                    </div>
                    <div class="button-container-1">
                        <input type="submit" id="submit" name="submit" value="Enregistrer les changements">
                    </div>
                </form>

            </div>


</body>

</html>